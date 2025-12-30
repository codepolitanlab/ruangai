<?php

namespace Mahasiswi\Migrations;

use CodeIgniter\Database\Migration;

class CreateMahasiswiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode_jurusan' => ['type' => 'VARCHAR', 'constraint' => '10'],
            'nama_jurusan' => ['type' => 'VARCHAR', 'constraint' => '100'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mhs_jurusan');

        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => '100'],
            'nomor_induk'   => ['type' => 'VARCHAR', 'constraint' => '20'],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'jurusan_id'    => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('jurusan_id', 'mhs_jurusan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mhs_mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('mhs_mahasiswa');
        $this->forge->dropTable('mhs_jurusan');
    }
}
