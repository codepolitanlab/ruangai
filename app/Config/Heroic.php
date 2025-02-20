<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Heroic extends BaseConfig
{
    public array $siteSettings = [
        "site_title"            => "RuangAI",
        "site_desc"             => "Pesantren Modern Jenjang Tsanawiyah dan Aliyah dengan Fullday and Boarding School System yang berlokasi di kota Tasikmalaya - Jawa Barat.",
        "site_logo"             => "https://ppitarbiyya.test//uploads/ppitarbiyya/sources/logo-ppi-tarbiyya.png",
        "site_logo_monochrome"  => "https://ppitarbiyya.test//uploads/ppitarbiyya/sources/logo-ppi-tarbiyya.png",
        "site_logo_small"       => "https://www.persis67benda.com//uploads/benda/sources/logo/ms-icon-144x144.png",

        "app_title"             => "RuangAI",
        "address"               => "Jl. Cisalak No.15, Nagarasari, Kec. Cipedes, Kab. Tasikmalaya, Jawa Barat 46132",
        "phone"                 => "",
        "email"                 => "",
        "latlong"               => "",
        "auth_logo"             => "https://ppitarbiyya.test//uploads/ppitarbiyya/sources/logo-ppi-tarbiyya.png",
        "navbar_logo"           => "https://ppitarbiyya.test//uploads/ppitarbiyya/sources/ppitarbiyya-white.png",
        "login_cover"           => "",
        "currency"              => "Rp",
        "maintenance_mode"      => false,
        "sandbox_login"         => ['username' => '', 'password' => ''],
    ];

    public array $siteFeatures = [
        "agenda"            => false,
        "doa_zikir"         => false,
        "hadits_arbain"     => false,
        "jadwal_sholat"     => false,
        "kabar"             => false,
        "kajian"            => false,
        "pengumuman"        => false,
        "profil_pesantren"  => false,
        "profile"           => false,
        "program_pesantren" => false,
        "psb"               => false,
        "rapor"             => false,
        "santri"            => false,
        "tagihan"           => false,
        "video"             => false,
    ];

    // JWT Keys
    public array $jwtKey = [
        'kid' => '',      // Key ID. Optional if you have only one key.
        'alg' => 'HS256', // algorithm.
        // Set secret random string. Needs at least 256 bits for HS256 algorithm.
        // E.g., $ php -r 'echo base64_encode(random_bytes(32));'
        'secret' => 'A8xl9FX2/M77KUnLlrt7mWt4gLFM+6ZbPzG6takiSTU=',
    ];

    // SaungWA
    public $saungWA = [
        'appKey' => '1e946b6b-e8ab-4c6a-ac7b-b2ae4204f095',
        'authKey' => 'Bl25APBU3Tcahyo9Rd0ZcCbloR4Gj1i6Ll5lRq6Y3J4DikKUS4'
    ];

    // ReCAPTCHA
    public $recaptcha = [
        'siteKey' => '6LcDLbAqAAAAAMgwHkDRBfDU6NMPC2Kmt6dKw1g5',
        'secretKey' => '6LcDLbAqAAAAAJQpyWXfTvXJXJctF3F6wBijnAjX'
    ];

    // Xendit Keys
    public $xenditSecretKey = 'xnd_development_VhoXvOVbaFJVWsYO8LiBq153MGLHjjqIEM7AlPnggwS3AEVUTCL3bMXyS7MoSfz';
    public $xenditPublicKey = 'xnd_public_development_StXS_AOkori6nxKP52JTUV5nnx_BVTA1rnteoDhtFIFUPmPVNYEogUyYEAq4xy';
    public $xenditCallbackToken = 'WaJBJ4O3XUtB2izC5FmyAN2mfgouAWEEmgnoo9XQEgKpQffR';

    public $activePaymentMethods = [
        'DANA',
        'OVO',
        'QRIS',
        'Shopeepay',
        'Linkaja',
        'Jeniuspay',
        'Astrapay',
        'BNI',
        'BSI',
        'BRI',
        'Mandiri',
        'Permata',
        'CIMB',
        'BJB',
        'Sampoerna',
    ];
}