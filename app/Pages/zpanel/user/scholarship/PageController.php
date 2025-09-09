<?php

namespace App\Pages\zpanel\user\scholarship;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Scholarship';

        // Definisikan field yang bisa difilter
        $filterFields = ['fullname' => 'fullname', 'email' => 'email', 'status' => 'status', 'program' => 'program'];
        $filters      = [];

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
        $scholarshipModel = new \App\Models\ScholarshipParticipantModel();

        // Set jumlah item per halaman
        $per_page = 10;

        // Ambil current page dari URL, default 1
        $current_page = $this->request->getGet('page') ?? 1;

        // Buat query dasar
        $baseQuery = $scholarshipModel->where('deleted_at', null);

        // Terapkan semua filter yang aktif
        foreach ($filters as $field => $value) {
            $baseQuery->like($field, $value);
        }

        // Ambil data paginasi dengan output array object
        $data['scholarships'] = $baseQuery
            ->orderBy('created_at', 'DESC')
            ->asObject()
            ->paginate($per_page);

        // Simpan pager untuk ditampilkan di view
        $data['pager'] = $scholarshipModel->pager;

        // Jika ada query filter yang aktif, hitung total data yang sesuai
        if (! empty($filters)) {
            $data['total_users'] = count($data['scholarships']);
        } else {
            // Jika tidak ada filter, hitung total data secara keseluruhan
            $data['total_users'] = $scholarshipModel->countAllResults();
        }

        // Tambahkan current_page dan per_page ke data
        $data['current_page'] = $current_page;
        $data['per_page']     = $per_page;

        return pageView('zpanel/user/scholarship/index', $data);
    }

    public function getExport()
    {
        $participantModel = new \App\Models\ParticipantViewModel();

        // Ambil semua data dari view
        $participants = $participantModel->findAll();

        // Nama file export
        $filename = "Participants_" . date('Y-m-d_His') . ".csv";

        // Header untuk download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; charset=utf-8");

        $file = fopen('php://output', 'w');

        if (!empty($participants)) {
            // Tulis header (nama kolom otomatis dari array keys)
            fputcsv($file, array_keys($participants[0]));

            // Tulis data
            foreach ($participants as $row) {
                fputcsv($file, $row);
            }
        }

        fclose($file);
        exit;
    }
}
