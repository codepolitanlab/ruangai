<?php

namespace Certificate\Libraries;

class CertificateTemplateFactory
{
    /**
     * Get certificate template by name/type
     */
    public static function getTemplate(string $templateName = 'default', array $studentData = []): CertificateTemplate
    {
        $template = self::getTemplateByName($templateName, $studentData);

        if ($template) {
            return $template;
        }

        // Fallback to default template
        return new DefaultCertificateTemplate($studentData);
    }

    /**
     * Get template by name
     */
    public static function getTemplateByName(string $name, array $student = []): ?CertificateTemplate
    {
        // Check if certificate template class exists in config
        $config = new \Certificate\Config\Certificate();
        if (isset($config->availableTemplates[$name])) {
            $className = $config->availableTemplates[$name];
            if (class_exists($className)) {
                return new $className($student);
            }
        }

        return null;
    }
}
