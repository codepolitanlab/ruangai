<?php

namespace Mahasiswa\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mhs_mahasiswa';
    protected $allowedFields = ['nama', 'nomor_induk', 'jenis_kelamin', 'jurusan_id'];

    public function getFiltered($filters = [])
    {
        $builder = $this->select('mhs_mahasiswa.*, mhs_jurusan.nama_jurusan')
            ->join('mhs_jurusan', 'mhs_jurusan.id = mhs_mahasiswa.jurusan_id');

        if (! empty($filters['nama'])) {
            $builder->like('mhs_mahasiswa.nama', $filters['nama']);
        }
        if (! empty($filters['nomor_induk'])) {
            $builder->like('mhs_mahasiswa.nomor_induk', $filters['nomor_induk']);
        }
        if (! empty($filters['jenis_kelamin'])) {
            $builder->where('mhs_mahasiswa.jenis_kelamin', $filters['jenis_kelamin']);
        }
        if (! empty($filters['jurusan_id'])) {
            $builder->where('mhs_mahasiswa.jurusan_id', $filters['jurusan_id']);
        }

        return $builder;
    }
}
