<?php

namespace Shortener\Controllers;

use Heroicadmin\Controllers\AdminController;
use Heroicadmin\Modules\Entry\Entry;
use Symfony\Component\Yaml\Yaml;

class Shortener extends AdminController
{
    protected $Entry;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Shortener';
        $this->data['module']     = 'shortener';
        $this->data['submodule']  = 'shortener';

        $schema = <<<'YAML'
            name: shortener
            title: Shortener
            base_url: /shortener
            description: Shortener
            icon: people
            table: shorteners
            show_on_table: [title, code, destination, created_at]
            hideable: [title, code, destination, created_at]
            searchable: [title, code, destination]
            sortable: [title, code, destination, created_at]
            default_sorting: [id,asc]
            rowsPerPage: 10
            fields:
                id:    
                    name: id
                    label: ID
                title:
                    name: title
                    type: text
                    label: Title
                    rules: required
                code:
                    name: code
                    type: text
                    label: Code
                    rules: required
                destination:
                    name: destination
                    type: text
                    label: Destination
                    rules: required
                created_at:
                    name: created_at
                    type: datetime
                    label: Created At
                updated_at:
                    name: updated_at
                    type: datetime
                    label: Updated At
                deleted_at:
                    name: deleted_at
                    type: datetime
                    label: Deleted At
            YAML;
        $this->Entry = new Entry(Yaml::parse($schema));
        // dd($this->Entry);
    }

    public function index()
    {
        // Response with table body via ajax
        if ($this->request->getGet('tableBody')) {
            return $this->Entry->tableBody();
        }

        // Deliver table template
        $this->data['table'] = $this->Entry->table();

        return view('Shortener\Views\shortener\index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = 'Tambah Shortener';

        // Insert postdata
        if ($postData = $this->request->getPost()) {
            $id = $this->Entry->insert($postData);
            if (! $id) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/shortener');
            }

            return redirect()->to(urlScope() . '/shortener/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form();

        return view('Shortener\Views\shortener\form', $this->data);
    }

    public function edit($id)
    {
        $this->data['page_title'] = 'Edit Shortener';

        // Update postdata
        if ($postData = $this->request->getPost()) {
            $result = $this->Entry->update($id, $postData);
            if (! $result) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/shortener');
            }

            return redirect()->to(urlScope() . '/shortener/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form($id);

        return view('Shortener\Views\shortener\form', $this->data);
    }

    public function delete($id)
    {
        $this->Entry->delete($id);

        return redirect()->to(urlScope() . '/shortener');
    }
}
