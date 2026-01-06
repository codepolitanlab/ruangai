<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?= esc($title) ?></h5>
                    <a href="<?= admin_url() ?>certificates/create" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i> Buat Sertifikat
                    </a>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom">
                    <form method="get" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari cert code, nama, email..." value="<?= esc($filters['search'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="entity_type" class="form-select">
                                <option value="">Semua Tipe</option>
                                <?php 
                                $config = config('Certificate');
                                foreach ($config->certificateTypes as $key => $label): 
                                ?>
                                    <option value="<?= $key ?>" <?= ($filters['entity_type'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="1" <?= ($filters['status'] ?? '') === '1' ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= ($filters['status'] ?? '') === '0' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary me-2">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="<?= admin_url() ?>certificates" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Table -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Cert Code</th>
                                    <th>Peserta</th>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Template</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($certificates)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="bi bi-certificate fa-3x mb-3 d-block"></i>
                                            Tidak ada data sertifikat
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($certificates as $cert): ?>
                                        <tr>
                                            <td>
                                                <a href="/certificate/<?= esc($cert['cert_code']) ?>" target="_blank" class="text-decoration-none">
                                                    <strong><?= esc($cert['cert_code']) ?></strong>
                                                </a>
                                            </td>
                                            <td>
                                                <div><?= esc($cert['participant_name']) ?></div>
                                                <small class="text-muted"><?= esc($cert['user_name'] ?? '-') ?></small>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 250px;" title="<?= esc($cert['title']) ?>">
                                                    <?= esc($cert['title']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= esc(ucfirst($cert['entity_type'])) ?></span>
                                            </td>
                                            <td><?= esc($cert['template_name']) ?></td>
                                            <td>
                                                <small><?= date('d M Y', strtotime($cert['cert_claim_date'] ?? $cert['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <?php if ($cert['is_active']): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= admin_url() ?>certificates/view/<?= $cert['id'] ?>" class="btn btn-info" title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= admin_url() ?>certificates/edit/<?= $cert['id'] ?>" class="btn btn-warning" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button onclick="toggleStatus(<?= $cert['id'] ?>, <?= $cert['is_active'] ?>)" class="btn btn-<?= $cert['is_active'] ? 'success' : 'secondary' ?>" title="Toggle Status">
                                                        <i class="bi bi-toggle-<?= $cert['is_active'] ? 'on' : 'off' ?>"></i>
                                                    </button>
                                                    <button onclick="deleteCertificate(<?= $cert['id'] ?>)" class="btn btn-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($pager['totalPages'] > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= $pager['currentPage'] == 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $pager['currentPage'] - 1 ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>">Previous</a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $pager['totalPages']; $i++): ?>
                                    <?php if ($i == $pager['currentPage'] || $i == 1 || $i == $pager['totalPages'] || abs($i - $pager['currentPage']) <= 2): ?>
                                        <li class="page-item <?= $i == $pager['currentPage'] ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>"><?= $i ?></a>
                                        </li>
                                    <?php elseif (abs($i - $pager['currentPage']) == 3): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                
                                <li class="page-item <?= $pager['currentPage'] == $pager['totalPages'] ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $pager['currentPage'] + 1 ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
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
            location.reload();
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
