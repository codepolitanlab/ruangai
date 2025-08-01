<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFlagsToCourses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'has_modules' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'cover', // ganti jika ingin spesifik posisi
            ],
            'has_live_sessions' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'has_modules',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', ['has_modules', 'has_live_sessions']);
    }
}
