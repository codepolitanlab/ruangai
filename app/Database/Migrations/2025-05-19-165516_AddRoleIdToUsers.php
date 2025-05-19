<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'role_id' => [
                'type'       => 'INT',
                'null'       => true,
                'default'    => 2,
                'after'      => 'id' // Hanya berlaku di MySQL
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role_id');
    }
}
