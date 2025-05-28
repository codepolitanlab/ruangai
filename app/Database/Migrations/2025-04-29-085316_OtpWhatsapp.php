<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OtpWhatsapp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'otp_code'         => ['type' => 'VARCHAR', 'constraint' => 6],
            'whatsapp_number'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'expired_at'       => ['type' => 'DATETIME'],
            'created_at'       => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('whatsapp_number');
        $this->forge->addKey('otp_code');
        $this->forge->createTable('otp_whatsapps');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'otp_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'identity' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'default'    => 'email',
            ],
            'expired_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'reminded' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => null,
            ],
            'deleted_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('otp_requests');
    }

    public function down()
    {
        $this->forge->dropTable('otp_whatsapps');
        $this->forge->dropTable('otp_requests');
    }
}
