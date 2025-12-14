<?php

namespace Challenge\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateChallengeAlibabaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'challenge_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'wan-vision-clash-2025',
            ],
            'twitter_post_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'video_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'video_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'team_members' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON array of team members: [{"name":"...","email":"...","role":"..."}]',
            ],
            'prompt_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'params_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'assets_list_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'alibaba_screenshot' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'twitter_follow_screenshot' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'ethical_statement_agreed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'admin_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'validated', 'approved', 'rejected'],
                'default'    => 'pending',
            ],
            'submitted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addKey('challenge_id');
        $this->forge->createTable('challenge_alibaba');
    }

    public function down()
    {
        $this->forge->dropTable('challenge_alibaba');
    }
}
