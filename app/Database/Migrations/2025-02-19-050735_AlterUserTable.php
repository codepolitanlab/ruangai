<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserFields extends Migration
{
    public function up()
    {
        $fields = [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'id' // Hanya berlaku di MySQL
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
                'after' => 'name'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'phone'
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'email'
            ],
            'pwd' => [
                'type' => 'TEXT', // TinyText tidak ada di SQLite, jadi pakai TEXT
                'null' => true,
                'after' => 'avatar'
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
                'after' => 'pwd'
            ],
            'otp' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => true,
                'after' => 'token'
            ],
            'otp_email' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => true,
                'after' => 'otp'
            ],
            'otp_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => true,
                'after' => 'otp_email'
            ],
        ];

        // Tambahkan kolom ke tabel users
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // Hapus kolom saat rollback
        $this->forge->dropColumn('users', [
            'name', 'phone', 'email', 'avatar', 'pwd', 'token', 'otp', 'otp_email', 'otp_phone'
        ]);
    }
}
