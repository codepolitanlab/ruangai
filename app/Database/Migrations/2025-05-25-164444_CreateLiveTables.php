<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateLiveTables extends Migration
{
    public function up()
    {
        // live_meeting_blueprints
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'course_id'    => ['type' => 'INT', 'unsigned' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'  => ['type' => 'TEXT', 'null' => true],
            'mentor_name'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'duration'     => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true, 'comment' => 'HH:MM'],
            'order'        => ['type' => 'INT'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('live_meeting_blueprints');

        // live_batch
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'course_id'    => ['type' => 'INT', 'unsigned' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'start_date'   => ['type' => 'DATE'],
            'end_date'     => ['type' => 'DATE'],
            'status'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'upcoming'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('live_batch');

        // live_meetings
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'live_batch_id' => ['type' => 'INT', 'unsigned' => true],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'published'], // draft, published, live
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'mentor_name'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'meeting_date'  => ['type' => 'DATE'],
            'meeting_time'  => ['type' => 'TIME'],
            'zoom_link'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'recording_link'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('live_batch_id', 'live_batch', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('live_meetings');

        // live_enrollments
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true],
            'live_batch_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('live_batch_id', 'live_batch', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('live_enrollments');

        // live_attendance
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'         => ['type' => 'INT', 'unsigned' => true],
            'live_meeting_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('live_meeting_id', 'live_meetings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('live_attendance');
    }

    public function down()
    {
        $this->forge->dropTable('live_attendance');
        $this->forge->dropTable('live_enrollments');
        $this->forge->dropTable('live_meetings');
        $this->forge->dropTable('live_batch');
        $this->forge->dropTable('live_meeting_blueprints');
    }
}
