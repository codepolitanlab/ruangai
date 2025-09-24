<?php

namespace Heroicadmin\Libraries\FormBuilder\Traits;

trait FieldResolverTrait
{
    protected function toClassName(string $type): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $type)));
    }

    protected function resolveFieldClass(string $type): string
    {
        $className = $this->toClassName($type) . 'Field';

        return "\\Heroicadmin\\Libraries\\FormBuilder\\Components\\{$type}\\{$className}";
    }
}
