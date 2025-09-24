<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\email;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class EmailField extends BaseField
{
    protected string $type      = 'email';
    protected string $rules     = 'valid_email';
    protected array $attributes = [
        'class' => 'form-control',
    ];

    public function render(): string
    {
        $id    = str_replace(['[', ']'], ['__', ''], $this->name);
        $value = esc($this->resolveValue());

        // Set default attributes
        if (! empty($this->label)) {
            $this->attributes['data-caption'] ??= $this->label;
        }

        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] ??= true;
        }

        // If rules valid_email not set yet, set it
        if (! str_contains($this->rules, 'valid_email')) {
            $this->rules .= '|valid_email';
        }

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="email"
                        id="{$id}"
                        name="{$this->name}"
                        value="{$value}"
                        {$this->renderAttributes()} />
                    {$errorHtml}
                </div>
            HTML;
    }
}
