<?php

namespace App\Libraries\FormFields\datetime;

use App\Libraries\BaseField;

class DatetimeField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected string $format = 'DD-MM-YYYY'; // Moment.js Format tampilan di input
    protected string $dbFormat = 'YYYY-MM-DD'; // Moment.js Format penyimpanan di database

    /**
     * Konversi nilai sebelum ditampilkan di input (pisahkan date dan time).
     */
    public function getValueForInput(mixed $value): array
    {
        if (!empty($value)) {
            return [
                'date' => date('d-m-Y', strtotime($value)),
                'time' => date('H:i', strtotime($value)),
                'original' => date("Y-m-d H:i:s", strtotime($value)),
            ];
        }
        return ['date' => '', 'time' => '', 'original' => ''];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        if (is_array($value) && isset($value['date'], $value['time'])) {
            $formattedDateTime = "{$value['date']} {$value['time']}:00";
            return date($this->dbFormat, strtotime($formattedDateTime));
        }
        return '';
    }
}
