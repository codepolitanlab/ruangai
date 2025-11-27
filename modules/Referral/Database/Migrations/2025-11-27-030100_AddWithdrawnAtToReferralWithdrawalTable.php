<?php

namespace Referral\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWithdrawnAtToReferralWithdrawalTable extends Migration
{
    public function up()
    {
        $fields = [
            'withdrawn_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('referral_withdrawal', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('referral_withdrawal', 'withdrawn_at');
    }
}
