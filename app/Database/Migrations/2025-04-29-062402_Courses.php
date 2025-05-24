<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Courses extends Migration
{
    public function up()
    {
        // Create courses table
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'unsigned' => true, 'auto_increment' => true ],
            'partner_id' => [ 'type' => 'INT', 'null' => true ],
            'revenue_sharing' => [ 'type' => 'INT', 'null' => true ],
            'collaborators' => [ 'type' => 'TEXT', 'null' => true ],
            'course_title' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'default' => 'anonymous' ],
            'slug' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'default' => 'anonymous' ],
            'cover' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'thumbnail' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'description' => [ 'type' => 'TEXT', 'null' => true ],
            'total_module' => [ 'type' => 'INT', 'default' => 0 ],
            'total_time' => [ 'type' => 'INT', 'default' => 0 ],
            'total_student' => [ 'type' => 'INT', 'default' => 0 ],
            'tags' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'premium' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 0 ],
            'status' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft' ],
            'course_order' => [ 'type' => 'INT', 'default' => 0 ],
            'last_update' => [ 'type' => 'DATETIME', 'null' => true ],
            'level' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'null' => true ],
            'created_at' => [ 'type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP') ],
            'updated_at' => [ 'type' => 'TIMESTAMP', 'null' => true ],
            'deleted_at' => [ 'type' => 'TIMESTAMP', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('courses');

        // Create course_topics table
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'unsigned' => true, 'auto_increment' => true ],
            'course_id' => [ 'type' => 'INT', 'unsigned' => true ],
            'topic_title' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'topic_slug' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'topic_order' => [ 'type' => 'TINYINT', 'default' => 0 ],
            'free' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 0 ],
            'status' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 1 ],
            'created_at' => [ 'type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP') ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'deleted_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_topics');

        // Create course_author table
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'auto_increment' => true ],
            'course_id' => [ 'type' => 'INT' ],
            'author_id' => [ 'type' => 'INT' ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['course_id', 'author_id']);
        $this->forge->createTable('course_author');

        // Create course_completion table
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'auto_increment' => true ],
            'user_id' => [ 'type' => 'INT' ],
            'course_id' => [ 'type' => 'INT' ],
            'created_at' => [ 'type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP') ],
            'updated_at' => [ 'type' => 'TIMESTAMP', 'null' => true ],
            'deleted_at' => [ 'type' => 'TIMESTAMP', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_completion');

        // Create course_label_pivot table
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'unsigned' => true, 'auto_increment' => true ],
            'label_id' => [ 'type' => 'INT' ],
            'course_id' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'created_at' => [ 'type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP') ],
            'updated_at' => [ 'type' => 'TIMESTAMP', 'null' => true ],
            'deleted_at' => [ 'type' => 'TIMESTAMP', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_label_pivot');

        // Create course_lesson_log table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'course_id' => ['type' => 'INT', 'unsigned' => true],
            'lesson_id' => ['type' => 'INT', 'unsigned' => true],
            'durasi_akses' => ['type' => 'INT', 'default' => 0],
            'waktu_paham' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_lesson_log');

        // Create course_lesson_progress table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'course_id' => ['type' => 'INT'],
            'lesson_id' => ['type' => 'INT'],
            'user_id' => ['type' => 'INT'],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('course_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('course_lesson_progress');

        // Create course_lesson_theory table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'lesson_id' => ['type' => 'INT'],
            'theory' => ['type' => 'TEXT'],
            'revision' => ['type' => 'TINYINT', 'default' => 0],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_lesson_theory');

        // Create course_lessons table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'course_id' => ['type' => 'INT'],
            'topic_id' => ['type' => 'INT', 'null' => true],
            'quiz_id' => ['type' => 'INT', 'null' => true],
            'status' => ['type' => 'TINYINT', 'default' => 1],
            'lesson_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lesson_slug' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'type' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'theory'],
            'video' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'player' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'youtube'],
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'duration' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true],
            'lesson_order' => ['type' => 'TINYINT', 'default' => 0],
            'current_revision' => ['type' => 'TINYINT', 'default' => 0],
            'lesson_uri' => ['type' => 'TEXT', 'null' => true],
            'free' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'hash' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'checksum' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_lessons');

        // Create course_meta table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'seo_description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dependency' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => '[]'],
            'enable_quiz' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'enable_checklist' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'enable_finish' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'enable_forum' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'enable_telegram' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'preview_video' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'preview_video_cover' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'video_screenshots' => ['type' => 'TEXT', 'null' => true],
            'enable_dvd' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true],
            'dvd_screenshots' => ['type' => 'TEXT', 'null' => true],
            'sourcecode_url' => ['type' => 'TEXT', 'null' => true],
            'case_study_desc' => ['type' => 'TEXT', 'null' => true],
            'preview_url' => ['type' => 'TEXT', 'null' => true],
            'project_screenshot' => ['type' => 'TEXT', 'null' => true],
            'long_description' => ['type' => 'TEXT', 'null' => true],
            'author' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'author_url' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'author_contact' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'author_whatsapp' => ['type' => 'TEXT', 'null' => true],
            'author_email' => ['type' => 'VARCHAR', 'constraint' => 130, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_meta');

        // Create course_path table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'path_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'path_slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'landing_url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'description' => ['type' => 'TEXT'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'publish'],
            'is_public' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_path');

        // Create course_path_pivot table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'object_id' => ['type' => 'INT'],
            'object_type' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'course'],
            'path_id' => ['type' => 'INT'],
            'sort' => ['type' => 'INT'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'publish'],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_path_pivot');

        // Create course_products table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'course_id' => ['type' => 'INT'],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'duration' => ['type' => 'INT', 'default' => 31],
            'price' => ['type' => 'INT'],
            'strike_price' => ['type' => 'INT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'default_price' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('course_id');
        $this->forge->createTable('course_products');

        // Create course_students table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'user_id' => ['type' => 'INT'],
            'course_id' => ['type' => 'INT'],
            'progress' => ['type' => 'TINYINT', 'null' => true, 'default' => 0],
            'graduate' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('course_students');
    }

    public function down()
    {
        $this->forge->dropTable('courses');
        $this->forge->dropTable('course_meta');
        $this->forge->dropTable('course_topics');
        $this->forge->dropTable('course_author');
        $this->forge->dropTable('course_completion');
        $this->forge->dropTable('course_label_pivot');
        $this->forge->dropTable('course_lesson_log');
        $this->forge->dropTable('course_lesson_progress');
        $this->forge->dropTable('course_lesson_theory');
        $this->forge->dropTable('course_lessons');
        $this->forge->dropTable('course_path');
        $this->forge->dropTable('course_path_pivot');
        $this->forge->dropTable('course_products');
        $this->forge->dropTable('course_students');
        
    }
}
