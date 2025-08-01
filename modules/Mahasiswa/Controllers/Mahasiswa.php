<?php

namespace Mahasiswa\Controllers;

use Heroicadmin\Controllers\AdminController;
use Mahasiswa\Models\JurusanModel;
use Mahasiswa\Models\MahasiswaModel;

class Mahasiswa extends AdminController
{
    protected $mahasiswaModel;
    protected $jurusanModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Mahasiswa';
        $this->data['module']     = 'mahasiswa';
        $this->data['submodule']  = 'mahasiswa';

        $this->mahasiswaModel = new MahasiswaModel();
        $this->jurusanModel   = new JurusanModel();
    }

    public function index()
    {
        $data['jurusan'] = $this->jurusanModel->findAll(); // Jika masih butuh dropdown jurusan

        $this->data = array_merge($this->data, $data);

        // return view('Mahasiswa\Views\mahasiswa\index', $this->data);
        return view('Mahasiswa\Views\mahasiswa\table', $this->data);
    }

    public function table()
    {
        $filters = $this->request->getGet('filter') ?? [];
        $visible = $this->request->getGet('visible') ?? [];
        $page    = max(1, (int) $this->request->getGet('page'));
        $perPage = $this->request->getGet('perpage') ?? 5;

        $builder = $this->mahasiswaModel->builder();
        $builder->join('mhs_jurusan', 'mhs_jurusan.id = mhs_mahasiswa.jurusan_id', 'left');

        // Select by chosen visible
        $select[] = 'mhs_mahasiswa.id'; // minimal satu kolom
        if (! empty($visible['nama'])) {
            $select[] = 'mhs_mahasiswa.nama';
        }
        if (! empty($visible['nomor_induk'])) {
            $select[] = 'mhs_mahasiswa.nomor_induk';
        }
        if (! empty($visible['jenis_kelamin'])) {
            $select[] = 'mhs_mahasiswa.jenis_kelamin';
        }
        if (! empty($visible['nama_jurusan'])) {
            $select[] = 'mhs_jurusan.nama_jurusan';
        }
        $builder->select(implode(',', $select));

        // Filter by chosen
        foreach ($filters as $ffield => $fvalue) {
            if (! empty($fvalue)) {
                if (strpos($fvalue, '|') === false) {
                    $builder->like($ffield, $fvalue);
                } else {
                    $temp     = explode('|', $fvalue);
                    $operator = $temp[0];
                    $fvalue   = trim($temp[1]);
                    $builder->where($ffield . ' ' . $operator, $fvalue);
                }
            }
        }

        // Hitung total
        $total = $builder->countAllResults(false);
        $builder->limit($perPage, ($page - 1) * $perPage);
        $data['mahasiswa'] = $builder->get()->getResultArray();

        $data['currentPage'] = $page;
        $data['totalPages']  = ceil($total / $perPage);
        $data['visible']     = $visible;

        return view('Mahasiswa\Views\mahasiswa\_table_body', $data);
    }

    public function datatables()
    {
        $request = service('request');
        $db      = \Config\Database::connect();
        $builder = $db->table('mhs_mahasiswa');
        $builder->select('mhs_mahasiswa.*, mhs_jurusan.nama_jurusan');
        $builder->join('mhs_jurusan', 'mhs_jurusan.id = mhs_mahasiswa.jurusan_id', 'left');

        // Kolom yang bisa difilter dan disortir
        $columns = [
            'mhs_mahasiswa.nama',
            'mhs_mahasiswa.nomor_induk',
            'mhs_mahasiswa.jenis_kelamin',
            'mhs_jurusan.nama_jurusan',
        ];

        // Total semua data (tanpa filter)
        $totalRecords = $db->table('mhs_mahasiswa')->countAll();

        // Filter per kolom (jika ada)
        $filters   = $request->getPost('columns_filter');
        $hasFilter = false;

        if ($filters && is_array($filters)) {
            foreach ($filters as $i => $val) {
                if (! empty($val) && isset($columns[$i])) {
                    $hasFilter = true;
                    break;
                }
            }

            if ($hasFilter) {
                $builder->groupStart();

                foreach ($filters as $i => $val) {
                    if (! empty($val) && isset($columns[$i])) {
                        $builder->like($columns[$i], $val);
                    }
                }
                $builder->groupEnd();
            }
        }

        // Hitung total setelah filter
        $recordsFiltered = $builder->countAllResults(false);

        // Sorting
        $order = $request->getPost('order');
        if ($order) {
            $columnIndex = (int) $order[0]['column'];
            $dir         = $order[0]['dir'] ?? 'asc';
            if (isset($columns[$columnIndex])) {
                $builder->orderBy($columns[$columnIndex], $dir);
            }
        }

        // Pagination
        $start  = (int) $request->getPost('start') ?? 0;
        $length = (int) $request->getPost('length') ?? 10;
        $builder->limit($length, $start);

        // Ambil data
        $data = $builder->get()->getResultArray();

        // Format data untuk DataTables
        $result = [];

        foreach ($data as $row) {
            $result[] = [
                'nama'          => esc($row['nama']),
                'nomor_induk'   => esc($row['nomor_induk']),
                'jenis_kelamin' => esc($row['jenis_kelamin']),
                'nama_jurusan'  => esc($row['nama_jurusan']),
                'aksi'          => '
                <a class="btn btn-sm btn-outline-success me-1" href="' . site_url(urlScope() . '/mahasiswa/edit/' . $row['id']) . '">Edit</a>
                <a class="btn btn-sm btn-outline-danger" href="' . site_url(urlScope() . '/mahasiswa/delete/' . $row['id']) . '" onclick="return confirm(\'Yakin?\')">Hapus</a>',
            ];
        }

        return $this->response->setJSON([
            'draw'            => (int) $request->getPost('draw'),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $result,
        ]);
    }

    public function create()
    {
        $data['jurusan'] = $this->jurusanModel->findAll();

        $this->data = array_merge($this->data, $data);

        return view('Mahasiswa\Views\mahasiswa\create', $this->data);
    }

    public function store()
    {
        $this->mahasiswaModel->save($this->request->getPost());

        return redirect()->to(urlScope() . '/mahasiswa');
    }

    public function edit($id)
    {
        $data['mahasiswa'] = $this->mahasiswaModel->find($id);
        $data['jurusan']   = $this->jurusanModel->findAll();

        $this->data = array_merge($this->data, $data);

        return view('Mahasiswa\Views\mahasiswa\edit', $this->data);
    }

    public function update($id)
    {
        $this->mahasiswaModel->update($id, $this->request->getPost());

        return redirect()->to(urlScope() . '/mahasiswa');
    }

    public function delete($id)
    {
        $this->mahasiswaModel->delete($id);

        return redirect()->to(urlScope() . '/mahasiswa');
    }
}
