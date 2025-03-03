<?php

namespace App\Libraries\FormFields\password;

use App\Libraries\BaseField;

class PasswordField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected string $placeholder = '';

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}
