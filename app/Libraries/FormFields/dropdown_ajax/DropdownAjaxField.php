<?php

namespace App\Libraries\FormFields\dropdown_ajax;

use App\Libraries\BaseField;

class DropdownAjaxField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected string $table = '';
    protected string $foreignKey = 'id';
    protected array $searchBy = [];
    protected string $placeholder = '';
    protected array $relation = [];

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): array
    {
        if (!empty($value) && isset($this->relation['searchby'])) {
            $db = db_connect();
            $record = $db->table($this->table)
                ->select(implode(',', $this->relation['searchby']))
                ->where($this->foreignKey, $value)
                ->get()
                ->getRowArray();

            if ($record) {
                $captions = [];
                foreach ($this->relation['searchby'] as $caption) {
                    $captions[] = $record[$caption] ?? '';
                }
                return [
                    'id' => $value,
                    'text' => implode(" - ", $captions)
                ];
            }
        }
        return ['id' => '', 'text' => ''];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return $value;
    }
}
