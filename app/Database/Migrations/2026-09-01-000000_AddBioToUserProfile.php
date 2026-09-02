<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBioToUserProfile extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user_profiles', [
            'bio' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'occupation',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user_profiles', 'bio');
    }
}
