<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Events extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => 128],
            'code'              => ['type' => 'VARCHAR', 'constraint' => 50],
            'description'       => ['type' => 'TEXT', 'null' => true],
            'date_start'        => ['type' => 'DATETIME', 'null' => true],
            'date_end'          => ['type' => 'DATETIME', 'null' => true],
            'quota'             => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'total_participant' => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'organizer'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'], //['draft', 'published', 'cancelled', 'completed']
            'publish_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'is_featured'       => ['type' => 'BOOLEAN', 'default' => false],
            'banner_image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'        => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'        => ['type' => 'TIMESTAMP', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('events', true);
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
