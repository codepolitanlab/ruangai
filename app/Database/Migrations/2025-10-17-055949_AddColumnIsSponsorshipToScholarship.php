<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnIsSponsorshipToScholarship extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_participants', [
            'is_sponsorship' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => true,
                'after'      => 'is_participating_other_ai_program',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_participants', ['is_sponsorship']);
    }
}
