<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubtitleToLiveMeetingsAndBlueprints extends Migration
{
    public function up()
    {
        // Tambah kolom subtitle ke live_meetings
        $this->forge->addColumn('live_meetings', [
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'title', // Sesuaikan dengan posisi kolom di DB
            ],
        ]);

        // Tambah kolom subtitle ke live_meeting_blueprints
        $this->forge->addColumn('live_meeting_blueprints', [
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'title', // Sesuaikan dengan posisi kolom di DB
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('live_meetings', 'subtitle');
        $this->forge->dropColumn('live_meeting_blueprints', 'subtitle');
    }
}
