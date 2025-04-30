<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OtpWhatsapp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'otp_code'         => ['type' => 'VARCHAR', 'constraint' => 6],
            'whatsapp_number'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'expired_at'       => ['type' => 'DATETIME'],
            'created_at'       => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('whatsapp_number');
        $this->forge->addKey('otp_code');
        $this->forge->createTable('otp_whatsapps');
    }

    public function down()
    {
        $this->forge->dropTable('otp_whatsapps');
    }
}
