<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddZoomMeetingIDToLiveMeeting extends Migration
{
    public function up()
    {
        // Add column zoom_meeting_id in live_meetings table
        $this->forge->addColumn('live_meetings', [
            'meeting_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'id',
            ],
            'zoom_meeting_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'zoom_link',
            ],
            'zoom_autoregister' => [
                'type'       => 'TINYINT',
                'null'       => true,
                'after'      => 'zoom_meeting_id',
            ],
        ]);
    }

    public function down()
    {
        // Drop column zoom_meeting_id
        $this->forge->dropColumn('live_meetings', 'zoom_meeting_id');
        $this->forge->dropColumn('live_meetings', 'zoom_autoregister');
        $this->forge->dropColumn('live_meetings', 'meeting_code');
    }
}
