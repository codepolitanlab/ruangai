<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnDeletedAtOnCourseStudentAndProgress extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true,
            ],
        ]);
        $this->forge->addColumn('course_lesson_progress', [
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', 'deleted_at');
        $this->forge->dropColumn('course_lesson_progress', 'deleted_at');
    }
}
