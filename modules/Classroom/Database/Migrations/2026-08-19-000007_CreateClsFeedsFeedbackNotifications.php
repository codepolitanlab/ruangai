<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsFeedsFeedbackNotifications extends Migration
{
    public function up()
    {
        // cls_class_feeds — pengumuman kelas
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_id'   => ['type' => 'BIGINT', 'unsigned' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'body'       => ['type' => 'TEXT'],
            'pinned'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_by' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('class_id');
        $this->forge->addForeignKey('class_id', 'cls_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_class_feeds');

        // cls_feedbacks — feedback peserta (syarat sertifikat & testimoni)
        $this->forge->addField([
            'id'                    => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'class_id'              => ['type' => 'BIGINT', 'unsigned' => true],
            'user_id'               => ['type' => 'BIGINT', 'unsigned' => true],
            'profession'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'                  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'condition_before'      => ['type' => 'ENUM', 'constraint' => ['a', 'b', 'c', 'd', 'e', 'f'], 'null' => true],
            'condition_before_other' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'reason_choice'         => ['type' => 'TEXT', 'null' => true],
            'favorite_moment'       => ['type' => 'TEXT', 'null' => true],
            'rating'                => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true],
            'concrete_skill'        => ['type' => 'TEXT', 'null' => true],
            'message_to_friend'     => ['type' => 'TEXT', 'null' => true],
            'allow_testimonial'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'            => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'            => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'            => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['class_id', 'user_id']);
        $this->forge->addForeignKey('class_id', 'cls_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cls_feedbacks');

        // cls_notifications — notifikasi
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'type'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'body'       => ['type' => 'TEXT', 'null' => true],
            'read_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'meta'       => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('cls_notifications');
    }

    public function down()
    {
        $this->forge->dropTable('cls_notifications');
        $this->forge->dropTable('cls_feedbacks');
        $this->forge->dropTable('cls_class_feeds');
    }
}
