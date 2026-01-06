<?php

namespace Event\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'slug',
        'description',
        'event_type',
        'category',
        'start_date',
        'end_date',
        'registration_start',
        'registration_end',
        'max_participants',
        'is_free',
        'price',
        'currency',
        'venue_name',
        'venue_address',
        'city',
        'province',
        'country',
        'meeting_platform',
        'meeting_url',
        'meeting_id',
        'meeting_password',
        'thumbnail',
        'banner',
        'organizer_name',
        'organizer_email',
        'organizer_phone',
        'created_by',
        'has_certificate',
        'certificate_template',
        'attendance_required',
        'status',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[5]|max_length[255]',
        'slug' => 'permit_empty|alpha_dash|max_length[255]|is_unique[events.slug,id,{id}]',
        'event_type' => 'required|in_list[online,offline,hybrid]',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
    ];
    protected $validationMessages = [
        'title' => [
            'required' => 'Judul event harus diisi',
            'min_length' => 'Judul minimal 5 karakter',
        ],
        'slug' => [
            'is_unique' => 'Slug sudah digunakan',
        ],
        'event_type' => [
            'required' => 'Tipe event harus dipilih',
            'in_list' => 'Tipe event tidak valid',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateSlug'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['generateSlug'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Generate slug from title if not provided
     */
    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    /**
     * Get events with participant count
     */
    public function getEventsWithParticipantCount($filters = [])
    {
        $builder = $this->builder();
        $builder->select('events.*, COUNT(event_participants.id) as participant_count');
        $builder->join('event_participants', 'event_participants.event_id = events.id', 'left');
        $builder->groupBy('events.id');

        // Apply filters
        if (!empty($filters['event_type'])) {
            $builder->where('events.event_type', $filters['event_type']);
        }
        if (!empty($filters['category'])) {
            $builder->where('events.category', $filters['category']);
        }
        if (!empty($filters['status'])) {
            $builder->where('events.status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('events.title', $filters['search'])
                ->orLike('events.description', $filters['search'])
                ->orLike('events.organizer_name', $filters['search'])
                ->groupEnd();
        }

        $builder->orderBy('events.start_date', 'DESC');
        return $builder->get()->getResultArray();
    }

    /**
     * Get upcoming events
     */
    public function getUpcomingEvents($limit = 10)
    {
        return $this->where('status', 'published')
            ->where('is_active', 1)
            ->where('start_date >=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get ongoing events
     */
    public function getOngoingEvents()
    {
        return $this->where('status', 'ongoing')
            ->where('is_active', 1)
            ->findAll();
    }

    /**
     * Check if event is full
     */
    public function isFull($eventId)
    {
        $event = $this->find($eventId);
        if (!$event || !$event['max_participants']) {
            return false;
        }

        $db = \Config\Database::connect();
        $count = $db->table('event_participants')
            ->where('event_id', $eventId)
            ->where('attendance_status !=', 'cancelled')
            ->countAllResults();

        return $count >= $event['max_participants'];
    }

    /**
     * Check if registration is open
     */
    public function isRegistrationOpen($eventId)
    {
        $event = $this->find($eventId);
        if (!$event) {
            return false;
        }

        $now = date('Y-m-d H:i:s');

        // Check registration period
        if ($event['registration_start'] && $event['registration_start'] > $now) {
            return false;
        }
        if ($event['registration_end'] && $event['registration_end'] < $now) {
            return false;
        }

        // Check event status
        if (!in_array($event['status'], ['published', 'ongoing'])) {
            return false;
        }

        return true;
    }
}
