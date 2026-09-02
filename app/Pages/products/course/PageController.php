<?php

namespace App\Pages\zpanel\products\course;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController
{
    public $data = [
        'page_title' => 'Product',
        'module'     => 'product',
        'submodule'  => 'course',
    ];

    public function getIndex()
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

        $courseProductsModel = new \App\Models\CourseProducts();
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

        return pageView('zpanel/products/course/index', $this->data);
    }

    public function getCheckout()
    {
        $product_id = $this->request->getGet('id');

        // Get course product
        $db            = \Config\Database::connect();
        $courseProduct = $db->table('course_products')->where('id', $product_id)->get()->getResultArray();

        // Show 404
        if (! $courseProduct) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Hanya produk aktif yang boleh di-checkout
        if ((int) ($courseProduct[0]['status'] ?? 0) !== 1) {
            session()->setFlashdata('error', 'Produk tidak aktif, tidak dapat di-checkout');

            return redirect()->to('/zpanel/products/course');
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
}
