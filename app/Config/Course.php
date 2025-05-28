<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Course extends BaseConfig
{
    // Walktu untuk menunggu sampai tombol "Saya sudah paham" aktif (dalam milidetik)
    public $waitToEnableButtonUnderstand = 1000 * 60;

    public $enableLiveRecording = false;
}
