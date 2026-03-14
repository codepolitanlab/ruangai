<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?= esc($title) ?></h5>
                    <a href="<?= admin_url() ?>certificates" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php $summary = session()->getFlashdata('generate_summary'); ?>
                    <?php if ($summary): ?>
                        <div class="alert alert-<?= $summary['failed'] === 0 ? 'success' : ($summary['success'] === 0 ? 'danger' : 'warning') ?> alert-dismissible fade show" role="alert">
                            <strong>Hasil Generate:</strong>
                            <?= $summary['success'] ?> berhasil,
                            <?= $summary['failed'] ?> gagal/dilewati
                            dari total <?= $summary['total'] ?> email.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php $results = session()->getFlashdata('generate_results'); ?>
                    <?php if ($results): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Detail Hasil Generate</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $i => $result): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= esc($result['email']) ?></td>
                                                <td>
                                                    <?php if ($result['status'] === 'success'): ?>
                                                        <span class="badge bg-success">Berhasil</span>
                                                    <?php elseif ($result['status'] === 'skipped'): ?>
                                                        <span class="badge bg-warning text-dark">Dilewati</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Gagal</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($result['message']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form action="<?= admin_url() ?>certificates/generate" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Entity <span class="text-danger">*</span></label>
                                    <select name="entity_type" class="form-select" required>
                                        <option value="">Pilih Tipe</option>
                                        <?php foreach ($entity_types as $key => $label): ?>
                                            <option value="<?= $key ?>" <?= old('entity_type') == $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Entity ID <span class="text-danger">*</span></label>
                                    <input type="number" name="entity_id" class="form-control" value="<?= old('entity_id') ?>" required min="1">
                                    <small class="text-muted">ID course / event / challenge</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Template <span class="text-danger">*</span></label>
                            <select name="template_name" class="form-select" required>
                                <option value="">Pilih Template</option>
                                <?php foreach ($templates as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= old('template_name') == $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
                            <small class="text-muted">Judul yang akan tampil di sertifikat</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Daftar Email Peserta <span class="text-danger">*</span></label>
                            <textarea name="emails" class="form-control font-monospace" rows="10"
                                placeholder="Masukkan satu email per baris:&#10;user1@example.com&#10;user2@example.com&#10;user3@example.com"
                                required><?= old('emails') ?></textarea>
                            <small class="text-muted">Satu email per baris. Email digunakan untuk menemukan <code>user_id</code> dari database. Sertifikat duplikat (user + entity yang sama) akan dilewati.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= admin_url() ?>certificates" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cogs me-1"></i> Generate Sertifikat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
