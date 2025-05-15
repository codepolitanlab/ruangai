<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\CURLRequest;

class WASenderController extends ResourceController
{
    use ResponseTrait;
    public $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return $this->respond(['status' => 'success']);
    }

    public function incoming()
    {
        $data = $this->request->getPost();

        if (!preg_match('/\botp\b/i', $data['body'])) {
            return false;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('otp_whatsapps');

        $phone = str_replace('@c.us', '', $data['from']);
        $now = date('Y-m-d H:i:s');
        $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));

        // Cek apakah ada OTP aktif dalam 5 menit terakhir
        $query = $builder
            ->select('*')
            ->where('whatsapp_number', $phone)
            ->where('created_at >=', $fiveMinutesAgo)
            ->orderBy('created_at', 'DESC')
            ->get(1);

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $otpCode = $row->otp_code;

            if ($row->reminded == 0) {
                // Kirim reminder hanya sekali
                $message = "Kode OTP Anda sebelumnya masih aktif: *{$otpCode}*. Silakan gunakan kode ini di aplikasi.";

                // Update sudah diingatkan
                $builder
                    ->where('id', $row->id)
                    ->update(['reminded' => 1]);

                $this->sendMessage($phone, $message);
            }

            // Tidak mengirim apa-apa jika sudah diingatkan
            return $this->respond([
                'status' => 'waiting',
                'note' => 'OTP masih aktif dan sudah pernah diingatkan.'
            ]);
        }

        // Generate OTP baru
        $otpCode = random_int(100000, 999999);

        $builder->insert([
            'whatsapp_number' => $phone,
            'otp_code' => $otpCode,
            'created_at' => $now,
            'expired_at' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'reminded' => 0
        ]);

        $messages = [
            "Kode OTP Anda: *{OTP}*. Silakan masukkan kode ini di aplikasi untuk melanjutkan.",
            "Gunakan OTP berikut: *{OTP}*. Pastikan Anda mengetikkannya di aplikasi sekarang juga.",
            "*{OTP}* adalah kode verifikasi Anda. Masukkan kode ini di aplikasi agar proses bisa dilanjutkan.",
            "Masukkan kode *{OTP}* di aplikasi untuk menyelesaikan proses verifikasi Anda.",
            "Berikut OTP Anda: *{OTP}*. Segera input di aplikasi sebelum masa berlaku habis.",
            "Kode verifikasi: *{OTP}*. Gunakan kode ini di aplikasi untuk login atau aktivasi.",
            "*{OTP}* adalah kode keamanan Anda. Harap segera masukkan di aplikasi sebelum kedaluwarsa.",
            "Silakan ketik OTP berikut di aplikasi: *{OTP}*. Jangan bagikan kepada siapa pun.",
            "Untuk melanjutkan, input kode berikut di aplikasi Anda: *{OTP}*.",
            "Kode OTP Anda: *{OTP}*. Silakan input di aplikasi untuk menyelesaikan proses dengan aman.",
        ];

        $message = str_replace('{OTP}', $otpCode, $messages[array_rand($messages)]);
        $this->sendMessage($phone, $message);

        return $this->respond(['status' => 'success', 'otp' => $otpCode, 'phone' => $phone]);
    }
    

    private function sendMessage($phone, $message)
    {
        $client = \Config\Services::curlrequest();

        $url = 'http://139.59.99.174:3001/send';

        $body = [
            'to'      => $phone,
            'message' => $message
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($body)
            ]);

            // Tampilkan hasil respons
            return $this->response->setJSON([
                'status' => true,
                'response' => json_decode($response->getBody(), true)
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

}
