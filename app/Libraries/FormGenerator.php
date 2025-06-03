<?php

namespace App\Libraries;

class FormGenerator
{
    public $fields = [];

    public function __construct(array $schema)
    {
        $this->buildFields($schema['fields'] ?? []);
    }

    protected function buildFields(array $fieldSchemas)
    {
        foreach ($fieldSchemas as $fieldName => $fieldSchema) {
            $class = '\\App\\Libraries\\FormFields\\' . $fieldSchema['form'] . '\\' . $this->toClassName($fieldSchema['form']) . 'Field';
            if (class_exists($class)) {
                $this->fields[$fieldName] = new $class($fieldSchema);
            } else {
                throw new \Exception("Field type '{$fieldSchema['form']}' is not supported.");
            }
        }
    }

    public function renderFields(): string
    {
        $html = '';
        foreach ($this->fields as $field) {
            $html .= '<div class="form-group">' . "\n";
            $html .= $field->renderLabel();
            $html .= $field->renderInput();
            $html .= '</div>' . "\n";
        }
        return $html;
    }

    public function renderForm(string $action, string $method = 'POST'): string
    {
        $fieldsHtml = $this->renderFields();
        return view('forms/form', [
            'action' => $action,
            'method' => $method,
            'fieldsHtml' => $fieldsHtml,
        ]);
    }

    private function toClassName(string $str): string {
        return preg_replace_callback('/(?:^|_)([a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, $str);
    }
    
}
