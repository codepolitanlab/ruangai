<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMandatoryToCourseLessons extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_lessons', [
            'mandatory' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'after'      => 'free',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_lessons', 'mandatory');
    }
}
