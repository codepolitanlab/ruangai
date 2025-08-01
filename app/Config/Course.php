<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Course extends BaseConfig
{
    // Walktu untuk menunggu sampai tombol "Saya sudah paham" aktif (dalam milidetik)
    public $waitToEnableButtonUnderstand = 1000 * 60;

    // Zoom credentials
    public $zoomAccountID    = 'BX4NjKOmQGSmrNP5sv5DUQ';
    public $zoomClientID     = 'cKS5Uh1NTnOlZqwAlZHddw';
    public $zoomClientSecret = '6rlnoLL8itrOgn9hAY7zHvTveqg86VBB';
}
