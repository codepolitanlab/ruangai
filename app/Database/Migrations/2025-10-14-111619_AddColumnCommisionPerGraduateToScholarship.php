<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnCommisionPerGraduateToScholarship extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_participants', [
            'commission_per_graduate' => [
                'type'       => 'int',
                'constraint' => '11',
                'default'    => 5000,
                'null'       => false,
                'after'      => 'referral_code_comentor',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_participants', ['commission_per_graduate']);
    }
}
