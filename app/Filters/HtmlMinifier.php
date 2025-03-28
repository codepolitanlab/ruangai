<?php

namespace App\Filters;

use Abordage\HtmlMin\HtmlMin;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class HtmlMinifier implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Tidak perlu diubah, kita hanya ingin memanipulasi response setelah view dirender
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $output = $response->getBody();

        if (strpos($response->getHeaderLine('Content-Type'), 'text/html') !== false) {
            // Minify HTML
            $htmlMin = new HtmlMin();
            $output = $htmlMin->minify($output);

            // Cari tag <script> dan minify isinya
            $output = preg_replace_callback('#<script\b[^>]*>(.*?)</script>#is', function ($matches) {
                $js = $matches[1];

                // Hindari jika JS kosong atau isinya hanya komentar
                if (trim($js) === '') {
                    return $matches[0];
                }

                // Minify JS
                $jsMinifier = new \MatthiasMullie\Minify\JS($js);
                $minifiedJs = $jsMinifier->minify();

                return "<script>{$minifiedJs}</script>";
            }, $output);

            $response->setBody($output);
        }

        return $response;
    }
}
