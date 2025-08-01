<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterExpireAtCourseStudents extends Migration
{
    public function up()
    {
        $fields = [
            'expire_at' => [
                'name'  => 'expire_at',
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'graduate',
            ],
        ];

        $this->forge->modifyColumn('course_students', $fields);
    }

    public function down()
    {
        // Sesuaikan isi down() sesuai kondisi awal sebelum migrasi
        $fields = [
            'expire_at' => [
                'name'  => 'expire_at',
                'type'  => 'TIMESTAMP',
                'null'  => false,
                'after' => 'graduate',
            ],
        ];

        $this->forge->modifyColumn('course_students', $fields);
    }
}
