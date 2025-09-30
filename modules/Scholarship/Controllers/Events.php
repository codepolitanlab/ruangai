<?php

namespace Scholarship\Controllers;

use Heroicadmin\Controllers\AdminController;
use Heroicadmin\Modules\Entry\Entry;
use Symfony\Component\Yaml\Yaml;

class Events extends AdminController
{
    protected $Entry;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Events';
        $this->data['module']     = 'events';
        $this->data['submodule']  = 'events';

        $schema = <<<'YAML'
            name: events
            title: Events
            base_url: /scholarship/events
            description: Events
            icon: people
            table: events
            show_on_table: [ title, slug, code, description, date_start, date_end, quota, total_participant, organizer, telegram_link, status, publish_at, is_featured, banner_image]
            hideable: [ title, slug, code, description, date_start, date_end, quota, total_participant, organizer, telegram_link, status, publish_at, is_featured, banner_image]
            searchable: [ title, slug, code, description, date_start, date_end, quota, total_participant, organizer, telegram_link, status, publish_at, is_featured, banner_image]
            sortable: [ title, slug, code, description, date_start, date_end, quota, total_participant, organizer, telegram_link, status, publish_at, is_featured, banner_image]
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
                slug:
                    name: slug
                    type: text
                    label: Slug
                    rules: required
                code:
                    name: code
                    type: text
                    label: Code
                    rules: required
                description:
                    name: description
                    type: text
                    label: Description
                    rules: required
                date_start:
                    name: date_start
                    type: date
                    label: date_start
                    rules: required
                date_end:
                    name: date_end
                    type: date
                    label: date_end
                    rules: required
                quota:
                    name: quota
                    type: text
                    label: quota
                    rules: required
                total_participant:
                    name: total_participant
                    type: text
                    label: total_participant
                    rules: required
                organizer:
                    name: organizer
                    type: text
                    label: organizer
                    rules: required
                telegram_link:
                    name: telegram_link
                    type: text
                    label: telegram_link
                    rules: required
                status:
                    name: status
                    type: text
                    label: status
                    rules: required
                publish_at:
                    name: publish_at
                    type: date
                    label: publish_at
                    rules: required
                is_featured:
                    name: is_featured
                    type: text
                    label: is_featured
                    rules: required
                banner_image:
                    name: banner_image
                    type: text
                    label: banner_image
                    rules: required
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

        return view('Scholarship\Views\events\index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = 'Tambah Events';

        // Insert postdata
        if ($postData = $this->request->getPost()) {
            $id = $this->Entry->insert($postData);
            if (! $id) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/scholarship/events');
            }

            return redirect()->to(urlScope() . '/scholarship/events/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form();

        return view('Scholarship\Views\events\form', $this->data);
    }

    public function edit($id)
    {
        $this->data['page_title'] = 'Edit events';

        // Update postdata
        if ($postData = $this->request->getPost()) {
            $result = $this->Entry->update($id, $postData);
            if (! $result) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/scholarship/events');
            }

            return redirect()->to(urlScope() . '/scholarship/events/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form($id);

        return view('Scholarship\Views\events\form', $this->data);
    }

    public function delete($id)
    {
        $this->Entry->delete($id);

        return redirect()->to(urlScope() . '/scholarship/events');
    }
}
