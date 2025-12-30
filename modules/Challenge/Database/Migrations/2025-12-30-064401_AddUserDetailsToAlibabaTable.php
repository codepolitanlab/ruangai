<?php

namespace Challenge\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserDetailsToAlibabaTable extends Migration
{
    public function up()
    {
        $fields = [
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'user_id',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'fullname',
            ],
            'whatsapp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'email',
            ],
            'accept_terms' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'whatsapp',
            ],
            'accept_agreement' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'accept_terms',
            ],
        ];

        $this->forge->addColumn('challenge_alibaba', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('challenge_alibaba', [
            'fullname',
            'email',
            'whatsapp',
            'accept_terms',
            'accept_agreement',
        ]);
    }
}
