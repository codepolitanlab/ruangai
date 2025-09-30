<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnReferralCodeComentorOnParticipants extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_participants', [
            'referral_code_comentor' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => null,
                'null'       => true,
                'after'      => 'referral_code',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_participants', ['referral_code_comentor']);
    }
}
