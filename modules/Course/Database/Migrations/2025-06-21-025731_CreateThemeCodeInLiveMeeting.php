<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateThemeCodeInLiveMeeting extends Migration
{
    public function up()
    {
        $this->forge->addColumn('live_meetings', [
            'theme_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'title',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('live_meetings', ['theme_code']);
    }
}
