<?php

namespace App\Libraries\FormFields\radio_button;

use App\Libraries\BaseField;

class RadioButtonField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = [];
    protected bool $disabled = false;
}
