<?php

namespace App\Libraries\FormFields\duration;

use App\Libraries\BaseField;

class DurationField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '00:00:00';

    /**
     * Konversi nilai sebelum ditampilkan di input (pisahkan jam, menit, detik).
     */
    public function getValueForInput(mixed $value): array
    {
        if (!empty($value) && strpos($value, ':') !== false) {
            list($h, $m, $s) = explode(':', $value);
            return [
                'hour' => str_pad($h, 2, '0', STR_PAD_LEFT),
                'minute' => str_pad($m, 2, '0', STR_PAD_LEFT),
                'second' => str_pad($s, 2, '0', STR_PAD_LEFT)
            ];
        }
        return ['hour' => '00', 'minute' => '00', 'second' => '00'];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        if (is_array($value) && isset($value['hour'], $value['minute'], $value['second'])) {
            return sprintf('%02d:%02d:%02d', $value['hour'], $value['minute'], $value['second']);
        }
        return $this->default;
    }
}
