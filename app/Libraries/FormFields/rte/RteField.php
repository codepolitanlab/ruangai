<?php

namespace App\Libraries\FormFields\rte;

use App\Libraries\BaseField;

class RteField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected bool $enable_image = true;
    protected bool $enable_table = true;
    protected bool $enable_media_embed = true;
    protected bool $enable_html_embed = true;
    protected bool $enable_source = true;
}
