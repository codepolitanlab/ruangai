<?php

namespace Certificate\Libraries;

class CertificateTemplateLibrary
{
    protected $templates = [];

    public function __construct()
    {
        $this->loadTemplates();
    }

    /**
     * Load all available certificate templates
     */
    protected function loadTemplates()
    {
        // Load all template classes from Libraries directory
        $templateClasses = [
            DefaultCertificateTemplate::class,
            ComentorCertificateTemplate::class,
            WorkshopAVPNCertificateTemplate::class,
        ];

        foreach ($templateClasses as $class) {
            if (class_exists($class)) {
                $template = new $class();
                $this->templates[$template->getName()] = $template;
            }
        }
    }

    /**
     * Get all available templates
     *
     * @return CertificateTemplate[]
     */
    public function getAllTemplates(): array
    {
        return $this->templates;
    }

    /**
     * Get template by name
     *
     * @param string $name
     * @return CertificateTemplate|null
     */
    public function getTemplate(string $name): ?CertificateTemplate
    {
        return $this->templates[$name] ?? null;
    }

    /**
     * Check if template exists
     *
     * @param string $name
     * @return bool
     */
    public function hasTemplate(string $name): bool
    {
        return isset($this->templates[$name]);
    }

    /**
     * Get template names as array
     *
     * @return array
     */
    public function getTemplateNames(): array
    {
        return array_keys($this->templates);
    }

    /**
     * Get templates as options for select dropdown
     *
     * @return array [name => description]
     */
    public function getTemplateOptions(): array
    {
        $options = [];
        foreach ($this->templates as $name => $template) {
            $options[$name] = $template->getDescription();
        }
        return $options;
    }
}
