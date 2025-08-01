<?php

namespace Heroicadmin\Modules\User\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table         = 'roles';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['role_name', 'role_slug', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
