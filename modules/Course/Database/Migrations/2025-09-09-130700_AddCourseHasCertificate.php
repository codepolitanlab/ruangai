<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCourseHasCertificate extends Migration
{
    public function up()
    {
        $fields = [
            'has_certificate' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'has_live_sessions' // ganti jika mau atur posisi kolom
            ],
        ];

        $this->forge->addColumn('courses', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', 'has_certificate');
    }
}
