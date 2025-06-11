<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name'            => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'phone'           => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true
            ],
            'email'           => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'avatar'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'pwd'             => [
                'type' => 'TEXT',
                'null' => true
            ],
            'token'           => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true
            ],
            'otp'             => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
                'null'       => true
            ],
            'otp_email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
                'null'       => true
            ],
            'otp_phone'       => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
                'null'       => true
            ],
            'phone_valid'   => [
                'type'       => 'TINYINT',
                'null'       => true,
                'default'    => 0
            ],
            'email_valid'   => [
                'type'       => 'TINYINT',
                'null'       => true,
                'default'    => 0
            ],
            'username'        => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true
            ],
            'status'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'status_message'  => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'active'          => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0
            ],
            'last_active'     => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'created_at'      => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at'      => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at'      => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true); // PRIMARY KEY
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
