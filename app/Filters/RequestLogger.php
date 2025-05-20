<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RequestLogger implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $data = [
            'time'       => date('Y-m-d H:i:s'),
            'ip_address' => $request->getIPAddress(),
            'method'     => $request->getMethod(),
            'uri'        => current_url(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'headers'    => [],
            'body'       => ''
        ];

        // Ambil headers
        foreach ($request->getHeaders() as $name => $value) {
            $data['headers'][$name] = $value->getValueLine();
        }

        // Ambil body
        $contentType = $request->getHeaderLine('Content-Type');
        if (stripos($contentType, 'application/json') !== false) {
            $data['body'] = $request->getJSON(true); // as array
        } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
            $data['body'] = $request->getPost();
        } elseif (stripos($contentType, 'multipart/form-data') !== false) {
            $data['body'] = array_merge($request->getPost(), $request->getFiles());
        } else {
            $data['body'] = $request->getRawInput();
        }

        // Tulis log ke file
        $logLine = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents(WRITEPATH . 'logs/request-log.log', $logLine . PHP_EOL . str_repeat('-', 80) . PHP_EOL, FILE_APPEND);

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
