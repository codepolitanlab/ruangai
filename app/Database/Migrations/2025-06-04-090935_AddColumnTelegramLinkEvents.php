<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnTelegramLinkEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_events', [
            'telegram_link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
                'null'       => true,
                'after'      => 'organizer',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_events', ['telegram_link']);
    }
}
