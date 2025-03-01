<?php

namespace App\Libraries\FormFields\hidden;

use App\Libraries\BaseField;

class HiddenField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '';

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): mixed
    {
        return $value ?? $this->default;
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return $value;
    }
}
