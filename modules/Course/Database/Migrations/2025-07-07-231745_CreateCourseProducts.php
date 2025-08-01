<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateCourseProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'course_id' => [
                'type' => 'INT',
                'null' => false,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'duration' => [
                'type'    => 'INT',
                'default' => 31,
                'null'    => false,
            ],
            'join_intensive' => [
                'type'    => 'TINYINT',
                'default' => 0,
                'null'    => true,
            ],
            'normal_price' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => false,
            ],
            'discount' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'price' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => false,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->addKey('course_id'); // Index
        $this->forge->createTable('course_products');
    }

    public function down()
    {
        $this->forge->dropTable('course_products');
    }
}
