<?php
$source   = $source ?? null;
$handlers = $handlers ?? ['' => '— Hanya catat (tanpa proses bisnis) —'];
$isEdit   = ! empty($source);

// Ambil nilai form: old input saat validasi gagal, atau nilai source (mode edit)
$formName    = (string) old('name', $source['name'] ?? '');
$formSlug    = (string) old('slug', $source['slug'] ?? '');
$formHeader  = (string) old('header_name', $source['header_name'] ?? 'X-Callback-Token');
$formHandler = (string) old('handler', $source['handler'] ?? '');
$formStatus  = (string) old('status', $source['status'] ?? 'active');
$formDesc    = (string) old('description', $source['description'] ?? '');
$formSecret  = (string) old('secret', '');

$sourceId  = $source['id'] ?? null;
$actionUrl = $isEdit
    ? admin_url('webhook/sources/' . $sourceId . '/edit')
    : admin_url('webhook/sources/add');
?>
<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $isEdit ? 'Edit Sumber Webhook' : 'Tambah Sumber Webhook' ?></h3>
                <p class="text-subtitle text-muted">Konfigurasi pengirim webhook eksternal</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()) ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('webhook/sources') ?>">Sumber Webhook</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Form Sumber</h5></div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= $actionUrl ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Sumber <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="<?= esc($formName) ?>"
                                       placeholder="mis. Codepolitan Checkout" required>
                                <div class="form-text">Nama tampilan provider pengirim webhook.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" class="form-control" value="<?= esc($formSlug) ?>"
                                       placeholder="mis. codepolitan_cp" required <?= $isEdit ? 'readonly' : '' ?>>
                                <div class="form-text">Bagian URL: <code><?= site_url('webhook/receive/') ?>&lt;slug&gt;</code></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Secret Key / Token <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="secret" id="secret" class="form-control"
                                           value="<?= esc($formSecret) ?>"
                                           placeholder="<?= $isEdit ? 'Kosongkan bila tidak diubah' : 'Minimal 16 karakter' ?>">
                                    <button type="button" class="btn btn-outline-secondary" id="btnGenerateSecret" title="Generate key acak">
                                        <i class="bi bi-shuffle"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <?php if ($isEdit): ?>
                                        Secret lama: <code><?= esc(mb_substr((string) ($source['secret'] ?? ''), 0, 6)) ?>••••</code> — biarkan kosong untuk mempertahankan.
                                    <?php else: ?>
                                        Nilai ini harus sama dengan token yang dikirim provider pada header.
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Header Token</label>
                                <input type="text" name="header_name" class="form-control" value="<?= esc($formHeader) ?>"
                                       placeholder="X-Callback-Token">
                                <div class="form-text">Header yang memuat token, mis. <code>X-Callback-Token</code>.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Handler Pemroses</label>
                                <select name="handler" class="form-select">
                                    <?php foreach ($handlers as $value => $label): ?>
                                        <option value="<?= esc($value) ?>" <?= $formHandler === $value ? 'selected' : '' ?>>
                                            <?= esc($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Kelas yang memproses bisnis webhook. Kosong = hanya catat riwayat.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" <?= $formStatus === 'active' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="inactive" <?= $formStatus === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"><?= esc($formDesc) ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Tambah Sumber' ?>
                        </button>
                        <a href="<?= admin_url('webhook/sources') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('btnGenerateSecret').addEventListener('click', function() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let key = '';
    for (let i = 0; i < 40; i++) {
        key += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('secret').value = key;
});
</script>
<?= $this->endSection() ?>
