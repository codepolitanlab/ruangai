<?php

namespace App\Libraries\FormFields\date;

use App\Libraries\BaseField;

class DateField extends BaseField
{
    protected string $format = 'd-m-Y'; // Format tampilan di input
    protected string $dbFormat = 'Y-m-d'; // Format penyimpanan di database

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): string
    {
        if (!empty($value)) {
            return date($this->format, strtotime($value));
        }
        return '';
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        if (!empty($value)) {
            return date($this->dbFormat, strtotime($value));
        }
        return '';
    }
}
