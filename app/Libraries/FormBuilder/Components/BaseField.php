<?php

namespace App\Libraries\FormBuilder\Components;

use InvalidArgumentException;

abstract class BaseField
{
    protected string $name;
    protected string $label        = '';
    protected string $description  = '';
    protected string $type         = '';
    protected string $rules        = '';
    protected array $errorMessages = [];
    protected mixed $value         = null;
    protected mixed $default       = null;
    protected ?string $error       = null;
    protected array $attributes    = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public static function fromArray(array $data): static
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException("Field 'name' is required.");
        }
        $field = new static($data['name']);

        if (isset($data['attributes']) && is_array($data['attributes'])) {
            $field->setAttributes($data['attributes']);
        }

        if (isset($data['errorMessages']) && is_array($data['errorMessages'])) {
            $field->setErrorMessages($data['errorMessages']);
        }

        // Setter otomatis berdasarkan properti field
        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'attributes', 'errorMessages'], true)) {
                continue; // sudah di-handle
            }

            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            // Jika setter tersedia dan callable, panggil
            if (method_exists($field, $setter) && is_callable([$field, $setter])) {
                $field->{$setter}($value);
            }
            // Atau jika properti ada dan tidak private, set langsung
            elseif (property_exists($field, $key)) {
                $field->{$key} = $value;
            }
        }

        return $field;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set CI4 validation rules
     */
    public function setRules(string $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get CI4 validation rules
     */
    public function getRules(): string
    {
        return $this->rules;
    }

    /**
     * Set custom error messages untuk CodeIgniter validation
     *
     * @param array $messages Format: ['rule' => 'message']
     */
    public function setErrorMessages(array $messages): static
    {
        $this->errorMessages = $messages;

        return $this;
    }

    /**
     * Get custom error messages
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function setError(?string $message): static
    {
        $this->error = $message;

        return $this;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function hasError(): bool
    {
        return null !== $this->error;
    }

    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get final value: dari old input, value explicit, atau default
     */
    public function resolveValue(): mixed
    {
        $name = $this->getName();

        // Jika ada old input dari form sebelumnya
        if (old($name) !== null) {
            return old($name);
        }

        // Jika sudah di-set secara eksplisit
        if (null !== $this->value && $this->value !== '') {
            return $this->value;
        }

        // Jika tidak ada, fallback ke default
        return $this->default ?? null;
    }

    /**
     * Set custom attribute not listed in allowedAttributes
     */
    public function setAttribute(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Optional: set multiple custom attributes at once
     */
    public function setAttributes(array $attrs): static
    {
        foreach ($attrs as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    protected function renderAttributes(): string
    {
        return implode(' ', array_map(function ($key) {
            $val = $this->attributes[$key];

            return is_bool($val)
                ? ($val ? $key : '')
                : "{$key}=\"" . esc($val) . '"';
        }, array_keys($this->attributes)));
    }

    public function renderOutput(): mixed
    {
        return $this->value;
    }

    public function renderLabel(): string
    {
        $requiredMark = (! empty($this->attributes['required']) && $this->attributes['required'] !== false)
            ? '<span class="text-danger ms-1">*</span>'
            : '';

        return <<<HTML
                <div class="form-label">
                    <label for="{$this->name}">
                        {$this->label}{$requiredMark}
                    </label>
                    <small class="d-block">{$this->description}</small>
                </div>
            HTML;
    }

    abstract public function render(): string;
}
