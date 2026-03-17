<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\url;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class UrlField extends BaseField
{
    protected string $type      = 'url';
    protected string $rules     = 'valid_url_strict';
    protected array $attributes = [
        'class' => 'form-control',
    ];

    public function render(): string
    {
        $id    = str_replace(['[', ']'], ['__', ''], $this->name);
        $value = esc($this->resolveValue());

        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] ??= true;
        }

        // Ensure valid_url_strict rule is always present
        if (! str_contains($this->rules, 'valid_url_strict')) {
            $this->rules .= '|valid_url_strict';
        }

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="url"
                        id="{$id}"
                        name="{$this->name}"
                        value="{$value}"
                        {$this->renderAttributes()} />
                    {$errorHtml}
                </div>
            HTML;
    }
}
