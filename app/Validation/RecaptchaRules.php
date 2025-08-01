<?php

namespace App\Validation;

use Exception;

class RecaptchaRules
{
    /**
     * Verifies the Google reCAPTCHA v2 response.
     *
     * @param string|null $str The g-recaptcha-response POST data.
     */
    public function recaptcha_verify(?string $str): bool
    {
        $secretKey = setting('recaptcha.secretKey');
        if (empty($str) || empty($secretKey)) {
            return false;
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret'   => $secretKey,
                    'response' => $str,
                    'remoteip' => service('request')->getIPAddress(),
                ],
            ]);

            $body = json_decode($response->getBody());

            return $body->success ?? false;
        } catch (Exception $e) {
            log_message('error', '[reCAPTCHA] ' . $e->getMessage());

            return false;
        }
    }
}
