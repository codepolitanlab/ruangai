<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCourseLessons extends Migration
{
    public function up()
    {
        // Drop columns (PostgreSQL syntax)
        $this->forge->dropColumn('course_lessons', ['video', 'player', 'hash', 'current_revision', 'lesson_uri', 'checksum']);

        // Add new columns
        $fields = [
            'video_diupload' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'video_bunny' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('course_lessons', $fields);

        // Add comment to table (PostgreSQL specific)
        $this->db->query("COMMENT ON TABLE course_lessons IS ''");
    }

    public function down()
    {
        // Reverse: drop new columns, add old columns back
        $this->forge->dropColumn('course_lessons', ['video_diupload', 'video_bunny']);

        $fields = [
            'video' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'player' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'hash' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'current_revision' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'lesson_uri' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'checksum' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('course_lessons', $fields);

        $this->db->query("COMMENT ON TABLE course_lessons IS NULL");
    }
}
