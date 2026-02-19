<?php

namespace Challenge\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryVideoColumn extends Migration
{
    public function up()
    {
        $fields = [
            'video_category' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'video_description',
            ],
        ];

        $this->forge->addColumn('challenge_alibaba', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('challenge_alibaba', [
            'video_category',
        ]);
    }
}
