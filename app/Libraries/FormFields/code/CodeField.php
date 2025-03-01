<?php

namespace App\Libraries\FormFields\code;

use App\Libraries\BaseField;
use Symfony\Component\Yaml\Yaml;

class CodeField extends BaseField
{
    protected string $mode = 'html';    // html or yaml
    protected int $height = 400;

    /**
     * Konversi nilai ke format yang siap ditampilkan di input editor.
     */
    public function getValueForInput(mixed $value): mixed
    {
        if ($this->mode === 'yaml' && is_array($value)) {
            return Yaml::dump($value, 4);
        }
        return htmlentities($value);
    }

    /**
     * Konversi nilai untuk penyimpanan.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        if ($this->mode === 'yaml') {
            return Yaml::parse($value);
        }
        return $value;
    }
}
