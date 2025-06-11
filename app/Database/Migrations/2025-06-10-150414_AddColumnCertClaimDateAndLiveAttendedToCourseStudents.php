<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnCertClaimDateAndLiveAttendedToCourseStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course_students', [
            'cert_claim_date' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'graduated'
            ],
            'live_attended' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'cert_claim_date'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('events', ['cert_claim_date', 'live_attended']);
    }
}
