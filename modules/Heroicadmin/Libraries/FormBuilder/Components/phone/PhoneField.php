<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\phone;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class PhoneField extends BaseField
{
    protected string $type      = 'tel';
    protected array $attributes = [
        'class'     => 'form-control',
        'inputmode' => 'tel',
    ];

    public function render(): string
    {
        $id    = str_replace(['[', ']'], ['__', ''], $this->name);
        $value = esc($this->resolveValue());

        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] ??= true;
        }

        $this->attributes['oninput'] ??= "this.value = this.value.replace(/[^0-9+\-\s()]/g, '')";

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="tel"
                        id="{$id}"
                        name="{$this->name}"
                        value="{$value}"
                        {$this->renderAttributes()} />
                    {$errorHtml}
                </div>
            HTML;
    }
}
