<?php

namespace Heroicadmin\Modules\Setting\Controllers;

use Heroicadmin\Controllers\AdminController;

class Setting extends AdminController
{
    public function __construct()
    {
        // Load setting helper
        helper('setting');
    }

    public function index($currentSetting = 'heroicadmin')
    {
        $this->data['page_title'] = 'Settings';
        $this->data['module']     = 'config';
        $this->data['submodule']  = 'setting';

        $settingSchemas       = config('Heroicsetting')->settingClasses;
        $settingSchemaObjects = [];

        foreach ($settingSchemas as $settingSlug => $settingSchema) {
            $settingSchemaObjects[$settingSlug] = new $settingSchema();
        }
        $this->data['schemas'] = $settingSchemaObjects;
        $this->data['current'] = $currentSetting;

        // Inject placeholder using current setting value
        $currentSettingFields = $settingSchemaObjects[$currentSetting]->fields;

        foreach ($currentSettingFields as $key => $field) {
            $currentSettingFields[$key]['label'] .= ' &middot; <code class="fw-normal text-muted">' . $field['name'] . '</code>';

            // Set placeholder using global value
            $globalValue  = service('settings')->get($field['name']);
            $contextValue = service('settings')->get($field['name'], 'heroic');
            if ($globalValue === $contextValue) {
                $currentSettingFields[$key]['attributes']['placeholder'] = $globalValue;
            } else {
                $currentSettingFields[$key]['default'] = $contextValue;
            }
        }

        $FormBuilder = new \App\Libraries\FormBuilder\FormBuilder();
        $FormBuilder->schemaArray($currentSettingFields);

        $this->data['form'] = $FormBuilder->render();

        return pageView('Heroicadmin\Modules\Setting\Views\index', $this->data);
    }

    public function save($currentSetting = 'heroicadmin')
    {
        $settingSchemas      = config('Heroicsetting')->settingClasses;
        $settingSchemaObject = new $settingSchemas[$currentSetting]();

        $postdata = $this->request->getPost();

        foreach ($postdata as $key => $value) {
            // Change first underscore from key to dot
            // For example, from `setting_sub_title` to `setting.sub_title`
            $tempKeyArray                          = explode('_', $key, 2);
            $postdata[implode('.', $tempKeyArray)] = $value;
        }

        foreach ($settingSchemaObject->fields as $field) {
            $value = $postdata[$field['name']] ?? '';

            if ($value === service('settings')->get($field['name'], 'heroic')) {
                continue;
            }
            if (empty($value)) {
                service('settings')->forget($field['name'], 'heroic');
            } else {
                // Save setting with context 'heroic' to differentiate from global
                service('settings')->set($field['name'], $value, 'heroic');
            }
        }

        return redirect()->back()->with('success_message', 'Settings saved');
    }
}
