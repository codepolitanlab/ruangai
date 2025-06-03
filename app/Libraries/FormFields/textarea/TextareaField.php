<?php

namespace App\Libraries\FormFields\textarea;

use App\Libraries\BaseField;

class TextareaField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '';
    protected mixed $value;
    protected string $placeholder = '';
    protected int $rows = 5;
    protected array $attr = [];
}