<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'         => 1,
                'role_name'  => 'Super',
                'role_slug'  => 'super',
                'status'     => 'active',
                'created_at' => '2013-05-13 03:32:53',
                'updated_at' => null,
            ],
            [
                'id'         => 2,
                'role_name'  => 'Member',
                'role_slug'  => 'member',
                'status'     => 'active',
                'created_at' => '2013-05-13 03:32:53',
                'updated_at' => null,
            ],
            [
                'id'         => 3,
                'role_name'  => 'Admin',
                'role_slug'  => 'admin',
                'status'     => 'active',
                'created_at' => '2020-12-28 04:56:37',
                'updated_at' => null,
            ],
        ];

        // Insert batch ke dalam tabel mein_roles
        $this->db->table('roles')->insertBatch($data);
    }
}
