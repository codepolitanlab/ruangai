<?php

namespace App\Libraries\FormBuilder\Components\checkbox;

use App\Libraries\FormBuilder\Components\BaseField;

class CheckboxField extends BaseField
{
    protected array $options    = [];
    protected array $attributes = [
        'class' => 'form-check-input',
    ];

    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function render(): string
    {
        $values = (array) $this->resolveValue();

        $inputHtml = '';

        foreach ($this->options as $key => $label) {
            $id      = str_replace(['[', ']'], ['__', ''], $this->name . '[' . $key . ']');
            $checked = in_array($key, $values, true) ? 'checked' : '';

            $attrHtml = $this->renderAttributes();

            $inputHtml .= <<<HTML
                    <div class="form-check">
                        <input
                            name="{$this->name}[{$key}]"
                            id="{$id}"
                            type="checkbox"
                            value="{$label}"
                            {$checked}
                            {$attrHtml}>

                        <label class="form-check-label" for="{$id}">
                            {$label}
                        </label>
                    </div>
                HTML;
        }

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    {$inputHtml}
                    {$errorHtml}
                </div>
            HTML;
    }
}
