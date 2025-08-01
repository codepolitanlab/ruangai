<?php

namespace App\Libraries\FormBuilder\Components\text;

use App\Libraries\FormBuilder\Components\BaseField;

class TextField extends BaseField
{
    protected string $type      = 'text';
    protected bool $numericOnly = false;
    protected bool $validUrl    = false;
    protected array $attributes = [
        'class' => 'form-control',
    ];

    public function setNumericOnly(bool $value = true): static
    {
        $this->numericOnly = $value;

        if ($this->numericOnly) {
            if (empty($this->rules)) {
                $this->rules = 'numeric';
            } elseif (! str_contains($this->rules, 'numeric')) {
                $this->rules .= '|numeric';
            }
        }

        return $this;
    }

    public function setValidUrl(bool $value = true): static
    {
        $this->validUrl = $value;

        if ($this->validUrl) {
            if (empty($this->rules)) {
                $this->rules = 'valid_url_strict';
            } elseif (! str_contains($this->rules, 'valid_url_strict')) {
                $this->rules .= '|valid_url_strict';
            }
        }

        return $this;
    }

    public function render(): string
    {
        $id = str_replace(['[', ']'], ['__', ''], $this->name);

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        $value = esc($this->resolveValue());

        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] ??= true;
        }

        // Tambahkan atribut input numeric jika diperlukan
        if ($this->numericOnly) {
            $this->attributes['inputmode'] = 'numeric';
            $this->attributes['pattern']   = '\d*';
            $this->attributes['oninput']   = "this.value = this.value.replace(/[^0-9]/g, '')";
        }

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="text"
                        id="{$id}"
                        name="{$this->name}"
                        value="{$value}"
                        {$this->renderAttributes()} />

                    {$errorHtml}
                </div>
            HTML;
    }
}
