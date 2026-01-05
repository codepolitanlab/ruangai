<?php

namespace Event\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventTables extends Migration
{
    public function up()
    {
        // Table: events
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'event_type' => [
                'type'       => 'ENUM',
                'constraint' => ['online', 'offline', 'hybrid'],
                'default'    => 'online',
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'workshop, seminar, webinar, conference, meetup, dll',
            ],
            'start_date' => [
                'type' => 'DATETIME',
            ],
            'end_date' => [
                'type' => 'DATETIME',
            ],
            'registration_start' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'registration_end' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'max_participants' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'comment'    => 'null = unlimited',
            ],
            'is_free' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 3,
                'default'    => 'IDR',
            ],
            // Location for offline/hybrid
            'venue_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'venue_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Indonesia',
            ],
            // Online meeting info
            'meeting_platform' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'Zoom, Google Meet, Teams, dll',
            ],
            'meeting_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'meeting_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'meeting_password' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            // Media
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'banner' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            // Organizer
            'organizer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'organizer_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'organizer_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'User ID yang membuat event',
            ],
            // Certificate
            'has_certificate' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'certificate_template' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'attendance_required' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'Apakah harus hadir untuk dapat sertifikat',
            ],
            // Status
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'published', 'ongoing', 'completed', 'cancelled'],
                'default'    => 'draft',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('event_type');
        $this->forge->addKey('status');
        $this->forge->addKey('start_date');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('events');

        // Table: event_participants
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'registration_date' => [
                'type' => 'DATETIME',
            ],
            'attendance_status' => [
                'type'       => 'ENUM',
                'constraint' => ['registered', 'attended', 'absent', 'cancelled'],
                'default'    => 'registered',
            ],
            'check_in_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'check_out_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'certificate_issued' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'certificate_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK to certificates table',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['event_id', 'user_id']);
        $this->forge->addKey('attendance_status');
        $this->forge->addForeignKey('event_id', 'events', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('certificate_id', 'certificates', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('event_participants');

        // Table: event_sessions (optional - untuk event multi-sesi)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'event_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'session_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'session_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'speaker_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'speaker_bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'speaker_photo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'start_time' => [
                'type' => 'DATETIME',
            ],
            'end_time' => [
                'type' => 'DATETIME',
            ],
            'session_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('event_id');
        $this->forge->addKey('session_order');
        $this->forge->addForeignKey('event_id', 'events', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('event_sessions');
    }

    public function down()
    {
        $this->forge->dropTable('event_sessions');
        $this->forge->dropTable('event_participants');
        $this->forge->dropTable('events');
    }
}
