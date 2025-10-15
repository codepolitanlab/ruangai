<?php

namespace Certificate\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificates extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cert_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'cert_claim_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'cert_increment' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'cert_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'entity_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'course', // 'course', 'training', 'event', 'workshop', 'bootcamp', 'certification', 'competition'
            ],
            'entity_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID of the related entity (course_id, training_id, event_id, etc.)',
            ],
            'participant_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Name as it appears on certificate (might differ from user name)',
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'comment'    => 'Title/name of the course/training/event as it appears on certificate',
            ],
            'additional_data' => [
                'type'    => 'JSON',
                'null'    => true,
                'comment' => 'Additional certificate data (instructor, venue, scores, etc.)',
            ],
            'template_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'default',
                'comment'    => 'Certificate template to use',
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
        $this->forge->addKey('user_id');
        $this->forge->addKey(['entity_type', 'entity_id']);

        // Foreign key ke users table
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('certificates');
    }

    public function down()
    {
        $this->forge->dropTable('certificates');
    }
}
