<?php

namespace Mahasiswi\Controllers;

use Heroicadmin\Controllers\AdminController;
use Heroicadmin\Modules\Entry\Entry;
use Symfony\Component\Yaml\Yaml;

class Jurusan extends AdminController
{
    protected $Entry;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Jurusan';
        $this->data['module']     = 'mahasiswi';
        $this->data['submodule']  = 'jurusan';

        $this->Entry = new Entry(Yaml::parseFile(__DIR__ . '/../Entries/jurusan.yml'));
    }

    public function index()
    {
        // Response with table body via ajax
        if ($this->request->getGet('tableBody')) {
            return $this->Entry->tableBody();
        }

        // Deliver table template
        $this->data['table'] = $this->Entry->table();

        return view('Mahasiswi\Views\jurusan\index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = 'Tambah Jurusan';

        // Insert postdata
        if ($postData = $this->request->getPost()) {
            $id = $this->Entry->insert($postData);
            if (! $id) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(admin_url() . 'mahasiswi/jurusan');
            }

            return redirect()->to(admin_url() . 'mahasiswi/jurusan/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form();

        return view('Mahasiswi\Views\jurusan\form', $this->data);
    }

    public function edit($id)
    {
        $this->data['page_title'] = 'Edit Jurusan';

        // Update postdata
        if ($postData = $this->request->getPost()) {
            $result = $this->Entry->update($id, $postData);
            if (! $result) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(admin_url() . 'mahasiswi/jurusan');
            }

            return redirect()->to(admin_url() . 'mahasiswi/jurusan/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form($id);

        return view('Mahasiswi\Views\jurusan\form', $this->data);
    }

    public function delete($id)
    {
        $this->Entry->delete($id);

        return redirect()->to(admin_url() . 'mahasiswi/jurusan');
    }
}
