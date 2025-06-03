<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class PanelSettings extends BaseConfig
{
    // Register panel settings here
    public $settingPaths = [
        'site'    => [
            'label' => 'Site',
            'path' => 'app/Pages/zpanel/configuration/setting_site.yml',
        ],
        'webpush' => [
            'label' => 'Web Push',
            'path' => 'app/Pages/webpush/setting_webpush.yml',
        ]
    ];
}