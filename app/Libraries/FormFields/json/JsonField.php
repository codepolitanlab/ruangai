<?php

namespace App\Libraries\FormFields\json;

use App\Libraries\BaseField;

class JsonField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '{}';

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): string
    {
        $decoded = json_decode($value, true);
        return $decoded ? json_encode($decoded, JSON_PRETTY_PRINT) : '';
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        $decoded = json_decode($value, true);
        return json_encode($decoded ?? []);
    }
}
