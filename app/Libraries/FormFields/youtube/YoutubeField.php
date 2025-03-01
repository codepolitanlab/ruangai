<?php

namespace App\Libraries\FormFields\youtube;

use App\Libraries\BaseField;

class YoutubeField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected ?string $placeholder = null;

    /**
     * Ekstrak ID video dari URL Youtube jika diberikan
     */
    public function getValueForSaving(mixed $value): string
    {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $value, $matches)) {
            return $matches[1]; // Simpan hanya ID video
        }
        return $value;
    }
}
