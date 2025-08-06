<?php

if (! function_exists('setting_item')) {

    // Get setting spessifically with context 'heroic'
    function setting_item($item, $default = '', $context = 'heroic')
    {
        // Cek apakah class Setting ada dan table-nya siap
        if (! class_exists(\CodeIgniter\Settings\Settings::class)) {
            return $default;
        }

        try {
            return service('settings')->get($item, $context);
        } catch (\Throwable $e) {
            // Bisa juga logging di sini
            return $default;
        }

        return false;
    }
}
