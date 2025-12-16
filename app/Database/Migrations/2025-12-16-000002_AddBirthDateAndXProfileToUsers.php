<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBirthDateAndXProfileToUsers extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();
        
        // Check and add birth_date column
        if (!$forge->getConnection()->fieldExists('birth_date', 'users')) {
            $forge->addColumn('users', [
                'birth_date' => [
                    'type' => 'DATE',
                    'null' => true,
                    'after' => 'gender'
                ]
            ]);
        }

        // Check and add x_profile_url column
        if (!$forge->getConnection()->fieldExists('x_profile_url', 'users')) {
            $forge->addColumn('users', [
                'x_profile_url' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => true,
                    'after' => 'alibabacloud_screenshot'
                ]
            ]);
        }
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        
        // Remove columns if they exist
        if ($forge->getConnection()->fieldExists('birth_date', 'users')) {
            $forge->dropColumn('users', 'birth_date');
        }

        if ($forge->getConnection()->fieldExists('x_profile_url', 'users')) {
            $forge->dropColumn('users', 'x_profile_url');
        }
    }
}
