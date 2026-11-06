<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCheckoutUrlToClsClasses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('cls_classes', [
            'checkout_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'whatsapp_group_url',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('cls_classes', 'checkout_url');
    }
}
