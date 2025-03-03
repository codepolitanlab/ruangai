<?php

namespace App\Libraries\FormFields\upload;

use App\Libraries\BaseField;

class UploadField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected array $allowed_types = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'gz'];
}
