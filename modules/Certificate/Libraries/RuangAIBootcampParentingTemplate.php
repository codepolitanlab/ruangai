<?php

namespace Certificate\Libraries;

/**
 * Varian artwork bootcamp untuk Mastery Class Webinar Parenting di Era AI.
 * Layout sama dengan template-ruangai-bootcamp.png, hanya background berbeda
 * (teks statis kelas sudah tercetak di artwork).
 */
class RuangAIBootcampParentingTemplate extends RuangAIBootcampCertificateTemplate
{
    public function getName(): string
    {
        return 'ruangai_bootcamp_parenting';
    }

    public function getPrefix(): string
    {
        return 'RBP';
    }

    public function getDescription(): string
    {
        return 'Sertifikat Bootcamp RuangAI — Webinar Parenting';
    }

    public function getConfig(): array
    {
        $config                  = parent::getConfig();
        $config['pages'][0]['bg'] = base_url('certificates/tpl/template-ruangai-bootcamp-parenting.png');

        return $config;
    }
}
