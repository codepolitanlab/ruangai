<?php

namespace Event\Config;

use CodeIgniter\Config\BaseConfig;

class Event extends BaseConfig
{
    /**
     * Event types
     */
    public array $eventTypes = [
        'online' => 'Online',
        'offline' => 'Offline',
        'hybrid' => 'Hybrid',
    ];

    /**
     * Event categories
     */
    public array $eventCategories = [
        'workshop' => 'Workshop',
        'seminar' => 'Seminar',
        'webinar' => 'Webinar',
        'conference' => 'Conference',
        'meetup' => 'Meetup',
        'training' => 'Training',
        'bootcamp' => 'Bootcamp',
        'competition' => 'Competition',
    ];

    /**
     * Event status
     */
    public array $eventStatus = [
        'draft' => 'Draft',
        'published' => 'Published',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Attendance status
     */
    public array $attendanceStatus = [
        'registered' => 'Registered',
        'attended' => 'Attended',
        'absent' => 'Absent',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Meeting platforms
     */
    public array $meetingPlatforms = [
        'zoom' => 'Zoom',
        'google_meet' => 'Google Meet',
        'microsoft_teams' => 'Microsoft Teams',
        'webex' => 'Webex',
        'jitsi' => 'Jitsi Meet',
        'custom' => 'Custom/Lainnya',
    ];

    /**
     * Default certificate template for events
     */
    public string $defaultCertificateTemplate = 'default';

    /**
     * Upload settings
     */
    public array $uploadSettings = [
        'thumbnail' => [
            'max_size' => 2048, // KB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
            'recommended_size' => '800x600',
        ],
        'banner' => [
            'max_size' => 5120, // KB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
            'recommended_size' => '1920x1080',
        ],
        'speaker_photo' => [
            'max_size' => 1024, // KB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
            'recommended_size' => '400x400',
        ],
    ];
}
