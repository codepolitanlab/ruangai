<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnDeletedAtOnLiveAttendance extends Migration
{
    public function up()
    {
        $this->forge->addColumn('live_attendance', [
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'updated_at',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('live_attendance', ['deleted_at']);
    }
}
