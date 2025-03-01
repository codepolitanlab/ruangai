<?php

namespace App\Libraries\FormFields\gallery;

use App\Libraries\BaseField;

class GalleryField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = '[]';
    protected string $uploadPath = 'uploads/gallery/';

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): array
    {
        $preloaded = [];

        if (!empty($value)) {
            $arrayValue = json_decode($value, true);
            if ($arrayValue) {
                foreach ($arrayValue as $val) {
                    if (!file_exists($val['file'])) continue;
                    $preloaded[] = [
                        'name' => $val['name'],
                        'type' => $val['type'],
                        'size' => filesize($val['file']),
                        'file' => $val['file'],
                        'data' => [
                            'url' => isset($val['url']) ? $val['url'] : str_replace('./', base_url(), $val['file']),
                        ]
                    ];
                }
            }
        }

        return !empty($preloaded) ? $preloaded : [];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): string
    {
        return json_encode($value);
    }
}
