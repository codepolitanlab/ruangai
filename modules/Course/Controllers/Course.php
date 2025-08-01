<?php

namespace Course\Controllers;

use Exception;
use Heroicadmin\Controllers\AdminController;

class Course extends AdminController
{
    public $data = [
        'page_title' => 'Online Class',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];

    public function index()
    {
        // handle form get search
        $search = $this->request->getGet('search') ?: '';

        $this->data['search'] = $search;

        $db                    = \Config\Database::connect();
        $this->data['courses'] = $db->table('courses')
            ->select('courses.*, course_products.normal_price, course_products.price, course_products.duration')
            ->join('course_products', 'course_products.course_id = courses.id', 'left')
            ->where('courses.deleted_at', null)
            ->like('courses.course_title', $search)
            ->groupBy('courses.id, course_products.normal_price, course_products.price, course_products.duration')
            ->get()
            ->getResultArray();

        return view('Course\Views\index', $this->data);
    }

    public function form()
    {
        helper('text'); // Memuat helper untuk membuat slug

        $id = $this->request->getGet('id');
        if ($id) {
            $courseModel    = model('CourseModel');
            $data['course'] = $courseModel->asObject()->find($id);

            if (! $data['course']) {
                session()->setFlashdata('error_message', 'Course tidak ditemukan');

                return redirect()->to(urlScope() . '/course');
            }
            $data['page_title'] = 'Edit Course';
        }

        // Ambil data partners (diasumsikan dari tabel users) untuk dropdown
        $userModel = new \Heroicadmin\Modules\User\Models\UserModel();

        // Anda bisa sesuaikan filter ini, misal user dengan role 'partner'
        $data['partners'] = $userModel->where('deleted_at', null)->asObject()->findAll();

        $this->data = array_merge($this->data, $data);

        return view('Course\Views\form', $this->data);
    }

    public function save()
    {
        helper('text'); // Memuat helper untuk membuat slug
        $id = $this->request->getPost('id');

        // Membuat slug secara otomatis dari judul jika slug kosong
        $slug = $this->request->getPost('slug') ?: url_title($this->request->getPost('course_title'), '-', true);

        // Menyiapkan data berdasarkan struktur tabel
        $data = [
            'course_title'        => $this->request->getPost('course_title'),
            'slug'                => $slug,
            'description'         => $this->request->getPost('description'),
            'partner_id'          => $this->request->getPost('partner_id'),
            'level'               => $this->request->getPost('level'),
            'status'              => $this->request->getPost('status'),
            'tags'                => $this->request->getPost('tags'),
            'cover'               => $this->request->getPost('cover'),
            'total_module'        => $this->request->getPost('total_module'),
            'thumbnail'           => $this->request->getPost('thumbnail'),
            'landing_url'         => $this->request->getPost('landing_url'),
            'group_whatsapp'      => $this->request->getPost('group_whatsapp'),
            'course_order'        => $this->request->getPost('course_order'),
            'current_batch_id'    => $this->request->getPost('current_batch_id'),
            'bunny_collection_id' => $this->request->getPost('bunny_collection_id'),
            'last_update'         => $this->request->getPost('last_update') ?: null,
            'premium'             => $this->request->getPost('premium') ? 1 : 0,
            'has_modules'         => $this->request->getPost('has_modules') ? 1 : 0,
            'has_live_sessions'   => $this->request->getPost('has_live_sessions') ? 1 : 0,
        ];

        $courseModel = model('CourseModel');

        try {
            if ($id) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $courseModel->update($id, $data);
            } else {
                $courseModel->insert($data);
                $id = $courseModel->getInsertID();
            }

            session()->setFlashdata('success_message', 'Data course berhasil disimpan');

            if ($this->request->getPost('save_and_exit')) {
                return redirect()->to(urlScope() . '/course');
            }

            return redirect()->to(urlScope() . '/course/form?id=' . $id);
        } catch (Exception $e) {
            session()->setFlashdata('error_message', 'Terjadi kesalahan: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function delete()
    {
        $id          = $this->request->getPost('id');
        $courseModel = model('CourseModel');
        $courseModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');

        return redirect()->to(urlScope() . '/course');
    }
}
