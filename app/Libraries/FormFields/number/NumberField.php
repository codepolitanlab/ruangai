<?php

namespace App\Libraries\FormFields\number;

use App\Libraries\BaseField;

class NumberField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = 0;
    protected array $attributes = [];
    protected bool $disableSpinner = false; // Menonaktifkan tombol increase/decrease

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): mixed
    {
        return is_numeric($value) ? $value : $this->default;
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return is_numeric($value) ? $value : $this->default;
    }
}
