<?php

namespace Challenge\Config;

use CodeIgniter\Config\BaseConfig;

class Challenge extends BaseConfig
{
    /**
     * Challenge configuration
     */
    public string $challengeId = 'wan-vision-clash-2025';
    public string $challengeName = 'RuangAI Challenge — WAN Vision Clash';
    
    /**
     * Event dates
     */
    // public string $registrationStart = '2025-12-17 17:00:00';
    public string $registrationStart = '2025-12-10 00:00:00';
    public string $registrationEnd = '2026-03-13 23:59:59';
    public string $judgingStart = '2026-02-01 00:00:00';
    public string $judgingEnd = '2026-02-07 23:59:59';
    public string $announcementDate = '2026-02-08 00:00:00';
    
    /**
     * File upload settings
     */
    public string $uploadPath = 'writable/uploads/challenge/';
    public int $maxFileSize = 5242880; // 5MB in bytes
    public array $allowedPromptExtensions = ['pdf', 'txt'];
    public array $allowedScreenshotExtensions = ['jpg', 'jpeg', 'png'];
    public string $allowedParamsExtension = 'json';
    public string $allowedAssetsExtension = 'txt';
    
    /**
     * Video specifications
     */
    public int $maxVideoDuration = 60; // seconds
    public int $maxVideoResolution = 1080; // pixels
    public array $allowedVideoFps = [24, 30];
    
    /**
     * Team settings
     */
    public int $maxTeamMembers = 3;
    public int $minTeamMembers = 1;
    
    /**
     * Validation settings
     */
    public array $requiredHashtags = ['#WanAVideo', '#RAIChallenges'];
    public array $requiredMentions = ['@codepolitan', '@alibaba_cloud'];
    
    /**
     * Status options
     */
    public array $statusOptions = [
        'pending' => 'Pending Review',
        'validated' => 'Validated',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];
    
    /**
     * Prize configuration (total 250jt)
     */
    public array $prizes = [
        'best_video' => [
            'name' => 'Juara Best Video',
            'value' => 18000000,
            'items' => [
                'Acer Nitro Lite 16 (RTX 3050 6GB)',
                '$200 Alibaba Credits',
                'SWAG Official Codepolitan',
                'Merch Official Alibaba Cloud',
                'Kupon Kelasfullstack 90%',
            ],
        ],
        'favorite' => [
            'name' => 'Juara Favorit',
            'value' => 13000000,
            'items' => [
                'iPad 11',
                '$200 Alibaba Credits',
                'SWAG Official CODEPOLITAN',
                'Merch Official Alibaba Cloud',
                'Kupon KelasFullstack 90%',
            ],
        ],
        'favorite_alumni' => [
            'name' => 'Juara Favorit Lulusan RuangAI',
            'value' => 10000000,
            'items' => [
                'Samsung Galaxy Tab (A11+)',
                '$200 Alibaba Cloud',
                'SWAG Official CODEPOLITAN',
                'Merch Official Alibaba Cloud',
                'Kupon KelasFullstack 90%',
            ],
        ],
        'credits' => [
            'name' => '47 Pemenang Credit',
            'winners' => 47,
            'value' => 200, // $200 per winner
        ],
    ];

    /**
     * Check if registration is open
     */
    public function isRegistrationOpen(): bool
    {
        $now = time();
        $start = strtotime($this->registrationStart);
        $end = strtotime($this->registrationEnd);
        
        return $now >= $start && $now <= $end;
    }

    /**
     * Check if judging period
     */
    public function isJudgingPeriod(): bool
    {
        $now = time();
        $start = strtotime($this->judgingStart);
        $end = strtotime($this->judgingEnd);
        
        return $now >= $start && $now <= $end;
    }
}
