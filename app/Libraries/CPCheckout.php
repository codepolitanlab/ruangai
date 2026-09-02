<?php

namespace App\Libraries;

class CPCheckout
{
    private $url;
    private $clientCode;
    private $appKey;

    public function __construct()
    {
        $Config = new \Config\CPCheckout();

        $this->url        = $Config->serviceURL;
        $this->clientCode = $Config->clientCode;
        $this->appKey     = $Config->appKey;
    }

    public function getCheckoutUrl($products, $customer = [], $config = [])
    {
        $endpoint = $this->url . '/checkout';

        $data['products'] = [];

        foreach ($products as $product) {
            $data['products'][] = [
                'reference_id' => $product['id'],
                'type'         => $product['type'],
                'title'        => $product['title'],
                'subtitle'     => $product['subtitle'],
                'price'        => $product['price'],
                'normal_price' => $product['normal_price'],
                'quantity'     => $product['quantity'] ?? 1,
                'metadata'     => $product['metadata'] ?? [],
            ];
        }
        $data['customer'] = $customer;
        $data['config']   = $config;

        // Send post request
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data)),
            'Client-Code: ' . $this->clientCode,
            'Appkey: ' . $this->appKey,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        // check error
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        return json_decode($result, true);
    }
}
