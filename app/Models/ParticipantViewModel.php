<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantViewModel extends Model
{
    protected $table      = 'view_participants';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false; // karena ini view
}
