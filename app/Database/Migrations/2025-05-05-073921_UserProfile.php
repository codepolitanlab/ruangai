<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UserProfile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'INT', 'unsigned' => true],
            'bank_name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'account_number' => ['type' => 'VARCHAR', 'constraint' => 100],
            'account_name'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('user_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('user_profiles');
    }
}
