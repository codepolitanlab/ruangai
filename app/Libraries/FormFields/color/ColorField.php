<?php

namespace App\Libraries\FormFields\color;

use App\Libraries\BaseField;

class ColorField extends BaseField
{
    protected mixed $default = '#000000'; // Default warna hitam

    /**
     * Pastikan nilai warna selalu dalam format hex (`#RRGGBB`).
     */
    public function getValueForInput(mixed $value): string
    {
        return $this->validateColor($value) ? $value : $this->default;
    }

    /**
     * Konversi nilai sebelum disimpan, pastikan dalam format hex.
     */
    public function getValueForSaving(mixed $value): string
    {
        return $this->validateColor($value) ? $value : $this->default;
    }

    /**
     * Validasi apakah string adalah format warna hex.
     */
    private function validateColor(string $color): bool
    {
        return preg_match('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/', $color);
    }
}
