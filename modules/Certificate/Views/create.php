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

                    <form action="<?= admin_url() ?>certificates/store" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">User ID <span class="text-danger">*</span></label>
                                    <input type="number" name="user_id" class="form-control" value="<?= old('user_id') ?>" required>
                                    <small class="text-muted">ID user dari database</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Peserta <span class="text-danger">*</span></label>
                                    <input type="text" name="participant_name" class="form-control" value="<?= old('participant_name') ?>" required>
                                    <small class="text-muted">Nama yang akan tampil di sertifikat</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Entity <span class="text-danger">*</span></label>
                                    <select name="entity_type" class="form-select" required>
                                        <option value="">Pilih Tipe</option>
                                        <?php foreach ($entity_types as $key => $label): ?>
                                            <option value="<?= $key ?>" <?= old('entity_type') == $key ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Entity ID <span class="text-danger">*</span></label>
                                    <input type="number" name="entity_id" class="form-control" value="<?= old('entity_id') ?>" required>
                                    <small class="text-muted">ID course/workshop/training/dll</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
                            <small class="text-muted">Judul course/workshop yang tampil di sertifikat</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Template <span class="text-danger">*</span></label>
                            <select name="template_name" class="form-select" required>
                                <option value="">Pilih Template</option>
                                <?php foreach ($templates as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= old('template_name') == $key ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Data (JSON)</label>
                            <textarea name="additional_data" class="form-control" rows="8" placeholder='{"instructor": "John Doe", "score": 95}'><?= old('additional_data') ?></textarea>
                            <small class="text-muted">Data tambahan dalam format JSON (opsional)</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" <?= old('is_active') ? 'checked' : 'checked' ?>>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= admin_url() ?>certificates" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
