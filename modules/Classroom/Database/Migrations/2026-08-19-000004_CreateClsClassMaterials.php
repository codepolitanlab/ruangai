<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsClassMaterials extends Migration
{
    public function up()
    {
        // cls_class_materials — jadwal materi dalam kelas (pivot materi ↔ kelas)
        $this->forge->addField([
            'id'            => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'material_id'   => ['type' => 'BIGINT', 'unsigned' => true],
            'instructor_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'scheduled_at'  => ['type' => 'DATETIME', 'null' => true],
            'is_open'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'opened_at'     => ['type' => 'DATETIME', 'null' => true],
            'notes'         => ['type' => 'TEXT', 'null' => true],
            'meeting_info'  => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['class_id', 'material_id']);
        $this->forge->addForeignKey('class_id', 'cls_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('material_id', 'cls_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_class_materials');

        // cls_class_material_resources — metadata per resource dalam kelas (pivot class+resource)
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'material_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'resource_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'metadata'    => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'  => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['class_id', 'material_id', 'resource_id']);
        $this->forge->addForeignKey('class_id', 'cls_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_class_material_resources');
    }

    public function down()
    {
        $this->forge->dropTable('cls_class_material_resources');
        $this->forge->dropTable('cls_class_materials');
    }
}
