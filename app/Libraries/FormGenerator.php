<?php

namespace App\Libraries;

class FormGenerator
{
    protected $fields = [];

    public function __construct(array $schema)
    {
        $this->buildFields($schema['fields'] ?? []);
    }

    protected function buildFields(array $fieldSchemas)
    {
        foreach ($fieldSchemas as $fieldName => $fieldSchema) {
            $class = 'App\\Libraries\\FormFields\\' . $this->toClassName($fieldSchema['form']) . 'Field';
            if (class_exists($class)) {
                $this->fields[$fieldName] = new $class($fieldSchema);
            } else {
                throw new \Exception("Field type '{$fieldSchema['form']}' is not supported.");
            }
        }
    }

    public function renderFields(): string
    {
        $output = '';
        foreach ($this->fields as $field) {
            $output .= $field->render();
        }
        return $output;
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
