<?php

namespace App\Libraries\FormFields\markdown;

use App\Libraries\BaseField;

class MarkdownField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '';

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }
}
