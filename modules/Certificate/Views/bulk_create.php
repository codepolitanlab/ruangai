<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><?= esc($title) ?></h5>
                    <div class="d-flex align-items-center gap-2">
                        <ul class="nav nav-pills nav-sm mb-0">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= admin_url() ?>certificates/create">
                                    <i class="fas fa-user me-1"></i> Single
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?= admin_url() ?>certificates/bulk-create">
                                    <i class="fas fa-users me-1"></i> Bulk
                                </a>
                            </li>
                        </ul>
                        <a href="<?= admin_url() ?>certificates" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
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

                    <?php $summary = session()->getFlashdata('bulk_summary'); ?>
                    <?php if ($summary): ?>
                        <div class="alert alert-<?= $summary['failed'] === 0 ? 'success' : ($summary['success'] === 0 ? 'danger' : 'warning') ?> alert-dismissible fade show" role="alert">
                            <strong>Hasil Generate:</strong>
                            <?= $summary['success'] ?> berhasil,
                            <?= $summary['failed'] ?> gagal/dilewati
                            dari total <?= $summary['total'] ?> email.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php $notFoundEmails = session()->getFlashdata('bulk_not_found_emails'); ?>
                    <?php if ($notFoundEmails && !empty($notFoundEmails)): ?>
                        <div class="card mb-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-slash me-2"></i>
                                    Email Tidak Ditemukan (<?= count($notFoundEmails) ?>)
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><strong>Daftar email yang perlu ditindaklanjuti (user tidak terdaftar):</strong></p>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($notFoundEmails as $email): ?>
                                        <li class="mb-1">
                                            <i class="fas fa-envelope text-danger me-2"></i>
                                            <code><?= esc($email) ?></code>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $results = session()->getFlashdata('bulk_results'); ?>
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
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $i => $result): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= esc($result['email']) ?></td>
                                                <td><?= isset($result['name']) ? esc($result['name']) : '-' ?></td>
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

                    <form action="<?= admin_url() ?>certificates/bulk-create" method="post">
                        <?= csrf_field() ?>

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
                                <!-- Entity ID: number input untuk course -->
                                <div class="mb-3" id="entity-id-manual">
                                    <label class="form-label">Entity ID <span class="text-danger">*</span></label>
                                    <input type="number" name="entity_id" class="form-control" value="<?= old('entity_id') ?>" min="1">
                                    <small class="text-muted">ID course/workshop/training/dll</small>
                                </div>

                                <!-- Entity ID: dropdown untuk event/challenge -->
                                <div class="mb-3" id="entity-id-dropdown" style="display:none;">
                                    <label class="form-label">Pilih Event/Challenge <span class="text-danger">*</span></label>
                                    <select name="entity_id" class="form-select">
                                        <option value="">Pilih Event/Challenge</option>
                                        <?php foreach ($events as $ev): ?>
                                            <option value="<?= $ev['id'] ?>" <?= old('entity_id') == $ev['id'] ? 'selected' : '' ?>>
                                                <?= esc($ev['title']) ?> (<?= date('d M Y', strtotime($ev['start_date'])) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">Pilih event/challenge yang sudah tersedia</small>
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
                            <label class="form-label">Daftar Email Peserta <span class="text-danger">*</span></label>
                            <textarea name="emails" class="form-control font-monospace" rows="10"
                                placeholder="Masukkan satu email per baris:&#10;user1@example.com&#10;user2@example.com&#10;user3@example.com"
                                required><?= old('emails') ?></textarea>
                            <small class="text-muted">
                                Satu email per baris. Nama peserta akan diambil otomatis dari database berdasarkan email.
                                Sertifikat duplikat (email + entity yang sama) akan dilewati.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Data (JSON)</label>
                            <textarea name="additional_data" class="form-control" rows="8" placeholder='{"instructor": "John Doe", "score": 95}'><?= old('additional_data') ?></textarea>
                            <small class="text-muted">Data tambahan dalam format JSON (opsional)</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" <?= old('is_active', '1') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
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

<script>
var eventsData = <?= json_encode(!empty($events) ? array_column($events, 'title', 'id') : new stdClass()) ?>;

document.addEventListener('DOMContentLoaded', function() {
    var entityTypeSelect = document.querySelector('select[name="entity_type"]');
    var manualField = document.getElementById('entity-id-manual');
    var dropdownField = document.getElementById('entity-id-dropdown');
    var manualInput = manualField.querySelector('input[name="entity_id"]');
    var dropdownSelect = dropdownField.querySelector('select[name="entity_id"]');
    var titleInput = document.querySelector('input[name="title"]');

    function toggleEntityId() {
        var type = entityTypeSelect.value;
        var isEventOrChallenge = (type === 'event' || type === 'challenge');

        manualField.style.display = isEventOrChallenge ? 'none' : 'block';
        dropdownField.style.display = isEventOrChallenge ? 'block' : 'none';

        if (isEventOrChallenge) {
            manualInput.removeAttribute('required');
            dropdownSelect.setAttribute('required', 'required');
        } else {
            manualInput.setAttribute('required', 'required');
            dropdownSelect.removeAttribute('required');
        }
    }

    function fillTitle() {
        var selectedId = dropdownSelect.value;
        if (selectedId && eventsData[selectedId]) {
            titleInput.value = eventsData[selectedId];
        }
    }

    entityTypeSelect.addEventListener('change', toggleEntityId);
    dropdownSelect.addEventListener('change', fillTitle);
    toggleEntityId();
    fillTitle();
});
</script>
<?= $this->endSection() ?>
