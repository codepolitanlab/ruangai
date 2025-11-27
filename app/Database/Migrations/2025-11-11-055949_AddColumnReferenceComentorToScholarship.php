<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnReferenceComentorToScholarship extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_participants', [
            'reference_comentor' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'referral_code',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_participants', ['reference_comentor']);
    }
}
