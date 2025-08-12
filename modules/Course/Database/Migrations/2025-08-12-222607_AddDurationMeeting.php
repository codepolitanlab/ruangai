<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDurationMeeting extends Migration
{
    public function up()
    {
        $fields = [
            'duration' => [
                'type'       => 'INT',
                'default'    => 120,
                'null'       => true,
                'after'      => 'meeting_time' // ganti jika mau atur posisi kolom
            ],
        ];

        $this->forge->addColumn('live_meetings', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('live_meetings', 'duration');
    }
}
