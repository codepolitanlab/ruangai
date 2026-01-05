<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSourceToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['source']);
    }
}
