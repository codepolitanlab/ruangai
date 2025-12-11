<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<style>
.card-stats {
    transition: transform 0.2s;
}

.card-stats:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.table-responsive {
    overflow-x: auto;
}

.badge-followup {
    font-size: 0.9rem;
    padding: 0.5rem 0.8rem;
}
</style>

<div class="page-heading">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $page_title ?></h3>
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Followup Comentor</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Comentor dan Total Followup</h5>
        </div>
        <div class="card-body">
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

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Nama Comentor</th>
                            <th width="25%">Email</th>
                            <th width="15%">No. Telepon</th>
                            <th width="15%">Kode Referral</th>
                            <th width="10%" class="text-center">Total Followup</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($comentors)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data comentor</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($comentors as $comentor): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($comentor['name']) ?></td>
                                    <td><?= esc($comentor['email']) ?></td>
                                    <td><?= esc($comentor['phone'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($comentor['referral_code_comentor']): ?>
                                            <code><?= esc($comentor['referral_code_comentor']) ?></code>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-followup bg-primary">
                                            <?= number_format($comentor['total_followup']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($comentor['total_followup'] > 0): ?>
                                            <a href="/<?= urlScope() ?>/scholarship/followup-comentors/<?= $comentor['id'] ?>/detail" 
                                               class="btn btn-sm btn-info" 
                                               title="Lihat Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php $this->endSection() ?>
<!-- END Content Section -->
