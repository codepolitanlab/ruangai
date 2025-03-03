<?php

namespace App\Libraries;

abstract class BaseField
{
    protected string $name = '';
    protected string $label = '';
    protected string $type = '';
    protected string $placeholder = '';
    protected string $rules = '';
    protected mixed $default = null;
    protected array $attr = [];
    protected mixed $value;

    public function __construct(array $attributes, mixed $value = null)
    {
        // Assign properti dari array ke atribut masing-masing
        foreach ($attributes as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }

        // Assign nilai jika diberikan
        $this->value = $value;
    }
    
    // Getter untuk mendapatkan semua properti sebagai array
    public function getProps(): array
    {
        return get_object_vars($this);
    }

    /**
     * Konversi nilai yang diterima dari form ke format yang siap disimpan.
     * Default: Tidak diubah, bisa di-override di subclass
     */
    public function getValueForSaving(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Konversi nilai untuk dapat dipakai di view input
     * Default: Tidak diubah, bisa di-override di subclass
     */
    public function getValueForInput(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Konversi nilai untuk dapat dipakai di view output
     * Default: Tidak diubah, bisa di-override di subclass
     */
    public function getValueForOutput(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Generate attribute string untuk elemen input.
     */
    protected function getAttributeString(): string
    {
        if (empty($this->attr)) {
            return '';
        }

        $attrs = [];
        foreach ($this->attr as $key => $val) {
            $attrs[] = $key . '="' . htmlentities($val) . '"';
        }

        return implode(' ', $attrs);
    }

    /**
     * Render field form untuk input.
     */
    public function renderInput($value = null): string
    {
        $classPath = (new \ReflectionClass($this))->getFileName();
        $viewPath = dirname($classPath) . DIRECTORY_SEPARATOR . 'input.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("Input view file not found for field: " . $this->name);
        }

        ob_start();
        extract([
            'config' => $this->getProps(),
            'value' => esc($this->getValueForInput($value ?? $this->value ?? $this->default)),
            'attributes' => $this->getAttributeString()
        ]);
        include $viewPath;
        return ob_get_clean();
    }


    /**
     * Render field value untuk output.
     */
    public function renderOutput($value): string
    {
        $classPath = (new \ReflectionClass($this))->getFileName();
        $viewPath = dirname($classPath) . DIRECTORY_SEPARATOR . 'output.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("Output view file not found for field: " . $this->name);
        }

        ob_start();
        extract(['value' => esc($this->getValueForOutput($value ?? $this->value ?? $this->default))] + $this->getProps());
        include $viewPath;
        return ob_get_clean();
    }
}
