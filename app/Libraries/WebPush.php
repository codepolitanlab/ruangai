<?php

namespace App\Libraries;

use Config\Database;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush as TheWebPush;

class WebPush
{
    protected $db;
    protected $auth;

    public function __construct()
    {
        $this->db = Database::connect();

        $config = config('WebPush');

        $this->auth = [
            'VAPID' => [
                'subject'    => $config->subject,
                'publicKey'  => $config->publicKey,
                'privateKey' => $config->privateKey,
            ],
        ];
    }

    public function saveSubscription(array $data)
    {
        $builder = $this->db->table('push_subscriptions');

        return $builder->insert([
            'endpoint'   => $data['endpoint'],
            'auth'       => $data['keys']['auth'],
            'p256dh'     => $data['keys']['p256dh'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteSubscription(string $endpoint)
    {
        $builder = $this->db->table('push_subscriptions');

        return $builder->where('endpoint', $endpoint)->delete();
    }

    public function sendNotification(array $subscriptionData, array $payload)
    {
        $webPush = new TheWebPush($this->auth);

        $subscription = Subscription::create([
            'endpoint' => $subscriptionData['endpoint'],
            'keys'     => [
                'p256dh' => $subscriptionData['keys']['p256dh'],
                'auth'   => $subscriptionData['keys']['auth'],
            ],
        ]);

        $report = $webPush->sendOneNotification(
            $subscription,
            json_encode($payload)
        );

        return $report->isSuccess();
    }

    public function sendToAll(array $payload)
    {
        $builder = $this->db->table('push_subscriptions');
        $subs    = $builder->get()->getResultArray();

        $success = 0;
        $webPush = new TheWebPush($this->auth);

        foreach ($subs as $row) {
            $subscription = Subscription::create([
                'endpoint' => $row['endpoint'],
                'keys'     => [
                    'p256dh' => $row['p256dh'],
                    'auth'   => $row['auth'],
                ],
            ]);

            $report = $webPush->sendOneNotification(
                $subscription,
                json_encode($payload)
            );

            if ($report->isSuccess()) {
                $success++;
            }
        }

        return $success;
    }
}
