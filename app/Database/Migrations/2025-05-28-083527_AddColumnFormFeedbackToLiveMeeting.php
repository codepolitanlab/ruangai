<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnFormFeedbackToLiveMeeting extends Migration
{
    public function up()
    {
        $this->forge->addColumn('live_meetings', [
            'form_feedback_url' => [
                'type' => 'TEXT',
                'default' => null,
                'null' => true,
                'after' => 'recording_link',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('live_meetings', ['form_feedback_url']);
    }
}
