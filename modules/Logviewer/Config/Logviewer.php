<?php

namespace Logviewer\Config;

use CodeIgniter\Config\BaseConfig;

class Logviewer extends BaseConfig
{
    /**
     * Log directory path
     */
    public string $logPath = WRITEPATH . 'logs/';
    
    /**
     * Allowed log file extensions
     */
    public array $allowedExtensions = ['log'];
    
    /**
     * Maximum lines to display per page
     */
    public int $linesPerPage = 100;
    
    /**
     * Log levels with colors for display
     */
    public array $logLevels = [
        'emergency' => '#dc3545', // red
        'alert'     => '#fd7e14', // orange
        'critical'  => '#dc3545', // red
        'error'     => '#dc3545', // red
        'warning'   => '#ffc107', // yellow
        'notice'    => '#17a2b8', // info blue
        'info'      => '#17a2b8', // info blue
        'debug'     => '#6c757d', // gray
    ];
    
    /**
     * Date format for file names
     */
    public string $dateFormat = 'Y-m-d';
    
    /**
     * Timezone for log display
     */
    public string $timezone = 'Asia/Jakarta';
}