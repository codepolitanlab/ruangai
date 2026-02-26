<?php

namespace Challenge\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNotesColumn extends Migration
{
    public function up()
    {
        $fields = [
            'notes' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'status',
            ],
        ];

        $this->forge->addColumn('challenge_alibaba', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('challenge_alibaba', [
            'notes',
        ]);
    }
}
