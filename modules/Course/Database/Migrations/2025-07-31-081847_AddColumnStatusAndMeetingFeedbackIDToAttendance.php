<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnStatusAndMeetingFeedbackIDToAttendance extends Migration
{
    public function up()
    {
        $this->forge->addColumn('live_attendance', [
            'zoom_join_link' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'live_meeting_id',
            ],
            'meeting_feedback_id' => [
                'type'  => 'INT',
                'null'  => true,
                'after' => 'duration',
            ],
            'status' => [
                'type' => 'TINYINT',
                'null' => true,
                // 'default' => 1,
                'after' => 'meeting_feedback_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('live_attendance', 'zoom_join_link');
        $this->forge->dropColumn('live_attendance', 'meeting_feedback_id');
        $this->forge->dropColumn('live_attendance', 'status');
    }
}
