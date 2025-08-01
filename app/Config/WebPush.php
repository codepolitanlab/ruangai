<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class WebPush extends BaseConfig
{
    // VAPID
    public $subject    = 'mailto:contact@codepolitan.com';
    public $publicKey  = 'BDSkwRKMHK7WT6hTXe7oj0OJ6q9pqIX61tjZc4jR9b7ldszNsmRb1AbAVVFPxUerbhsOaV9Xa-99IEgUHzr2IcM';
    public $privateKey = 'DA8Ng4cFIn5W-mI5urQG3rghIziI5Yfh1i1gKzvUkyE';
}
