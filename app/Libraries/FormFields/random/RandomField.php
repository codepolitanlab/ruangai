<?php

namespace App\Libraries\FormFields\random;

use App\Libraries\BaseField;

class RandomField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected string $mode = 'alnum';
    protected int $digit = 8;
    protected bool $uppercase = false;
    protected ?string $time_prefix = null;
    protected ?string $date_prefix = null;
    protected bool $writable = false;

    /**
     * Generate nilai default jika belum ada.
     */
    public function getValueForInput(mixed $value): string
    {
        if ($value) {
            return $value;
        }
        $random = random_string($this->mode, $this->digit);
        if ($this->uppercase) $random = strtoupper($random);
        if ($this->time_prefix) $random = date($this->time_prefix) . $random;
        if ($this->date_prefix) $random = date($this->date_prefix) . $random;
        return $random;
    }
}
