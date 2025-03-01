<?php

namespace App\Libraries\FormFields\multiple_ajax;

use App\Libraries\BaseField;

class MultipleAjaxField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '[]';
    protected array $relation = [];

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): array
    {
        return json_decode($value, true) ?? [];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        return json_encode($value);
    }
}
