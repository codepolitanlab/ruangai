<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnExpireAtToCourseStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'expire_at' => [
                'type'  => 'timestamp',
                'null'  => true,
                'after' => 'graduate',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', ['expire_at']);
    }
}
