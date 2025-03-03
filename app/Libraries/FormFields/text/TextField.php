<?php

namespace App\Libraries\FormFields\text;

use App\Libraries\BaseField;

class TextField extends BaseField
{
    /**
     * TextField langsung menyimpan string tanpa perubahan.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return (string) $value;
    }
}
