<?php

namespace Challenge\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFollowAccountFieldsToAlibabaTable extends Migration
{
    public function up()
    {
        $fields = [
            'is_followed_account_codepolitan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'ethical_statement_agreed',
            ],
            'is_followed_account_alibaba' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'is_followed_account_codepolitan',
            ],
        ];

        $this->forge->addColumn('challenge_alibaba', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('challenge_alibaba', [
            'is_followed_account_codepolitan',
            'is_followed_account_alibaba',
        ]);
    }
}
