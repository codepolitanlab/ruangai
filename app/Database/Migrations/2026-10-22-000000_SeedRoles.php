<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Mengisi tabel `roles` pada database baru.
 *
 * Tanpa data ini, `App\Libraries\Heroic::checkToken()` (JOIN roles) mengembalikan
 * user NULL untuk semua akun dan dashboard error "Trying to access array offset
 * on null". role_id default user = 2 (member).
 */
class SeedRoles extends Migration
{
    public function up()
    {
        $roles = [
            ['id' => 1, 'role_name' => 'Super', 'role_slug' => 'super', 'status' => 'active'],
            ['id' => 2, 'role_name' => 'Member', 'role_slug' => 'member', 'status' => 'active'],
            ['id' => 3, 'role_name' => 'Admin', 'role_slug' => 'admin', 'status' => 'active'],
        ];

        foreach ($roles as $role) {
            $exists = $this->db->table('roles')->where('id', $role['id'])->countAllResults() > 0;

            if (! $exists) {
                $role['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('roles')->insert($role);
            }
        }
    }

    public function down()
    {
        $this->db->table('roles')->whereIn('id', [1, 2, 3])->delete();
    }
}
