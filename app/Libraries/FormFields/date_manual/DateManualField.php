<?php

namespace App\Libraries\FormFields\date_manual;

use App\Libraries\BaseField;

class DateManualField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected string $format = 'd-m-Y'; // Format tampilan
    protected string $dbFormat = 'Y-m-d'; // Format penyimpanan

    /**
     * Konversi nilai sebelum ditampilkan di input (memisahkan hari, bulan, tahun).
     */
    public function getValueForInput(mixed $value): array
    {
        if (!empty($value)) {
            return [
                'year' => date('Y', strtotime($value)),
                'month' => date('m', strtotime($value)),
                'day' => date('d', strtotime($value)),
            ];
        }
        return ['day' => '', 'month' => '', 'year' => ''];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        if (is_array($value) && isset($value['day'], $value['month'], $value['year'])) {
            $formattedDate = "{$value['year']}-{$value['month']}-{$value['day']}";
            return date($this->dbFormat, strtotime($formattedDate));
        }
        return '';
    }
}
