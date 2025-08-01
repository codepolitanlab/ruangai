<?php

namespace App\Pages\zpanel\events\form;

use App\Controllers\BaseController;
use Exception;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Events Form';

        // Ambil ID dari URL jika ada
        $id = $this->request->getGet('id');
        if ($id) {
            // Mode Edit: Ambil data scholarship
            $eventsModel   = new \App\Models\Events();
            $data['event'] = $eventsModel->where('id', $id)
                ->where('deleted_at', null)
                ->asObject()
                ->first();

            if (! $data['event']) {
                session()->setFlashdata('error', 'Data tidak ditemukan');

                return redirect()->to('/zpanel/events');
            }

            $data['page_title'] = 'Edit Events';
        }

        return pageView('zpanel/events/form/index', $data);
    }

    public function postIndex()
    {
        $id = $this->request->getPost('id');

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->request->getPost('title'))));
        $data = [
            'title'         => $this->request->getPost('title'),
            'slug'          => $slug,
            'code'          => $this->request->getPost('code'),
            'description'   => $this->request->getPost('description'),
            'date_start'    => $this->request->getPost('date_start'),
            'date_end'      => $this->request->getPost('date_end'),
            'quota'         => $this->request->getPost('quota'),
            'organizer'     => $this->request->getPost('organizer'),
            'telegram_link' => $this->request->getPost('telegram_link'),
            'status'        => $this->request->getPost('status'),
            'banner_image'  => $this->request->getPost('banner_image'),
        ];

        $eventsModel = new \App\Models\Events();

        try {
            if ($id) {
                // Update data
                $data['updated_at'] = date('Y-m-d H:i:s');
                $eventsModel->update($id, $data);
            } else {
                // Insert data baru
                $data['created_at'] = date('Y-m-d H:i:s');
                $eventsModel->insert($data);
            }

            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to('/zpanel/events');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function postDelete()
    {
        $id          = $this->request->getPost('id');
        $eventsModel = new \App\Models\Events();

        try {
            $eventsModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/zpanel/events');
    }
}
