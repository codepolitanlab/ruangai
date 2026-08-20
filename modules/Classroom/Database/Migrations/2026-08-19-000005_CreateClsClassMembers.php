<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsClassMembers extends Migration
{
    public function up()
    {
        // cls_class_members — peserta kelas
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'user_id'     => ['type' => 'BIGINT', 'unsigned' => true],
            'role'        => ['type' => 'ENUM', 'constraint' => ['member', 'instructor'], 'default' => 'member'],
            'enrolled_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'status'      => ['type' => 'ENUM', 'constraint' => ['active', 'dropped'], 'default' => 'active'],
            'final_score' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['class_id', 'user_id']);
        $this->forge->addForeignKey('class_id', 'cls_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_class_members');
    }

    public function down()
    {
        $this->forge->dropTable('cls_class_members');
    }
}
