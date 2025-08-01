<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableLiveMeetingFeedback extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'         => ['type' => 'INT', 'unsigned' => true],
            'live_meeting_id' => ['type' => 'INT', 'unsigned' => true],
            'content'         => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'      => ['type' => 'TIMESTAMP', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('live_meeting_feedback');
    }

    public function down()
    {
        $this->forge->dropTable('live_meeting_feedback');
    }
}
