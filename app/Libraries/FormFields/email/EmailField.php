<?php

namespace App\Libraries\FormFields\email;

use App\Libraries\BaseField;

class EmailField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = null;
    protected string $placeholder = '';

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): string
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL) ?: '';
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : '';
    }
}
