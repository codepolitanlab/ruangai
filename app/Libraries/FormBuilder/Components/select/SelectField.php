<?php

namespace App\Libraries\FormBuilder\Components\select;

use App\Libraries\FormBuilder\Components\BaseField;

class SelectField extends BaseField
{
    protected array $options    = [];
    protected array $attributes = [
        'class' => 'form-select',
    ];

    public function setOptions(array $options): static
    {
        $this->options = $options;

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

        $attrHtml = $this->renderAttributes();

        $optionsHtml = '<option value="">-pilih opsi-</option>';

        foreach ($this->options as $key => $label) {
            $isSelected = ($key === $selected) ? 'selected' : '';
            $optionsHtml .= '<option value="' . esc($key) . "\" {$isSelected}>" . esc($label) . '</option>';
        }

        $errorHtml = $this->hasError()
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
}
