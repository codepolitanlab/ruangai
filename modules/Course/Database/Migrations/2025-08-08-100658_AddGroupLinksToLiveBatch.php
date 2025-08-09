<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGroupLinksToLiveBatch extends Migration
{
    public function up()
    {
        $fields = [
            'whatsapp_group_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'status' // ganti jika mau atur posisi kolom
            ],
            'telegram_group_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'whatsapp_group_link'
            ],
        ];

        $this->forge->addColumn('live_batch', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('live_batch', ['whatsapp_group_link', 'telegram_group_link']);
    }
}
