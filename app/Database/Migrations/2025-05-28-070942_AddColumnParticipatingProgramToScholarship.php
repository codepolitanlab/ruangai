<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnParticipatingProgramToScholarship extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_participants', [
            'is_participating_other_ai_program' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => null,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_participants', ['is_participating_other_ai_program']);
    }
}
