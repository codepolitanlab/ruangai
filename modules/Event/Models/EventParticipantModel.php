<?php

namespace Event\Models;

use CodeIgniter\Model;

class EventParticipantModel extends Model
{
    protected $table = 'event_participants';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'event_id',
        'user_id',
        'registration_date',
        'attendance_status',
        'check_in_time',
        'check_out_time',
        'certificate_issued',
        'certificate_id',
        'notes',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'event_id' => 'required|is_not_unique[events.id]',
        'user_id' => 'required|is_not_unique[users.id]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get participants with user info
     */
    public function getParticipantsWithUser($eventId)
    {
        return $this->select('event_participants.*, users.name, users.email')
            ->join('users', 'users.id = event_participants.user_id')
            ->where('event_participants.event_id', $eventId)
            ->orderBy('event_participants.registration_date', 'DESC')
            ->findAll();
    }

    /**
     * Check if user is registered
     */
    public function isUserRegistered($eventId, $userId)
    {
        return $this->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->countAllResults() > 0;
    }

    /**
     * Get attended participants
     */
    public function getAttendedParticipants($eventId)
    {
        return $this->where('event_id', $eventId)
            ->where('attendance_status', 'attended')
            ->findAll();
    }

    /**
     * Get participants eligible for certificate
     */
    public function getEligibleForCertificate($eventId)
    {
        return $this->where('event_id', $eventId)
            ->where('attendance_status', 'attended')
            ->where('certificate_issued', 0)
            ->findAll();
    }

    /**
     * Mark attendance
     */
    public function markAttendance($participantId, $attended = true)
    {
        $data = [
            'attendance_status' => $attended ? 'attended' : 'absent',
            'check_in_time' => $attended ? date('Y-m-d H:i:s') : null,
        ];

        return $this->update($participantId, $data);
    }

    /**
     * Issue certificate for participant
     */
    public function issueCertificateForParticipant($participantId, $certificateId)
    {
        return $this->update($participantId, [
            'certificate_issued' => 1,
            'certificate_id' => $certificateId,
        ]);
    }
}
