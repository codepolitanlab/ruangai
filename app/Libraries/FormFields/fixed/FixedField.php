<?php

namespace App\Libraries\FormFields\fixed;

use App\Libraries\BaseField;

class FixedField extends BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $rules = '';
    protected mixed $default = null;
    protected array $relation = [];
    protected bool $hideForm = true;

    /**
     * Konversi nilai sebelum ditampilkan di input.
     */
    public function getValueForInput(mixed $value): array
    {
        $ci = ci(); // Akses instance CodeIgniter
        $valueLabel = '';

        if (!empty($this->relation)) {
            if (!isset($this->relation['filter_by'])) {
                show_error('Form type fixed requires relation.filter_by to be set.');
            }
            if (!isset($_GET['filter'])) {
                show_error('Form type fixed requires query string "filter" to be set.');
            }

            // Dapatkan model entry
            $relEntry = $this->relation['entry'];
            $modelName = $this->relation['model'] ?? ucfirst($relEntry) . 'Model';

            if (!isset($ci->$modelName)) {
                $ci->$modelName = setup_entry_model($relEntry);
            }

            foreach ($this->relation['filter_by'] as $localField => $foreignField) {
                $filterValue = $_GET['filter'][$foreignField] ?? '';
                if ($filterValue === "null") {
                    $ci->db->where("$localField IS NULL", null, false);
                } else {
                    $ci->$modelName->where($localField, $filterValue);
                }
            }

            $data = $ci->$modelName->get();
            $valueLabel = $data[$this->relation['dropdown_caption'] ?? $this->relation['caption']] ?? '';

            return [
                'value' => $filterValue,
                'valueLabel' => $valueLabel
            ];
        }

        return ['value' => $value, 'valueLabel' => $value];
    }

    /**
     * Konversi nilai sebelum disimpan ke database.
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return $value;
    }
}
