<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToCourseProducts extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
                'default'    => 1,
                'null'       => false,
                'comment'    => '1 = aktif, 0 = nonaktif',
            ],
        ];

        $this->forge->addColumn('course_products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('course_products', 'status');
    }
}
