<?php

namespace Mahasiswa\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table         = 'mhs_jurusan';
    protected $allowedFields = ['kode_jurusan', 'nama_jurusan'];
}
