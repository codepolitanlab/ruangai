<?php

namespace App\Libraries\FormFields\file;

use App\Libraries\BaseField;

class FileField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = null;
    protected string $uploadPath = 'uploads/';
    protected bool $allowMultiple = false;

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
