<?php

namespace Heroicadmin\Config;

use CodeIgniter\Config\BaseConfig;

class Heroicsetting extends BaseConfig
{
    public $settingClasses = [
        'heroicadmin' => \Heroicadmin\Settings\HeroicadminSetting::class,
    ];
}
