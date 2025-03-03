<?php

namespace App\Libraries\FormFields\date;

use App\Libraries\BaseField;

class DateField extends BaseField
{
    protected string $format = 'DD-MM-YYYY'; // Moment.js Format tampilan di input
    protected string $dbFormat = 'YYYY-MM-DD'; // Moment.js Format penyimpanan di database

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): array
    {
        if (!empty($value)) {
            return [
                'date' => date("d-m-Y", strtotime($value)),
                'original' => date("Y-m-d", strtotime($value)),
            ];
        }
        return ['date' => '', 'original' => ''];
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
