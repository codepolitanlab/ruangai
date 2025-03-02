<?php

namespace App\Libraries\FormFields\dropdown;

use App\Libraries\BaseField;

class DropdownField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = [];
    protected mixed $default = '';

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): mixed
    {
        return $value ?? $this->default;
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Ambil daftar opsi untuk dropdown.
     */
    public function getOptions(): array
    {
        // Jika menggunakan sumber opsi eksternal
        if ($this->optionSource) {
            return ['' => '-- Pilih ' . $this->label . ' --'] + ci()->shared['ActionClass']->{$this->optionSource}();
        }

        return $this->options;
    }
}
