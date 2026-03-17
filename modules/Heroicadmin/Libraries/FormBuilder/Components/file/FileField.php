<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\file;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class FileField extends BaseField
{
    protected string $type       = 'file';
    protected bool $multiple     = false;
    protected string $accept     = '';
    protected array $attributes  = [
        'class' => 'form-control',
    ];

    public function setMultiple(bool $value = true): static
    {
        $this->multiple = $value;

        return $this;
    }

    public function setAccept(string $accept): static
    {
        $this->accept = $accept;

        return $this;
    }

    public function render(): string
    {
        $id = str_replace(['[', ']'], ['__', ''], $this->name);

        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] ??= true;
        }

        if ($this->multiple) {
            $this->attributes['multiple'] = true;
        }

        if (! empty($this->accept)) {
            $this->attributes['accept'] = $this->accept;
        }

        $currentValue = $this->resolveValue();
        $previewHtml  = '';

        if (! empty($currentValue)) {
            $previewHtml = <<<HTML
                    <div class="mt-1">
                        <small class="text-muted">File saat ini: <a href="{$currentValue}" target="_blank">{$currentValue}</a></small>
                        <input type="hidden" name="{$this->name}_current" value="{$currentValue}">
                    </div>
                HTML;
        }

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="file"
                        id="{$id}"
                        name="{$this->name}"
                        {$this->renderAttributes()} />
                    {$previewHtml}
                    {$errorHtml}
                </div>
            HTML;
    }
}
