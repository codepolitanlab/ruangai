<?php

namespace App\Pages\zpanel\products\course\form;

use App\Pages\zpanel\AdminController;
use Exception;

class PageController extends AdminController
{
    public $data = [
        'page_title' => 'Course Product Form',
        'module'     => 'product',
        'submodule'  => 'course',
    ];

    public function getIndex()
    {
        // Ambil ID dari URL jika ada
        $id = $this->request->getGet('id');
        if ($id) {
            // Mode Edit: Ambil data course product beserta profilenya
            $courseProductModel     = new \Course\Models\CourseProductModel();
            $data['course_product'] = $courseProductModel->select('course_products.*, courses.course_title')
                ->join('courses', 'courses.id = course_products.course_id', 'left')
                ->where('course_products.id', $id)
                ->where('course_products.deleted_at', null)
                ->asObject()
                ->first();

            if (! $data['course_product']) {
                session()->setFlashdata('error', 'Course Product tidak ditemukan');

                return redirect()->to('/zpanel/products/course');
            }

            $data['page_title'] = 'Edit Course Product';
        }

        // Ambil data courses untuk dropdown
        $db              = \Config\Database::connect();
        $data['courses'] = $db->table('courses')
            ->get()
            ->getResult();

        $this->data = array_merge($this->data, $data);

        return pageView('zpanel/products/course/form/index', $this->data);
    }

    public function postIndex()
    {
        $id = $this->request->getPost('id');

        $normalPrice = (int) $this->request->getPost('normal_price');
        $price       = (int) $this->request->getPost('price');
        // Expire duration diinput dalam menit, disimpan dalam satuan detik
        $expMinutes  = (int) $this->request->getPost('exp_duration');
        $status      = $this->request->getPost('status');

        $data = [
            'course_id'    => $this->request->getPost('course_id'),
            'title'        => $this->request->getPost('title'),
            'subtitle'     => $this->request->getPost('subtitle'),
            'duration'     => $this->request->getPost('duration'),
            'normal_price' => $normalPrice,
            'price'        => $price,
            // Diskon dihitung otomatis: normal price - price
            'discount'     => max(0, $normalPrice - $price),
            'description'  => $this->request->getPost('description'),
            'exp_duration' => $expMinutes * 60,
            'status'       => $status === null ? 1 : (int) $status,
        ];

        $courseProductModel = new \Course\Models\CourseProductModel();

        try {
            if ($id) {
                $courseProductModel->update($id, $data);
            } else {
                $courseProductModel->insert($data);
            }
            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to('/zpanel/products/course');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();

            exit();
        }
    }

    public function postDelete()
    {
        $id                 = $this->request->getPost('id');
        $courseProductModel = new \Course\Models\CourseProductModel();
        $courseProductModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        session()->setFlashdata('success', 'Data berhasil dihapus');

        return redirect()->to('/zpanel/products/course');
    }
}
