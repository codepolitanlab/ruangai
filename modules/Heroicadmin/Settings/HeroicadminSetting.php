<?php

namespace Heroicadmin\Settings;

class HeroicadminSetting extends SettingAbstract
{
    public string $title       = 'Heroicadmin';
    public string $description = 'Heroicadmin settings';
    public array $fields       = [
        [
            'type'        => 'text',
            'name'        => 'Heroicadmin.title',
            'label'       => 'Site Title',
            'description' => 'Title of your panel site',
            'attributes'  => [
                'class' => 'form-control',
            ],
        ],
        [
            'type'        => 'text',
            'name'        => 'Heroicadmin.rootPanelUrl',
            'label'       => 'Root Panel URL',
            'description' => 'URL of default module for root panel',
            'attributes'  => [
                'class' => 'form-control',
            ],
        ],
    ];
}
