<?php

namespace Config;

use CodeIgniter\HTTP\URI;

class InvalidChars extends \CodeIgniter\Config\BaseConfig
{
    /**
     * Characters that are allowed in URIs.
     *
     * @var string
     */
    public $uri = 'a-zA-Z0-9\-\._~:\/\?#\[\]@!\$&\'\(\)\*\+,;=%';
}