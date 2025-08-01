<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateColumnProgressUpdateStudent extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'progress_update' => [
                'type'  => 'TIMESTAMP',
                'null'  => true,
                'after' => 'progress',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', ['progress_update']);
    }
}
