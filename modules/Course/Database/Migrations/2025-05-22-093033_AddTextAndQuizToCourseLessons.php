<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTextAndQuizToCourseLessons extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_lessons', [
            'text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'quiz' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_lessons', ['text', 'quiz']);
    }
}
