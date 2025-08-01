<?php

namespace Course\Config;

use CodeIgniter\Config\BaseConfig;

class Course extends BaseConfig
{
    public $waitToEnableButtonUnderstand = 1000 * 60;

    // Zoom credentials
    public $zoomAccountID    = '';
    public $zoomClientID     = '';
    public $zoomClientSecret = '';
}
