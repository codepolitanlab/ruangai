<?php

namespace App\Libraries\FormFields\radio;

use App\Libraries\BaseField;

class RadioField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = [];
    protected bool $inline = false;
    protected bool $disabled = false;
}
