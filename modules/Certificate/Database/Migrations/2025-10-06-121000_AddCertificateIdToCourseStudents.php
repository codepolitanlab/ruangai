<?php

namespace Certificate\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCertificateIdToCourseStudents extends Migration
{
    public function up()
    {
        // Add certificate_id column to course_students table
        $this->forge->addColumn('course_students', [
            'certificate_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'user_id', // Place after user_id for better organization
            ],
        ]);

        // Add index for better performance
        $this->db->query('ALTER TABLE course_students ADD INDEX idx_certificate_id (certificate_id)');
    }

    public function down()
    {
        // Remove column
        $this->forge->dropColumn('course_students', 'certificate_id');
    }
}
