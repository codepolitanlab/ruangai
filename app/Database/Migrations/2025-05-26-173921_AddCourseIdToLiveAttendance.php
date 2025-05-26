<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCourseIdToLiveAttendance extends Migration
{
    public function up()
    {
        $this->forge->addColumn('live_attendance', [
            'course_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'user_id' // Sesuaikan posisi sesuai kebutuhan
            ],
        ]);

        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('live_attendance', 'live_attendance_course_id_foreign');
        $this->forge->dropColumn('live_attendance', 'course_id');
    }
}
