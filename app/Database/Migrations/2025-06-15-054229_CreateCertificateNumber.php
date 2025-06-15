<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificateNumber extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'cert_number' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'cert_url', // atau sesuaikan posisi kolom
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', ['cert_number']);
    }
}
