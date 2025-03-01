<?php

namespace App\Libraries\FormFields\total;

use App\Libraries\BaseField;

class TotalField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $sum = [];
}
