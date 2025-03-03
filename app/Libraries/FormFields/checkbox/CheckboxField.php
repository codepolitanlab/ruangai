<?php

namespace App\Libraries\FormFields\checkbox;

use App\Libraries\BaseField;

class CheckboxField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = [];
    protected mixed $value;

    public function getValueForInput(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        } else {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
    }

    /**
     * Konversi array dari form menjadi JSON sebelum disimpan.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return json_encode($value);
    }
}
