<?php

namespace App\Libraries\FormFields\currency;

use App\Libraries\BaseField;

class CurrencyField extends BaseField
{
    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): float
    {
        return is_numeric($value) ? (float) $value : $this->default;
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): float
    {
        return is_numeric($value) ? round((float) $value, 2) : $this->default;
    }
}
