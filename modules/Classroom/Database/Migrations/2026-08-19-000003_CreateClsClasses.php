<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateClsClasses extends Migration
{
    public function up()
    {
        // cls_classes — kelas (instance dari silabus)
        $this->forge->addField([
            'id'                                      => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'syllabus_id'                             => ['type' => 'BIGINT', 'unsigned' => true],
            'name'                                    => ['type' => 'VARCHAR', 'constraint' => 255],
            'thumbnail'                               => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'description'                             => ['type' => 'TEXT', 'null' => true],
            'status'                                  => ['type' => 'ENUM', 'constraint' => ['draft', 'active', 'archived'], 'default' => 'draft'],
            'start_date'                              => ['type' => 'DATE', 'null' => true],
            'whatsapp_group_url'                      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'certificate_requirement'                 => ['type' => 'TEXT', 'null' => true],
            'required_feedback_before_claim_certificate' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'certificate_claimable'                   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_by'                              => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'                              => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'                              => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'                              => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('syllabus_id');
        $this->forge->addForeignKey('syllabus_id', 'cls_syllabuses', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('cls_classes');
    }

    public function down()
    {
        $this->forge->dropTable('cls_classes');
    }
}
