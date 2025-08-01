<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnCourseLanding extends Migration
{
    public function up()
    {
        // Add column landing_url in course table
        $this->forge->addColumn('courses', [
            'landing_url' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'thumbnail',
            ],
        ]);

        // Add column module_url in live_meetings table
        $this->forge->addColumn('live_meetings', [
            'module_url' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'form_feedback_url',
            ],
        ]);
    }

    public function down()
    {
        // drop column
        $this->forge->dropColumn('courses', 'landing_url');
        $this->forge->dropColumn('live_meetings', 'module_url');
    }
}
