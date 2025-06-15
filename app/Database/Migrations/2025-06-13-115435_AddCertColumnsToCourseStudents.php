<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCertColumnsToCourseStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'cert_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'student_id', // atau sesuaikan posisi kolom
            ],
            'cert_url' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'cert_code',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', ['cert_code', 'cert_url']);
    }
}
