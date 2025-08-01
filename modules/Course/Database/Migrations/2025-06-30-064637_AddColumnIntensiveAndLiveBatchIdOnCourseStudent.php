<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnIntensiveAndLiveBatchIdOnCourseStudent extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'join_intensive' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'live_attended',
            ],
            'live_batch_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => null,
                'null'       => true,
                'after'      => 'join_intensive',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', ['join_intensive', 'live_batch_id']);
    }
}
