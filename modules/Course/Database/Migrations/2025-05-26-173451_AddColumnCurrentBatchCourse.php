<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnCurrentBatchCourse extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'current_batch_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'after'    => 'description', // letakkan setelah kolom description, sesuaikan dengan struktur tabel
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropForeignKey('courses', 'courses_current_batch_id_foreign');
        $this->forge->dropColumn('courses', 'current_batch_id');
    }
}
