<?php

namespace Webhook\Controllers;

use Heroicadmin\Controllers\AdminController;
use Webhook\Libraries\WebhookProcessor;
use Webhook\Models\WebhookLogModel;
use Webhook\Models\WebhookSourceModel;

/**
 * Admin: mereview riwayat setiap webhook yang masuk.
 * Halaman: {urlScope}/webhook (index/detail/reprocess/mark-reviewed/delete)
 */
class Webhook extends AdminController
{
    protected $logModel;
    protected $sourceModel;

    public function __construct()
    {
        $this->data['page_title'] = 'Riwayat Webhook';
        $this->data['module']     = 'webhook';
        $this->data['submodule']  = 'logs';

        $this->logModel    = new WebhookLogModel();
        $this->sourceModel = new WebhookSourceModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {
            return $this->datatables();
        }

        return view('Webhook\Views\webhook\index', $this->data);
    }

    private function datatables()
    {
        $draw     = (int) $this->request->getPost('draw');
        $start    = (int) ($this->request->getPost('start') ?? 0);
        $length   = (int) ($this->request->getPost('length') ?? 10);
        $search   = $this->request->getPost('search')['value'] ?? '';
        $status   = (string) $this->request->getPost('status');
        $reviewed = (string) $this->request->getPost('reviewed');

        $builder = $this->logModel
            ->select('webhook_logs.*, webhook_sources.name as source_name')
            ->join('webhook_sources', 'webhook_sources.id = webhook_logs.source_id', 'left');

        if (in_array($status, ['pending', 'success', 'failed'], true)) {
            $builder->where('webhook_logs.status', $status);
        }
        if (in_array($reviewed, ['0', '1'], true)) {
            $builder->where('webhook_logs.is_reviewed', (int) $reviewed);
        }
        if ($search !== '') {
            $builder->groupStart()
                ->like('webhook_logs.source_slug', $search)
                ->orLike('webhook_logs.event', $search)
                ->orLike('webhook_logs.ip_address', $search)
                ->orLike('webhook_sources.name', $search)
                ->groupEnd();
        }

        $totalRecords    = $this->logModel->countAllResults(false);
        $recordsFiltered = $builder->countAllResults(false);

        $rows = $builder->orderBy('webhook_logs.id', 'DESC')
            ->limit($length, $start)
            ->get()
            ->getResultArray();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'id'          => $row['id'],
                'source_name' => $row['source_name'] ?: ($row['source_slug'] ?: '-'),
                'event'       => $row['event'] ?: '-',
                'status'      => $row['status'],
                'method'      => strtoupper((string) $row['method']),
                'ip_address'  => $row['ip_address'] ?: '-',
                'is_reviewed' => (int) $row['is_reviewed'],
                'created_at'  => $row['created_at'] ? date('d M Y H:i:s', strtotime($row['created_at'])) : '-',
                'actions'     => '<a href="' . admin_url('webhook/detail/' . $row['id']) . '" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a>',
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function detail($id)
    {
        $log = $this->logModel->find($id);
        if (! $log) {
            return redirect()->to(admin_url('webhook'))->with('error', 'Data webhook tidak ditemukan.');
        }

        $log['headers'] = $this->decodeJson($log['headers']);
        $log['payload'] = $this->decodeJson($log['payload']);

        $this->data['log']    = $log;
        $this->data['source'] = $this->sourceModel->find($log['source_id']);

        return view('Webhook\Views\webhook\detail', $this->data);
    }

    public function markReviewed($id)
    {
        $log = $this->logModel->find($id);
        if (! $log) {
            return redirect()->to(admin_url('webhook'))->with('error', 'Data webhook tidak ditemukan.');
        }

        $this->logModel->update($id, [
            'is_reviewed' => 1,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'reviewed_by' => user_id(),
        ]);

        return redirect()->to(admin_url('webhook/detail/' . $id))->with('success', 'Webhook ditandai sudah direview.');
    }

    public function reprocess($id)
    {
        $log = $this->logModel->find($id);
        if (! $log) {
            return redirect()->to(admin_url('webhook'))->with('error', 'Data webhook tidak ditemukan.');
        }

        if ($log['status'] === 'success') {
            return redirect()->to(admin_url('webhook/detail/' . $id))->with('error', 'Webhook sudah berhasil diproses.');
        }

        $source = $this->sourceModel->find($log['source_id']);
        if (! $source || $source['status'] !== 'active') {
            return redirect()->to(admin_url('webhook/detail/' . $id))->with('error', 'Sumber webhook tidak aktif / tidak ditemukan.');
        }

        $payload = $this->decodeJson($log['payload']);
        if (! $payload) {
            return redirect()->to(admin_url('webhook/detail/' . $id))->with('error', 'Payload webhook kosong / tidak valid.');
        }

        $this->logModel->update($id, [
            'status'        => 'pending',
            'error_message' => null,
            'processed_at'  => null,
        ]);

        $out = WebhookProcessor::process($source, $payload, (int) $id);

        $message = $out['status'] === 'success'
            ? 'Webhook berhasil diproses ulang.'
            : 'Webhook gagal diproses ulang: ' . $out['message'];

        return redirect()->to(admin_url('webhook/detail/' . $id))
            ->with($out['status'] === 'success' ? 'success' : 'error', $message);
    }

    public function delete($id)
    {
        if ($this->logModel->delete($id)) {
            return redirect()->to(admin_url('webhook'))->with('success', 'Riwayat webhook dihapus.');
        }

        return redirect()->to(admin_url('webhook'))->with('error', 'Gagal menghapus riwayat webhook.');
    }

    private function decodeJson($value): array
    {
        if (is_array($value)) {
            return $value;
        }
        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? $decoded : [];
    }
}
