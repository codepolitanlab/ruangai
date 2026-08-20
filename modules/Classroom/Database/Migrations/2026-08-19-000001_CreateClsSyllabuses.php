<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsSyllabuses extends Migration
{
    public function up()
    {
        // cls_syllabuses — silabus / kurikulum program
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'subtitle'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'draft'],
            'created_by'  => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'  => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'  => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cls_syllabuses');

        // cls_materials — materi (sesi/pertemuan) dalam silabus
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'syllabus_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'subtitle'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'order_seq'   => ['type' => 'SMALLINT', 'default' => 0],
            'weight'      => ['type' => 'SMALLINT', 'default' => 0],
            'scoring_type' => ['type' => 'ENUM', 'constraint' => ['auto', 'manual'], 'default' => 'auto'],
            'deleted_at'  => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('syllabus_id');
        $this->forge->addForeignKey('syllabus_id', 'cls_syllabuses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_materials');
    }

    public function down()
    {
        $this->forge->dropTable('cls_materials');
        $this->forge->dropTable('cls_syllabuses');
    }
}
