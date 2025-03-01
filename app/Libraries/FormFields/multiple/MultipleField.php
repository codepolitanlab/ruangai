<?php

namespace App\Libraries\FormFields\multiple;

use App\Libraries\BaseField;

class MultipleField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = [];
    protected mixed $default = [];
    protected ?string $optionSource = null;
    protected array $relation = [];

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): array
    {
        if (is_string($value)) {
            return explode(',', $value);
        }
        return is_array($value) ? $value : [];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        return json_encode($value);
    }

    /**
     * Ambil daftar opsi untuk multiple select.
     */
    public function getOptions(): array
    {
        if ($this->optionSource) {
            return ci()->shared['ActionClass']->{$this->optionSource}();
        }
        return $this->options;
    }
}
