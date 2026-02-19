<?php

namespace Challenge\Models;

use CodeIgniter\Model;

class ChallengeAlibabaModel extends Model
{
    protected $table         = 'challenge_alibaba';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id',
        'challenge_id',
        'twitter_post_url',
        'video_title',
        'video_category',
        'video_description',
        'other_tools',
        'team_members',
        'prompt_file',
        'params_file',
        'assets_list_file',
        'alibaba_screenshot',
        'twitter_follow_screenshot',
        'ethical_statement_agreed',
        'is_followed_account_codepolitan',
        'is_followed_account_alibaba',
        'notes',
        'status',
        'submitted_at',
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Get submission with user information
     */
    public function getWithUserInfo($id = null)
    {
        $builder = $this->select('challenge_alibaba.*, users.name as user_name, users.email as user_email, users.phone as user_phone, user_profiles.alibaba_cloud_id, alibaba_cloud_screenshot')
            ->join('users', 'users.id = challenge_alibaba.user_id', 'left')
            ->join('user_profiles', 'user_profiles.user_id = users.id', 'left');

        if ($id !== null) {
            return $builder->where('challenge_alibaba.id', $id)->first();
        }

        return $builder->findAll();
    }

    /**
     * Get submissions by status
     */
    public function getByStatus($status)
    {
        return $this->select('challenge_alibaba.*, users.name as user_name, users.email as user_email')
            ->join('users', 'users.id = challenge_alibaba.user_id', 'left')
            ->where('challenge_alibaba.status', $status)
            ->findAll();
    }

    /**
     * Get pending submissions for validation
     */
    public function getPendingValidation()
    {
        return $this->getByStatus('pending');
    }

    /**
     * Count submissions by user
     */
    public function countByUserId($userId, $excludeRejected = true)
    {
        $builder = $this->where('user_id', $userId);
        
        if ($excludeRejected) {
            $builder->whereNotIn('status', ['rejected']);
        }

        return $builder->countAllResults();
    }

    /**
     * Check if user already has active submission
     */
    public function hasActiveSubmission($userId)
    {
        return $this->countByUserId($userId, true) > 0;
    }

    /**
     * Get user's submission (including pending for edit)
     */
    public function getUserSubmission($userId)
    {
        return $this->where('user_id', $userId)
            ->whereNotIn('status', ['rejected'])
            ->first();
    }

    /**
     * Get latest submission for user (including rejected)
     */
    public function getLatestSubmission($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    /**
     * Check if submission can be edited
     * Allowed statuses for editing: pending, review, rejected
     */
    public function canEdit($id, $userId)
    {
        $submission = $this->where('id', $id)
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'review', 'rejected'])
            ->first();

        return !empty($submission);
    }

    /**
     * Get team members as array
     */
    public function getTeamMembersArray($id)
    {
        $submission = $this->find($id);
        
        if (!$submission || empty($submission['team_members'])) {
            return [];
        }

        $members = json_decode($submission['team_members'], true);
        return is_array($members) ? $members : [];
    }

    /**
     * Update submission status
     */
    public function updateStatus($id, $status, $adminNotes = null)
    {
        $data = ['status' => $status];
        
        if ($adminNotes !== null) {
            $data['notes'] = $adminNotes;
        }

        return $this->update($id, $data);
    }
}
