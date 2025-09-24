<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\select;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class SelectField extends BaseField
{
    protected array $options    = [];
    protected array $relation   = [];
    protected array $attributes = [
        'class' => 'form-select',
    ];

    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }
    
    public function setRelation(array $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function render(): string
    {
        $id       = str_replace(['[', ']'], ['__', ''], $this->name);
        $selected = $this->resolveValue();

        // Tambahkan required dan caption jika perlu
        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] ??= true;
        }

        if (! empty($this->label)) {
            $this->attributes['data-caption'] ??= $this->label;
        }

        $attrHtml    = $this->renderAttributes();
        $optionsHtml = $this->generateOptions($selected);
        $errorHtml   = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <select id="{$id}" name="{$this->name}" {$attrHtml}>
                        {$optionsHtml}
                    </select>
                    {$errorHtml}
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            if (window.jQuery && typeof $.fn.select2 !== "undefined") {
                                $("#{$id}").select2();
                            }
                        });
                    </script>
                </div>
            HTML;
    }

    private function generateOptions(string $selected = ''): string
    {
        $optionsHtml = '<option value="">-pilih opsi-</option>';

        // If select use attribute options
        if($this->options) {
            foreach ($this->options as $key => $label) {
                $isSelected = ($key === $selected) ? 'selected' : '';
                $optionsHtml .= '<option value="' . esc($key) . "\" {$isSelected}>" . esc($label) . '</option>';
            }
        }

        // If select use relation
        elseif ($this->relation) {
            $db = db_connect();
            $builder = $db->table($this->relation['table']);
            $builder->select([$this->relation['label'], $this->relation['foreignKey']]);
            $options = $builder->get()->getResultArray();

            foreach ($options as $option) {
                $isSelected = ($option[$this->relation['foreignKey']] === $selected) ? 'selected' : '';
                $optionsHtml .= '<option value="' . esc($option[$this->relation['foreignKey']]) . "\" {$isSelected}>" . esc($option[$this->relation['label']]) . '</option>';
            }
        }

        return $optionsHtml;
    }

}
