<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCertificateTemplateToClsClasses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('cls_classes', [
            'certificate_template' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'certificate_claimable',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('cls_classes', 'certificate_template');
    }
}
