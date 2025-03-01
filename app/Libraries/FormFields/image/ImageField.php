<?php

namespace App\Libraries\FormFields\image;

use App\Libraries\BaseField;

class ImageField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = null;
    protected string $uploadPath = 'uploads/images/';

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
