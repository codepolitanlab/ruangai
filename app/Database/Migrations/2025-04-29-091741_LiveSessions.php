<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class LiveSessions extends Migration
{
    public function up()
    {
        // Create live_sessions table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'course_id' => ['type' => 'INT'],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT'],
            'thumbnail' => ['type' => 'TEXT', 'null' => true],
            'total_students' => ['type' => 'INT'],
            'is_required' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('live_sessions');

        // Create live_session_schedules table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'live_session_id' => ['type' => 'INT'],
            'mentor_id' => ['type' => 'INT'],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'time' => ['type' => 'TIMESTAMP'],
            'zoom_link' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'zoom_passcode' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'youtube_live_url' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('live_session_id');
        $this->forge->createTable('live_session_schedules');

        // Create live_session_students table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'course_id' => ['type' => 'INT'],
            'live_session_id' => ['type' => 'INT'],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP'],
            'deleted_at' => ['type' => 'TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('course_id');
        $this->forge->addKey('live_session_id');
        $this->forge->createTable('live_session_students');
    }

    public function down()
    {
        $this->forge->dropTable('live_sessions');
        $this->forge->dropTable('live_session_schedules');
        $this->forge->dropTable('live_session_students');
    }
}
