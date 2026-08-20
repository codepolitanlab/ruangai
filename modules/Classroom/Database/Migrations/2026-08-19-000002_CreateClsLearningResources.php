<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsLearningResources extends Migration
{
    public function up()
    {
        // cls_learning_resources — resource belajar dalam materi (10 tipe)
        $this->forge->addField([
            'id'                  => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'material_id'         => ['type' => 'BIGINT', 'unsigned' => true],
            'type'                => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'],
            'title'               => ['type' => 'VARCHAR', 'constraint' => 255],
            'content'             => ['type' => 'TEXT', 'null' => true],
            'order_seq'           => ['type' => 'SMALLINT', 'default' => 0],
            'completion_criteria' => ['type' => 'ENUM', 'constraint' => ['view', 'submit', 'score_pass'], 'default' => 'view'],
            'is_required'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'need_review'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'deleted_at'          => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('material_id');
        $this->forge->addForeignKey('material_id', 'cls_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_learning_resources');

        // cls_quiz_questions — soal kuis (per resource tipe quiz)
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'resource_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'question'       => ['type' => 'TEXT'],
            'type'           => ['type' => 'ENUM', 'constraint' => ['multiple_choice', 'short_answer'], 'default' => 'multiple_choice'],
            'options'        => ['type' => 'TEXT', 'null' => true],
            'correct_answer' => ['type' => 'TEXT', 'null' => true],
            'score'          => ['type' => 'SMALLINT', 'default' => 0],
            'order_seq'      => ['type' => 'SMALLINT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('resource_id');
        $this->forge->addForeignKey('resource_id', 'cls_learning_resources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_quiz_questions');
    }

    public function down()
    {
        $this->forge->dropTable('cls_quiz_questions');
        $this->forge->dropTable('cls_learning_resources');
    }
}
