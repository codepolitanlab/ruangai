<?php

namespace App\Libraries\FormFields\uuid;

use App\Libraries\BaseField;

class UuidField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';

    /**
     * Generate UUID jika tidak ada nilai.
     */
    public function getValueForInput(mixed $value): string
    {
        return !empty($value) ? hex2uuid($value) : strtoupper(str_replace('-', '', generate_uuid()));
    }

    /**
     * Simpan UUID dalam format hex tanpa tanda "-"
     */
    public function getValueForSaving(mixed $value): string
    {
        return strtoupper(str_replace('-', '', $value));
    }
}
