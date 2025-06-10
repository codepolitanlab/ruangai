<?php

namespace App\Pages\zpanel\events;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = "Events";

        // Definisikan field yang bisa difilter
        $filterFields = ['title' => 'title', 'code' => 'code', 'description' => 'description', 'quota' => 'quota', 'status' => 'status'];
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

        // Ambil model Users
        $eventsModel = new \App\Models\Events();

        // Set jumlah item per halaman
        $per_page = 10;

        // Ambil current page dari URL, default 1
        $current_page = $this->request->getGet('page') ?? 1;

        // Buat query dasar
        $baseQuery = $eventsModel->where('deleted_at', null);

        // Terapkan semua filter yang aktif
        foreach ($filters as $field => $value) {
            $baseQuery->like($field, $value);
        }

        // Ambil data paginasi dengan output array object
        $data['events'] = $baseQuery
            ->orderBy('created_at', 'DESC')
            ->asObject()
            ->paginate($per_page);

        // Simpan pager untuk ditampilkan di view
        $data['pager'] = $eventsModel->pager;

        // Jika ada query filter yang aktif, hitung total data yang sesuai
        if (!empty($filters)) {
            $data['total_events'] = count($data['events']);
        } else {
            // Jika tidak ada filter, hitung total data secara keseluruhan
            $data['total_events'] = $eventsModel->countAllResults();
        }

        // Tambahkan current_page dan per_page ke data
        $data['current_page'] = $current_page;
        $data['per_page'] = $per_page;

        return pageView('zpanel/events/index', $data);
    }
}
