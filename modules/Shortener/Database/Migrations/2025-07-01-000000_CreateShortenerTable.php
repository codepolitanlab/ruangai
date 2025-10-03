<?php

namespace Mahasiswa\Migrations;

use CodeIgniter\Database\Migration;

class CreateShortenerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => '100'],
            'code'          => ['type' => 'VARCHAR', 'constraint' => '30'],
            'destination'   => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'default' => date('Y-m-d H:i:s')],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('shorteners');
    }

    public function down()
    {
        $this->forge->dropTable('shorteners');
    }
}
