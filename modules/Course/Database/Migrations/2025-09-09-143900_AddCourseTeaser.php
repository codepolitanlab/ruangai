<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCourseTeaser extends Migration
{
    public function up()
    {
        $fields = [
            'teaser' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'thumbnail' // ganti jika mau atur posisi kolom
            ],
        ];

        $this->forge->addColumn('courses', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', 'teaser');
    }
}
