<?php

namespace Certificate\Config;

use CodeIgniter\Config\BaseConfig;

class Certificate extends BaseConfig
{
    // Certificate prefix for generating cert_code
    public $certPrefix = 'CPRAI';

    // Path to store generated certificates
    public $certificatePath = WRITEPATH . 'certificates/';

    // Default template name
    public $defaultTemplate = 'default';

    // Available templates
    public $availableTemplates = [
        'default'  => \Certificate\Libraries\DefaultCertificateTemplate::class,
        'comentor' => \Certificate\Libraries\ComentorCertificateTemplate::class,
        'workshop_avpn' => \Certificate\Libraries\WorkshopAVPNCertificateTemplate::class,
        // Add more templates here as needed
    ];
}
