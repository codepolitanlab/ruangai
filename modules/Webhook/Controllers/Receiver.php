<?php

namespace Webhook\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Webhook\Libraries\WebhookProcessor;
use Webhook\Models\WebhookLogModel;
use Webhook\Models\WebhookSourceModel;

/**
 * Penerima webhook PUBLIK (dipanggil sistem eksternal, tanpa session admin).
 *
 * Endpoint: POST /webhook/receive/{slug-sumber}
 * Alur: cek sumber aktif -> validasi token header -> catat riwayat ->
 *       jalankan handler bisnis (bila sumber punya handler) -> update status -> respon JSON.
 */
class Receiver extends Controller
{
    use ResponseTrait;

    public function receive($sourceSlug = null)
    {
        $request     = $this->request;
        $sourceModel = new WebhookSourceModel();
        $logModel    = new WebhookLogModel();

        // 1) Sumber harus terdaftar & aktif
        $source = $sourceModel->findActiveBySlug((string) $sourceSlug);
        if (! $source) {
            return $this->respond(['status' => 'error', 'message' => 'Sumber webhook tidak dikenal / tidak aktif.'], 404);
        }

        // 2) Ambil payload: raw body JSON, fallback ke form-encoded
        $payloadRaw = (string) $request->getBody();
        $payload    = json_decode($payloadRaw, true);
        if (! is_array($payload)) {
            $payload    = $request->getPost() ?: [];
            $payloadRaw = json_encode($payload);
        }

        $headerName = trim((string) ($source['header_name'] ?? ''));
        $provided   = $this->resolveToken($request, $headerName);
        $valid      = hash_equals((string) $source['secret'], $provided);

        // 3) Siapkan data log (headers tanpa token agar secret tidak bocor)
        $logData = [
            'source_id'   => $source['id'],
            'source_slug' => $source['slug'],
            'event'       => $this->detectEvent($payload),
            'method'      => (string) $request->getMethod(),
            'headers'     => $this->encodeJson($this->sanitizeHeaders($request, $headerName)),
            'payload'     => $this->encodeJson($payload),
            'ip_address'  => (string) $request->getIPAddress(),
            'status'      => 'pending',
        ];

        // 4) Token tidak valid -> catat sebagai gagal + 401
        if (! $valid) {
            $logData['status']          = 'failed';
            $logData['error_message']   = 'Unauthorized: token pada header tidak cocok.';
            $logData['processed_at']    = date('Y-m-d H:i:s');
            $logData['response_status'] = 401;

            $logModel->insert($logData);

            return $this->respond(['status' => 'error', 'message' => 'Unauthorized.'], 401);
        }

        // 5) Catat log lalu proses (jalankan handler bila ada)
        $logId = (int) $logModel->insert($logData);
        $out   = WebhookProcessor::process($source, $payload, $logId);

        $logModel->update($logId, ['response_status' => 200]);

        return $this->respond([
            'status'  => $out['status'] === 'success' ? 'success' : 'error',
            'log_id'  => $logId,
            'message' => $out['message'],
        ], 200);
    }

    private function resolveToken($request, string $headerName): string
    {
        if ($headerName !== '') {
            $line = $request->getHeaderLine($headerName);
            if ($line !== '') {
                return $line;
            }
        }

        // Cadangan: coba header yang umum dipakai provider
        foreach (['X-Callback-Token', 'X-Webhook-Token', 'X-Webhook-Secret', 'Authorization'] as $header) {
            $line = $request->getHeaderLine($header);
            if ($line !== '') {
                if ($header === 'Authorization' && stripos($line, 'Bearer ') === 0) {
                    return trim(substr($line, 7));
                }

                return $line;
            }
        }

        return '';
    }

    private function sanitizeHeaders($request, string $tokenHeader): array
    {
        $headers = [];

        foreach ($request->getHeaders() as $name => $header) {
            $lower = strtolower($name);

            if (in_array($lower, ['host', 'cookie', 'authorization'], true)
                || ($tokenHeader !== '' && $lower === strtolower($tokenHeader))) {
                continue;
            }

            $headers[$name] = $header->getValueLine();
        }

        return $headers;
    }

    private function detectEvent(array $payload): ?string
    {
        foreach (['event', 'type', 'event_type', 'action'] as $key) {
            if (! empty($payload[$key]) && is_scalar($payload[$key])) {
                return (string) $payload[$key];
            }
        }

        if (isset($payload['checkout']['status'])) {
            return 'checkout.' . strtolower((string) $payload['checkout']['status']);
        }
        if (isset($payload['status'])) {
            return strtolower((string) $payload['status']);
        }

        return null;
    }

    private function encodeJson($value): string
    {
        $json = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);

        return $json === false ? '{}' : $json;
    }
}
