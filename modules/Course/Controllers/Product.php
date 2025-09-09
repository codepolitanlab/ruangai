<?php

namespace Course\Controllers;

use Course\Models\CourseProductModel;
use Heroicadmin\Controllers\AdminController;

class Product extends AdminController
{
    public $data = [
        'page_title' => 'Product',
        'module'     => 'product',
        'submodule'  => 'course_product',
    ];

    public function index()
    {
        // Definisikan field yang bisa difilter
        $filterFields = [
            'course_title' => 'courses.course_title',
            'title'        => 'title',
            'subtitle'     => 'subtitle',
            'duration'     => 'duration',
        ];

        $filters = [];

        // Ambil semua filter dari URL secara dinamis
        foreach ($filterFields as $param => $field) {
            $filterValue = $this->request->getGet('filter_' . $param);
            if ($filterValue) {
                $filters[$field] = $filterValue;
            }
            // Simpan nilai filter untuk ditampilkan kembali di form
            $data['filter_' . $param] = $filterValue;
        }

        $courseProductsModel = new CourseProductModel();
        $per_page            = 10;
        $current_page        = $this->request->getGet('page') ?? 1;

        // Buat query dasar + join courses
        $baseQuery = $courseProductsModel
            ->where('course_products.deleted_at', null)
            ->join('courses', 'courses.id = course_products.course_id')
            ->select('course_products.*, courses.course_title');

        // Terapkan filter
        foreach ($filters as $field => $value) {
            $baseQuery->like($field, $value);
        }

        // Clone query sebelum pagination
        $totalQuery = clone $baseQuery;

        // Data paginasi
        $data['courseProducts'] = $baseQuery
            ->orderBy('id', 'desc')
            ->asObject()
            ->paginate($per_page);

        $data['pager'] = $courseProductsModel->pager;

        // Hitung total
        if (! empty($filters)) {
            $data['total_course'] = count($data['courseProducts']);
        } else {
            $data['total_course'] = $totalQuery->countAllResults();
        }

        $data['current_page'] = $current_page;
        $data['per_page']     = $per_page;
        $this->data           = array_merge($this->data, $data);

        return pageView('Course\Views\product\index', $this->data);
    }

    public function checkout($product_id)
    {
        // Get course product
        $db            = \Config\Database::connect();
        $courseProduct = $db->table('course_products')->where('id', $product_id)->get()->getResultArray();

        // Show 404
        if (! $courseProduct) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $courseProduct[0]['type'] = 'course';

        // Kita akan gunakan diskon di summary (bukan di produk)
        // Jadi di list produk tidak pakai diskon
        $courseProduct[0]['price'] = $courseProduct[0]['normal_price'];

        // Request payment url
        $CPCheckout = new \App\Libraries\CPCheckout();
        $response   = $CPCheckout->getCheckoutUrl($courseProduct, [], [
            'discount'             => $courseProduct[0]['discount'],
            'exp_duration'         => $courseProduct[0]['exp_duration'] ?? 86400,
            'success_redirect_url' => site_url('courses/program/ethical_hacking/success'),
        ]);

        if (! isset($response['url'])) {
            throw new \Exception('Gagal membuat checkout URL');
        }

        header('Location: ' . $response['url']);

        exit();
    }

    public function form($id = null)
    {
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

                return redirect()->to(urlScope() . '/course/product');
            }

            $data['page_title'] = 'Edit Course Product';
        }

        // Ambil data courses untuk dropdown
        $db              = \Config\Database::connect();
        $data['courses'] = $db->table('courses')
            ->get()
            ->getResult();

        $this->data = array_merge($this->data, $data);

        return pageView('Course\Views\product\form', $this->data);
    }

    public function save($id = null)
    {
        $data = [
            'course_id'    => $this->request->getPost('course_id'),
            'title'        => $this->request->getPost('title'),
            'subtitle'     => $this->request->getPost('subtitle'),
            'duration'     => $this->request->getPost('duration'),
            'normal_price' => $this->request->getPost('normal_price'),
            'price'        => $this->request->getPost('price'),
            'discount'     => $this->request->getPost('discount'),
            'description'  => $this->request->getPost('description'),
            'exp_duration' => $this->request->getPost('exp_duration'),
        ];

        $courseProductModel = new \Course\Models\CourseProductModel();

        try {
            if ($id) {
                $courseProductModel->update($id, $data);
            } else {
                $courseProductModel->insert($data);
            }
            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to(urlScope() . '/course/product');
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();

            exit();
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        $courseProductModel = new \Course\Models\CourseProductModel();
        $courseProductModel->where('id', $id)->delete();
        session()->setFlashdata('success', 'Data berhasil dihapus');

        return redirect()->to(urlScope() . '/course/product');
    }
}
