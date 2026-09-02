<?php

namespace Webhook\Controllers;

use Heroicadmin\Controllers\AdminController;
use Webhook\Models\WebhookSourceModel;

/**
 * Admin: mengelola sumber/provider webhook + secret key.
 * Halaman: {urlScope}/webhook/sources (index/add/edit/delete)
 */
class Source extends AdminController
{
    protected $model;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Sumber Webhook';
        $this->data['module']     = 'webhook';
        $this->data['submodule']  = 'sources';

        $this->model = new WebhookSourceModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {
            return $this->datatables();
        }

        return view('Webhook\Views\source\index', $this->data);
    }

    private function datatables()
    {
        $draw   = (int) $this->request->getPost('draw');
        $start  = (int) ($this->request->getPost('start') ?? 0);
        $length = (int) ($this->request->getPost('length') ?? 10);
        $search = $this->request->getPost('search')['value'] ?? '';

        $builder = $this->model;
        if ($search !== '') {
            $builder->groupStart()
                ->like('name', $search)
                ->orLike('slug', $search)
                ->orLike('handler', $search)
                ->groupEnd();
        }

        $totalRecords    = $this->model->countAllResults(false);
        $recordsFiltered = $builder->countAllResults(false);

        $rows = $builder->orderBy('id', 'ASC')
            ->limit($length, $start)
            ->get()
            ->getResultArray();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'id'          => $row['id'],
                'name'        => $row['name'],
                'slug'        => $row['slug'],
                'secret'      => $this->maskSecret($row['secret']),
                'header_name' => $row['header_name'],
                'handler'     => $row['handler'] ?: '—',
                'status'      => $row['status'],
                'actions'     => '<a href="' . admin_url('webhook/sources/' . $row['id'] . '/edit') . '" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a> '
                    . '<a href="' . admin_url('webhook/sources/' . $row['id'] . '/delete') . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin hapus sumber ini?\')"><i class="bi bi-trash"></i> Hapus</a>',
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function add()
    {
        $this->data['source']  = null;
        $this->data['handlers'] = $this->availableHandlers();

        if ($this->request->getMethod(true) === 'POST') {
            $post  = $this->request->getPost();
            $error = $this->validateForm($post, null);
            if ($error) {
                return redirect()->back()->withInput()->with('error', $error);
            }

            $this->model->insert($this->buildData($post, true));

            return redirect()->to(admin_url('webhook/sources'))->with('success', 'Sumber webhook berhasil ditambahkan.');
        }

        return view('Webhook\Views\source\form', $this->data);
    }

    public function edit($id)
    {
        $source = $this->model->find($id);
        if (! $source) {
            return redirect()->to(admin_url('webhook/sources'))->with('error', 'Sumber webhook tidak ditemukan.');
        }

        $this->data['source']  = $source;
        $this->data['handlers'] = $this->availableHandlers();

        if ($this->request->getMethod(true) === 'POST') {
            $post  = $this->request->getPost();
            $error = $this->validateForm($post, $source);
            if ($error) {
                return redirect()->back()->withInput()->with('error', $error);
            }

            $this->model->update($id, $this->buildData($post, false, $source));

            return redirect()->to(admin_url('webhook/sources'))->with('success', 'Sumber webhook berhasil diperbarui.');
        }

        return view('Webhook\Views\source\form', $this->data);
    }

    public function delete($id)
    {
        // Cegah penghapusan bila masih ada riwayat log? Cukup hapus referensi log menjadi null.
        if ($this->model->delete($id)) {
            $db = \Config\Database::connect();
            $db->table('webhook_logs')->where('source_id', $id)->update(['source_id' => null]);

            return redirect()->to(admin_url('webhook/sources'))->with('success', 'Sumber webhook dihapus.');
        }

        return redirect()->to(admin_url('webhook/sources'))->with('error', 'Gagal menghapus sumber webhook.');
    }

    private function validateForm(array $post, ?array $source): ?string
    {
        $id    = $source ? (int) $source['id'] : null;
        $rules = [
            'name'        => 'required|min_length[3]|max_length[100]',
            'slug'        => 'required|alpha_dash|min_length[2]|max_length[60]',
            'secret'      => $id ? 'permit_empty|min_length[16]' : 'required|min_length[16]',
            'header_name' => 'permit_empty|max_length[100]',
            'status'      => 'required|in_list[active,inactive]',
        ];

        $validation = service('validation');
        $validation->setRules($rules);
        if (! $validation->run($post)) {
            return implode(' ', array_values($validation->getErrors()));
        }

        // Slug unik (abaikan diri sendiri saat edit)
        $db = \Config\Database::connect();
        $dup = $db->table('webhook_sources')
            ->where('slug', $post['slug']);
        if ($id) {
            $dup->where('id !=', $id);
        }
        if ($dup->countAllResults() > 0) {
            return 'Slug sudah dipakai sumber webhook lain.';
        }

        return null;
    }

    private function buildData(array $post, bool $isNew, ?array $existing = null): array
    {
        $data = [
            'name'        => (string) ($post['name'] ?? ''),
            'slug'        => strtolower((string) ($post['slug'] ?? '')),
            'header_name' => (string) ($post['header_name'] ?? 'X-Callback-Token'),
            'handler'     => (string) ($post['handler'] ?? ''),
            'status'      => (string) ($post['status'] ?? 'active'),
            'description' => (string) ($post['description'] ?? ''),
        ];

        // Secret: wajib saat tambah; saat edit boleh kosong = pertahankan yang lama
        if ($isNew) {
            $data['secret'] = (string) ($post['secret'] ?? '');
        } elseif (! empty($post['secret'])) {
            $data['secret'] = (string) $post['secret'];
        } elseif ($existing) {
            $data['secret'] = (string) $existing['secret'];
        }

        if ($data['header_name'] === '') {
            $data['header_name'] = 'X-Callback-Token';
        }

        return $data;
    }

    private function availableHandlers(): array
    {
        $handlers = ['' => '— Hanya catat (tanpa proses bisnis) —'];

        $files = glob(__DIR__ . '/../Handlers/*Handler.php') ?: [];
        sort($files);

        foreach ($files as $file) {
            $className        = 'Webhook\\Handlers\\' . basename($file, '.php');
            $short            = basename($file, '.php');
            $handlers[$className] = $short;
        }

        return $handlers;
    }

    private function maskSecret(string $secret): string
    {
        if ($secret === '') {
            return '';
        }
        $len = strlen($secret);

        return substr($secret, 0, 6) . str_repeat('•', min($len - 6, 12));
    }
}
