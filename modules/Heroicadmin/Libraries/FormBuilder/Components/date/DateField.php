<?php

namespace Heroicadmin\Libraries\FormBuilder\Components\date;

use Heroicadmin\Libraries\FormBuilder\Components\BaseField;

class DateField extends BaseField
{
    protected string $type      = 'text'; // input visible tetap type="text"
    protected string $format    = 'DD/MM/YYYY';
    protected string $dbFormat  = 'YYYY-MM-DD';
    protected array $attributes = [
        'class'        => 'form-control',
        'autocomplete' => 'off',
        'data-toggle'  => 'datepicker',
    ];

    public function setFormat(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function setDbFormat(string $format): static
    {
        $this->dbFormat = $format;

        return $this;
    }

    public function render(): string
    {
        $id            = str_replace(['[', ']'], ['__', ''], $this->name);
        $visibleValue  = esc($this->value['date'] ?? '');
        $originalValue = esc($this->value['original'] ?? '');

        // Required rule
        if (! empty($this->rules) && str_contains($this->rules, 'required')) {
            $this->attributes['required'] = true;
        }

        // Caption
        if (! empty($this->label)) {
            $this->attributes['data-caption'] = $this->label;
        }

        $attrHtml  = $this->renderAttributes();
        $errorHtml = $this->hasError()
            ? "<div class=\"invalid-feedback d-block\">{$this->getError()}</div>"
            : '';

        return <<<HTML
                <div class="form-group">
                    {$this->renderLabel()}
                    <input
                        type="text"
                        id="{$id}"
                        value="{$visibleValue}"
                        {$attrHtml} />

                    <input type="hidden"
                           id="real_{$id}"
                           name="{$this->name}"
                           value="{$originalValue}">

                    {$errorHtml}

                    <script>
                        $(function() {
                            $('#{$id}').datepicker({
                                format: '{$this->format}'
                            });
                            $('#{$id}').on('change', function() {
                                let mydate = moment($(this).val(), "{$this->format}").format("{$this->dbFormat}");
                                $('#real_{$id}').val(mydate);
                            });
                        });
                    </script>
                </div>
            HTML;
    }
}
