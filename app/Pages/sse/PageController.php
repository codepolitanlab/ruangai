<?php

namespace App\Pages\sse;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Sse Page',
    ];

    public function getData()
    {
        $this->data['name'] = 'Federico Vandervort Jr.';

        return $this->respond($this->data);
    }

    public function getCounter()
    {
        // Header untuk SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        $count = 0;

        // Kirim data tiap 1 detik (10x)
        for ($i = 0; $i < 10; $i++) {
            $count++;

            echo 'data: ' . json_encode(['counter' => $count]) . "\n\n";

            ob_flush();
            flush();

            sleep(1); // delay 1 detik
        }

        // Tutup koneksi
        echo "event: end\ndata: selesai\n\n";
        ob_flush();
        flush();
    }
}
