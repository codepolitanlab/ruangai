<?php

namespace Webhook\Libraries;

use Throwable;
use Webhook\Models\WebhookLogModel;

/**
 * Menjalankan handler bisnis untuk sebuah log webhook, lalu memperbarui status
 * log (pending -> success/failed) + error_message + processed_at.
 *
 * Dipakai bersama oleh Receiver (webhook masuk) dan tombol "Proses Ulang" admin.
 */
class WebhookProcessor
{
    /**
     * @param array $source  baris webhook_sources
     * @param array $payload payload webhook (sudah di-decode)
     *
     * @return array{status: string, message: ?string}
     */
    public static function process(array $source, array $payload, int $logId): array
    {
        $logModel = new WebhookLogModel();
        $handler  = ltrim((string) ($source['handler'] ?? ''), '\\');

        $status = 'success';
        $error  = null;

        if ($handler !== '' && class_exists($handler)) {
            $instance = new $handler();

            if (method_exists($instance, 'handle')) {
                try {
                    $result  = $instance->handle($payload, $source);
                    $success = (bool) ($result['success'] ?? true);
                    $status  = $success ? 'success' : 'failed';
                    $error   = $success ? null : (string) ($result['message'] ?? 'Handler gagal memproses webhook.');
                } catch (Throwable $e) {
                    $status = 'failed';
                    $error  = $e->getMessage();
                    log_message('error', '[Webhook] ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
                }
            }
        }

        $logModel->update($logId, [
            'status'        => $status,
            'error_message' => $error,
            'processed_at'  => date('Y-m-d H:i:s'),
        ]);

        return ['status' => $status, 'message' => $error];
    }
}
