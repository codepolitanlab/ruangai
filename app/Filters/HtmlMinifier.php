<?php

namespace App\Filters;

use Abordage\HtmlMin\HtmlMin;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class HtmlMinifier implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Tidak perlu diubah
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Aktifkan hanya di environment production
        if (ENVIRONMENT !== 'production') {
            return $response;
        }

        // Pastikan kontennya HTML
        if (strpos($response->getHeaderLine('Content-Type'), 'text/html') !== false) {
            $output = $response->getBody();

            // Minify HTML
            $htmlMin = new HtmlMin();
            $output  = $htmlMin->minify($output);

            // Minify inline JS di dalam <script> tag
            $output = preg_replace_callback(
                '#<script\b[^>]*>(.*?)</script>#is',
                static function ($matches) {
                    $js = $matches[1];

                    // Skip script kosong
                    if (trim($js) === '') {
                        return $matches[0];
                    }

                    // Minify JS
                    $jsMinifier = new \MatthiasMullie\Minify\JS($js);
                    $minifiedJs = $jsMinifier->minify();

                    return "<script>{$minifiedJs}</script>";
                },
                $output
            );

            $response->setBody($output);
        }

        return $response;
    }
}
