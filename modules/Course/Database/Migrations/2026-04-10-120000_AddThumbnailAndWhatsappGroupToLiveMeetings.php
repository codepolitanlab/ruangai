<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailAndWhatsappGroupToLiveMeetings extends Migration
{
    public function up()
    {
        $fields = [
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'zoom_autoregister',
            ],
            'whatsapp_group' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'thumbnail',
            ],
        ];

        $this->forge->addColumn('live_meetings', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('live_meetings', ['thumbnail', 'whatsapp_group']);
    }
}
