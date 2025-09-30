<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\number;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class NumberField extends BaseField
{
    protected string $type         = 'number';
    protected bool $disableSpinner = true;
    protected array $attributes    = [
        'class'        => 'form-control',
        'autocomplete' => 'off',
    ];

    public function render(): string
    {
        $id    = str_replace(['[', ']'], ['__', ''], $this->name);
        $value = esc($this->resolveValue());

        // Spinner toggle
        $disableSpinner = $this->disableSpinner ?? false;

        // Inject class for spinner disable if needed
        if ($disableSpinner) {
            $this->attributes['class'] .= ' disable-spinner';
            $this->attributes['inputmode'] = 'numeric';
        }

        // Required if rules include "required"
        if (isset($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] = true;
        }

        // Caption (used as data-caption)
        if (isset($this->label)) {
            $this->attributes['data-caption'] = $this->label;
        }

        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="number"
                        id="{$id}"
                        name="{$this->name}"
                        value="{$value}"
                        {$this->renderAttributes()} />
                    {$errorHtml}
                    {$this->renderDisableSpinnerStyle($id)}
                </div>
            HTML;
    }

    protected function renderDisableSpinnerStyle($id = ''): string
    {
        if (! ($this->disableSpinner ?? false)) {
            return '';
        }

        return <<<STYLE
            <style>
                #{$id}.disable-spinner::-webkit-outer-spin-button,
                #{$id}.disable-spinner::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                #{$id}.disable-spinner {
                    -moz-appearance: textfield;
                }
            </style>
            STYLE;
    }
}
