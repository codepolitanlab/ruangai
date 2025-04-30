<?php

namespace App\Controllers\Api;

use App\Pages\BaseController;
use App\Libraries\PushNotification;

class WebpushController extends BaseController
{
    protected $pushLib;

    public function __construct()
    {
        $this->pushLib = new PushNotification();
    }

    public function generateVAPID()
    {
        echo json_encode(\Minishlink\WebPush\VAPID::createVapidKeys());
    }

    public function register()
    {
        $postdata = json_decode($this->request->getPost('subscription'), true);
        $this->pushLib->saveSubscription($postdata);

        $payload = [
            'title' => 'Halo Boss Toni!',
            'body' => 'Ini push notifikasi dari CI4.',
            'icon' => '/icon.png',
            'url' => '/'
        ];

        $success = $this->pushLib->sendNotification($postdata, $payload);

        return $this->response->setJSON([
            'status' => $success ? 'success' : 'error'
        ]);
    }

    public function unregister()
    {
        $endpoint = $this->request->getPost('endpoint');
        if (!$endpoint) {
            return $this->response->setJSON(['status' => 'error', 'reason' => 'No endpoint provided']);
        }

        $this->pushLib->deleteSubscription($endpoint);
        return $this->response->setJSON(['status' => 'unsubscribed']);
    }

    public function send()
    {
        $payload = [
            'title' => 'Halo Boss Oriza!',
            'body' => 'Ini contoh broadcast ke user yang terdaftar',
            'icon' => '/icon.png',
            'url' => '/'
        ];
        $success = $this->pushLib->sendToAll($payload);

        return $this->response->setJSON([
            'status' => $success ? 'success' : 'error'
        ]);
    }
}
