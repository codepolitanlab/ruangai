<?php

namespace App\Libraries\FormFields\radio_mixed;

use App\Libraries\BaseField;

class RadioMixedField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $options = [];
    protected string $placeholder = 'Lainnya...';
}
