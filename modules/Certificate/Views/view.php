<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?= esc($title) ?></h5>
                    <div>
                        <a href="/certificate/<?= esc($certificate['cert_code']) ?>" target="_blank" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Sertifikat
                        </a>
                        <a href="<?= admin_url() ?>certificates" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Cert Code</th>
                                    <td>
                                        <strong><?= esc($certificate['cert_code']) ?></strong>
                                        <a href="/certificate/<?= esc($certificate['cert_code']) ?>" target="_blank" class="ms-2">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cert Number</th>
                                    <td><?= esc($certificate['cert_number'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <td><?= esc($certificate['participant_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>
                                        <?= esc($certificate['user_name']) ?><br>
                                        <small class="text-muted"><?= esc($certificate['email']) ?></small><br>
                                        <small class="text-muted"><?= esc($certificate['phone'] ?? '-') ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Judul</th>
                                    <td><?= esc($certificate['title']) ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Entity Type</th>
                                    <td><span class="badge bg-info"><?= esc(ucfirst($certificate['entity_type'])) ?></span></td>
                                </tr>
                                <tr>
                                    <th>Entity ID</th>
                                    <td><?= esc($certificate['entity_id']) ?></td>
                                </tr>
                                <tr>
                                    <th>Template</th>
                                    <td><?= esc($certificate['template_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php if ($certificate['is_active']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Claim</th>
                                    <td><?= $certificate['cert_claim_date'] ? date('d M Y H:i', strtotime($certificate['cert_claim_date'])) : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td><?= date('d M Y H:i', strtotime($certificate['created_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($certificate['additional_data_parsed'])): ?>
                        <hr>
                        <h6 class="mb-3">Additional Data</h6>
                        <div class="bg-light p-3 rounded">
                            <pre class="mb-0"><?= json_encode($certificate['additional_data_parsed'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= admin_url() ?>certificates/edit/<?= $certificate['id'] ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <button onclick="toggleStatus(<?= $certificate['id'] ?>, <?= $certificate['is_active'] ?>)" class="btn btn-secondary">
                            <i class="fas fa-toggle-<?= $certificate['is_active'] ? 'on' : 'off' ?> me-1"></i>
                            <?= $certificate['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                        </button>
                        <button onclick="deleteCertificate(<?= $certificate['id'] ?>)" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(id, currentStatus) {
    const action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
    if (!confirm(`Apakah Anda yakin ingin ${action} sertifikat ini?`)) return;

    fetch(`<?= admin_url() ?>certificates/toggle-status/${id}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Gagal mengubah status');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan');
    });
}

function deleteCertificate(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus sertifikat ini? Aksi ini tidak dapat dibatalkan.')) return;

    fetch(`<?= admin_url() ?>certificates/delete/${id}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = '?=? admin_url() ?>certificates';
        } else {
            alert(data.message || 'Gagal menghapus sertifikat');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan');
    });
}
</script>
<?= $this->endSection() ?>
