<?php
// Helper format JSON agar mudah dibaca
$pretty = static function ($value) {
    return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
};

$statusBadge = [
    'pending' => '<span class="badge bg-warning">Pending</span>',
    'success' => '<span class="badge bg-success">Sukses</span>',
    'failed'  => '<span class="badge bg-danger">Gagal</span>',
];
// $log & $source diekstrak dari data view (lihat Webhook::detail)
$log    = $log ?? [];
$source = $source ?? null;
?>
<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Webhook #<?= esc($log['id']) ?></h3>
                <p class="text-subtitle text-muted">Review payload & hasil pemrosesan webhook</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()) ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('webhook') ?>">Riwayat Webhook</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#<?= esc($log['id']) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (! empty($log['error_message'])): ?>
                    <div class="alert alert-danger">
                        <strong>Pesan Error:</strong><br><?= esc($log['error_message']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <!-- Info umum -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Info Umum</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered mb-0">
                            <tr>
                                <th style="width:40%">ID Log</th>
                                <td><?= esc($log['id']) ?></td>
                            </tr>
                            <tr>
                                <th>Sumber</th>
                                <td>
                                    <?php if ($source): ?>
                                        <span class="badge bg-primary"><?= esc($source['name']) ?></span>
                                    <?php else: ?>
                                        <?= esc($log['source_slug'] ?? '-') ?>
                                        <span class="text-muted">(sumber sudah dihapus)</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Event</th>
                                <td><?= esc($log['event'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= $statusBadge[$log['status']] ?? esc($log['status']) ?></td>
                            </tr>
                            <tr>
                                <th>Metode</th>
                                <td><?= esc(strtoupper((string) $log['method'])) ?></td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td><?= esc($log['ip_address'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Response HTTP</th>
                                <td><?= esc($log['response_status'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Diterima</th>
                                <td><?= esc($log['created_at'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Diproses</th>
                                <td><?= esc($log['processed_at'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Review</th>
                                <td>
                                    <?php if (! empty($log['is_reviewed'])): ?>
                                        <span class="badge bg-success">Sudah direview</span>
                                        <small class="d-block text-muted"><?= esc($log['reviewed_at'] ?? '') ?></small>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Belum direview</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Handler Sumber</th>
                                <td><code><?= esc($source['handler'] ?? '-') ?></code></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Aksi -->
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi</h5></div>
                    <div class="card-body d-flex flex-wrap gap-2">
                        <a href="<?= admin_url('webhook') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        <?php if (empty($log['is_reviewed'])): ?>
                            <form method="post" action="<?= admin_url('webhook/mark-reviewed/' . $log['id']) ?>" class="d-inline">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check2-circle"></i> Tandai Sudah Direview
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if ($log['status'] !== 'success'): ?>
                            <form method="post" action="<?= admin_url('webhook/reprocess/' . $log['id']) ?>" class="d-inline"
                                  onsubmit="return confirm('Proses ulang webhook ini?')">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-arrow-repeat"></i> Proses Ulang
                                </button>
                            </form>
                        <?php endif; ?>

                        <form method="post" action="<?= admin_url('webhook/delete/' . $log['id']) ?>" class="d-inline"
                              onsubmit="return confirm('Yakin hapus riwayat webhook ini?')">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payload & Headers -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-code"></i> Payload</h5>
                    </div>
                    <div class="card-body p-0">
                        <pre class="m-0 p-3 bg-dark text-light" style="max-height:420px; overflow:auto; border-radius:0 0 .375rem .375rem"><code><?= esc($pretty($log['payload'])) ?></code></pre>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-arrow-left-right"></i> Headers (token disembunyikan)</h5>
                    </div>
                    <div class="card-body p-0">
                        <pre class="m-0 p-3 bg-dark text-light" style="max-height:300px; overflow:auto; border-radius:0 0 .375rem .375rem"><code><?= esc($pretty($log['headers'])) ?></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
