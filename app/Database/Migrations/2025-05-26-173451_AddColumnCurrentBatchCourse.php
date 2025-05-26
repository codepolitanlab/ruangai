<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnCurrentBatchCourse extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'current_batch_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'description' // letakkan setelah kolom description, sesuaikan dengan struktur tabel
            ]
        ]);

        $this->forge->addForeignKey('current_batch_id', 'live_batch', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('courses', 'courses_current_batch_id_foreign');
        $this->forge->dropColumn('courses', 'current_batch_id');
    }
}
