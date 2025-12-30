<?php

namespace App\Models;

use CodeIgniter\Model;

class ChallengeAlibabaModel extends Model
{
    protected $table         = 'challenge_alibaba_new';

    protected $allowedFields = [
        'user_id',
        'fullname',
        'email',
        'whatsapp',
        'accept_terms',
        'accept_agreement',
        'challenge_id',
        'twitter_post_url',
        'video_title',
        'video_description',
        'prompt_file',
        'other_tools',
        'ethical_statement_agreed',
        'status',
        'submitted_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = true;
}