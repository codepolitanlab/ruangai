<?php

namespace App\Controllers;

class Sese extends \CodeIgniter\Controller
{
    public function index()
    {
        return view('sese');
    }

    public function counter()
    {
        ini_set('output_buffering', 'off');
        ini_set('zlib.output_compression', 'Off');
        ini_set('implicit_flush', 1);
        ob_implicit_flush(1);
        while (ob_get_level() > 0) { ob_end_flush(); }

        // // Pastikan tidak ada buffer aktif
        // while (ob_get_level() > 0) {
        //     ob_end_clean();
        // }

        // Header SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // Kosongkan response CI supaya tidak override
        $this->response->setBody('');
        $this->response->send();

        // Kirim counter secara bertahap
        for ($i = 1; $i <= 10; $i++) {
            echo "data: " . json_encode(['counter' => $i]) . "\n\n";
            flush(); // hanya flush, tanpa ob_flush()
            sleep(1);
        }

        echo "event: end\ndata: selesai\n\n";
        flush();
        exit;
    }
}
