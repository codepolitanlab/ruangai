<?php

namespace Classroom\Controllers;

use Classroom\Models\ClassProductModel;
use Heroicadmin\Controllers\AdminController;

class Product extends AdminController
{
    protected $db;

    public function __construct()
    {
        $this->data['page_title'] = 'Product Kelas';
        $this->data['module']     = 'product';
        $this->data['submodule']  = 'classroom_product';

        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Field yang bisa difilter
        $filterFields = [
            'class_name' => 'cls_classes.name',
            'title'      => 'title',
            'subtitle'   => 'subtitle',
            'duration'   => 'duration',
        ];

        $filters = [];

        // Ambil filter dari URL secara dinamis
        foreach ($filterFields as $param => $field) {
            $filterValue = $this->request->getGet('filter_' . $param);
            if ($filterValue) {
                $filters[$field] = $filterValue;
            }
            // Simpan nilai filter untuk ditampilkan kembali di form
            $data['filter_' . $param] = $filterValue;
        }

        $productModel = new ClassProductModel();
        $per_page     = 10;
        $current_page = $this->request->getGet('page') ?? 1;

        // Query dasar + join kelas
        $baseQuery = $productModel
            ->where('cls_products.deleted_at', null)
            ->join('cls_classes', 'cls_classes.id = cls_products.class_id')
            ->select('cls_products.*, cls_classes.name AS class_name');

        // Terapkan filter
        foreach ($filters as $field => $value) {
            $baseQuery->like($field, $value);
        }

        // Clone query sebelum pagination
        $totalQuery = clone $baseQuery;

        // Data paginasi
        $data['classProducts'] = $baseQuery
            ->orderBy('cls_products.id', 'desc')
            ->asObject()
            ->paginate($per_page);

        $data['pager'] = $productModel->pager;

        // Hitung total
        if (! empty($filters)) {
            $data['total_product'] = count($data['classProducts']);
        } else {
            $data['total_product'] = $totalQuery->countAllResults();
        }

        $data['current_page'] = $current_page;
        $data['per_page']     = $per_page;
        $this->data           = array_merge($this->data, $data);

        return view('Classroom\Views\product\index', $this->data);
    }

    public function checkout($product_id)
    {
        // Get class product
        $classProduct = $this->db->table('cls_products')
            ->where('id', $product_id)
            ->where('deleted_at IS NULL')
            ->get()
            ->getResultArray();

        // Show 404
        if (! $classProduct) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Hanya produk aktif yang boleh di-checkout
        if ((int) ($classProduct[0]['status'] ?? 0) !== 1) {
            session()->setFlashdata('error', 'Produk tidak aktif, tidak dapat di-checkout');

            return redirect()->to(urlScope() . '/classroom/products');
        }

        $classProduct[0]['type'] = 'classroom';

        // Diskon dipakai di summary (bukan di produk), jadi di list produk tidak pakai diskon
        $classProduct[0]['price'] = $classProduct[0]['normal_price'];

        // Request payment url
        $CPCheckout = new \App\Libraries\CPCheckout();
        $response   = $CPCheckout->getCheckoutUrl($classProduct, [], [
            'discount'             => $classProduct[0]['discount'],
            'exp_duration'         => $classProduct[0]['exp_duration'] ?? 86400,
            'success_redirect_url' => site_url('bootcamp'),
        ]);

        if (! isset($response['url'])) {
            throw new \Exception('Gagal membuat checkout URL');
        }

        header('Location: ' . $response['url']);

        exit();
    }

    public function form($id = null)
    {
        $data['class_product'] = null;

        if ($id) {
            // Mode Edit: ambil data class product beserta nama kelas
            $productModel           = new ClassProductModel();
            $data['class_product']  = $productModel->select('cls_products.*, cls_classes.name AS class_name')
                ->join('cls_classes', 'cls_classes.id = cls_products.class_id', 'left')
                ->where('cls_products.id', $id)
                ->where('cls_products.deleted_at', null)
                ->asObject()
                ->first();

            if (! $data['class_product']) {
                session()->setFlashdata('error', 'Product Kelas tidak ditemukan');

                return redirect()->to(urlScope() . '/classroom/products');
            }

            $data['page_title'] = 'Edit Product Kelas';
        }

        // Ambil data kelas untuk dropdown
        $data['classes'] = $this->db->table('cls_classes')
            ->select('id, name, status')
            ->where('deleted_at IS NULL')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();

        $this->data = array_merge($this->data, $data);

        return view('Classroom\Views\product\form', $this->data);
    }

    public function save($id = null)
    {
        $normalPrice = (int) $this->request->getPost('normal_price');
        $price       = (int) $this->request->getPost('price');
        // Expire duration diinput dalam menit, disimpan dalam satuan detik
        $expMinutes  = (int) $this->request->getPost('exp_duration');
        $status      = $this->request->getPost('status');

        $data = [
            'class_id'     => $this->request->getPost('class_id'),
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

        $productModel = new ClassProductModel();

        try {
            if ($id) {
                $productModel->update($id, $data);
            } else {
                $productModel->insert($data);
            }
            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to(urlScope() . '/classroom/products');
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();

            exit();
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        $productModel = new ClassProductModel();
        $productModel->where('id', $id)->delete();
        session()->setFlashdata('success', 'Data berhasil dihapus');

        return redirect()->to(urlScope() . '/classroom/products');
    }
}
