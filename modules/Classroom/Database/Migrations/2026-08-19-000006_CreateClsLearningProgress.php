<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsLearningProgress extends Migration
{
    public function up()
    {
        // cls_learning_progress — progres member per resource
        $this->forge->addField([
            'id'                => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_material_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'resource_id'       => ['type' => 'BIGINT', 'unsigned' => true],
            'user_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'status'            => ['type' => 'ENUM', 'constraint' => ['not_started', 'in_progress', 'completed'], 'default' => 'not_started'],
            'completed_at'      => ['type' => 'TIMESTAMP', 'null' => true],
            'meta'              => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'        => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['class_material_id', 'resource_id', 'user_id']);
        $this->forge->addForeignKey('class_material_id', 'cls_class_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('resource_id', 'cls_learning_resources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_learning_progress');

        // cls_quiz_results — hasil kuis
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'progress_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'answers'        => ['type' => 'TEXT', 'null' => true],
            'score'          => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'max_score'      => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'passed'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'attempt_number' => ['type' => 'SMALLINT', 'default' => 1],
            'submitted_at'   => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('progress_id');
        $this->forge->addForeignKey('progress_id', 'cls_learning_progress', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_quiz_results');

        // cls_submissions — tugas peserta
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'progress_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'type'         => ['type' => 'ENUM', 'constraint' => ['file', 'url'], 'default' => 'file'],
            'file_path'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'file_name'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'file_size'    => ['type' => 'INT', 'null' => true],
            'url'          => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'submitted_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'reviewed_by'  => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'reviewed_at'  => ['type' => 'TIMESTAMP', 'null' => true],
            'review_score' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'review_note'  => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['submitted', 'accepted', 'revision_needed'], 'default' => 'submitted'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('progress_id');
        $this->forge->addForeignKey('progress_id', 'cls_learning_progress', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_submissions');

        // cls_member_scores — skor member per materi
        $this->forge->addField([
            'id'                => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_material_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'user_id'           => ['type' => 'BIGINT', 'unsigned' => true],
            'raw_score'         => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'final_score'       => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'scoring_type'      => ['type' => 'ENUM', 'constraint' => ['auto', 'manual'], 'default' => 'manual'],
            'scored_by'         => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'scored_at'         => ['type' => 'TIMESTAMP', 'null' => true],
            'notes'             => ['type' => 'TEXT', 'null' => true],
            'status'            => ['type' => 'ENUM', 'constraint' => ['pending', 'scored', 'reviewed'], 'default' => 'pending'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['class_material_id', 'user_id']);
        $this->forge->addForeignKey('class_material_id', 'cls_class_materials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_member_scores');
    }

    public function down()
    {
        $this->forge->dropTable('cls_member_scores');
        $this->forge->dropTable('cls_submissions');
        $this->forge->dropTable('cls_quiz_results');
        $this->forge->dropTable('cls_learning_progress');
    }
}
