<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WebhookController extends BaseController
{
    public function index()
    {
        $payload = $this->request->getPost();

        $data = [
            'user_id' => $payload['user_id'],
            'live_meeting_id' => $payload['live_meeting_id'],
            'content' => json_encode($payload),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $db = \Config\Database::connect();
        $db->table('live_meeting_feedback')->insert($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Feedback received',
            'data' => $payload
        ]);
    }
}
