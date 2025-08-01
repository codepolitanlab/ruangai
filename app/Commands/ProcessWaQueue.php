<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;
use Pheanstalk\Pheanstalk;
use Pheanstalk\Values\TubeName;

class ProcessWaQueue extends BaseCommand
{
    protected $group       = 'Queue';
    protected $name        = 'queue:process-wa';
    protected $description = 'Consume WA queue and send message via curl';

    public function run(array $params)
    {
        $pheanstalk = Pheanstalk::create('127.0.0.1');
        $tube       = new TubeName('wasender');

        CLI::write('Listening to tube: ' . $tube);

        while (true) {
            $pheanstalk->watch($tube);
            $job     = $pheanstalk->reserve();
            $payload = json_decode($job->getData(), true);

            $phone   = $payload['phone'] ?? null;
            $message = $payload['message'] ?? null;

            if ($phone && $message) {
                CLI::write("Sending to {$phone}: {$message}");

                $client = \Config\Services::curlrequest();
                $url    = 'http://139.59.99.174:3001/send';
                // $url = 'http://localhost:3001/send';

                try {
                    $response = $client->post($url, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'body' => json_encode([
                            'to'      => $phone,
                            'message' => $message,
                        ]),
                    ]);

                    $result = json_decode($response->getBody(), true);
                    CLI::write('Sent successfully: ' . json_encode($result));
                } catch (Exception $e) {
                    CLI::error('Failed to send: ' . $e->getMessage());
                }
            } else {
                CLI::error('Invalid payload: ' . $job->getData());
            }

            $pheanstalk->delete($job);

            // Delay antar pesan (3–10 detik)
            sleep(mt_rand(3, 10));
        }
    }
}
