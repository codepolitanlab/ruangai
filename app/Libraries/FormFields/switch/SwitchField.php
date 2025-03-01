<?php

namespace App\Libraries\FormFields\switch;

use App\Libraries\BaseField;

class SwitchField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = ['Off', 'On'];
}
