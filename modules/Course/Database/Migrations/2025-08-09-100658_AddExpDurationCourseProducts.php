<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExpDurationCourseProducts extends Migration
{
    public function up()
    {
        $fields = [
            'exp_duration' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'description' // ganti jika mau atur posisi kolom
            ],
        ];

        $this->forge->addColumn('course_products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('course_products', 'exp_duration');
    }
}
