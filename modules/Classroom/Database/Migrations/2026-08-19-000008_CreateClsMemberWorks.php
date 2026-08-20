<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsMemberWorks extends Migration
{
    public function up()
    {
        // cls_member_works — karya member (showcase)
        $this->forge->addField([
            'id'                => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'thumbnail'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'photos'            => ['type' => 'TEXT', 'null' => true],
            'description'       => ['type' => 'TEXT', 'null' => true],
            'short_description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'            => ['type' => 'ENUM', 'constraint' => ['pending', 'published', 'rejected'], 'default' => 'pending'],
            'url_project'       => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at'        => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'        => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('cls_member_works');
    }

    public function down()
    {
        $this->forge->dropTable('cls_member_works');
    }
}
