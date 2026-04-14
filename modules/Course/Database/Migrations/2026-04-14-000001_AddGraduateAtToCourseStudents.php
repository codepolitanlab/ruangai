<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGraduateAtToCourseStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'graduate_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'graduate',
            ],
        ]);

        // Set graduate_at for existing updated_at value
        $this->db->query('UPDATE course_students
            SET graduate_at = updated_at
            WHERE graduate = 1 
            AND updated_at IS NOT NULL;');
    }

    public function down()
    {
        $this->forge->dropColumn('course_students', 'graduate_at');
    }
}
