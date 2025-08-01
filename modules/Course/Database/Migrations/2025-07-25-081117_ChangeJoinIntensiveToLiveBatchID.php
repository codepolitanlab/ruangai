<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeJoinIntensiveToLiveBatchID extends Migration
{
    public function up()
    {
        // Change column name join_intensive to live_batch_id in table course_products
        $this->forge->modifyColumn('course_products', [
            'join_intensive' => [
                'name' => 'live_batch_id',
                'type' => 'INT',
                'null' => true, // Sesuaikan dengan kondisi awal kolom
            ],
        ]);
    }

    public function down()
    {
        // Revert back the column name
        $this->forge->modifyColumn('course_products', [
            'live_batch_id' => [
                'name' => 'join_intensive',
                'type' => 'INT',
                'null' => true,
            ],
        ]);
    }
}
