<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsProducts extends Migration
{
    public function up()
    {
        // cls_products — produk kelas (bootcamp) yang dijual, meniru course_products pada modul Course
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_id'     => ['type' => 'BIGINT', 'unsigned' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'subtitle'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'duration'     => ['type' => 'INT', 'unsigned' => true, 'default' => 31, 'null' => true], // durasi akses (hari)
            'normal_price' => ['type' => 'INT', 'unsigned' => true, 'default' => 0, 'null' => false],
            'price'        => ['type' => 'INT', 'unsigned' => true, 'default' => 0, 'null' => false],
            'discount'     => ['type' => 'INT', 'unsigned' => true, 'default' => 0, 'null' => true],
            'description'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'exp_duration' => ['type' => 'INT', 'null' => true], // dalam detik
            'status'       => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true, 'default' => 1, 'null' => false], // 1 = aktif, 0 = nonaktif
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('class_id');
        $this->forge->addForeignKey('class_id', 'cls_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_products');
    }

    public function down()
    {
        $this->forge->dropTable('cls_products');
    }
}
