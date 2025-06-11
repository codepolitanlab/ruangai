<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnDurationToLiveAttendance extends Migration
{
    public function up()
    {
        $this->forge->addColumn('live_attendance', [
            'duration' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'live_meeting_id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('live_attendance', ['duration']);
    }
}
