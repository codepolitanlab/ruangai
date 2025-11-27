<?php

namespace Referral\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescriptionToReferralWithdrawalTable extends Migration
{
    public function up()
    {
        $fields = [
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('referral_withdrawal', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('referral_withdrawal', 'description');
    }
}
