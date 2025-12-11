<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<style>
.info-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.info-card h4 {
    color: white;
    margin-bottom: 5px;
}

.info-card p {
    margin-bottom: 5px;
    opacity: 0.95;
}

.table-responsive {
    overflow-x: auto;
}

.badge-status {
    font-size: 0.85rem;
    padding: 0.4rem 0.7rem;
}
</style>

<div class="page-heading">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Detail Followup Comentor</h3>
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/scholarship/followup-comentors">Followup Comentor</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first text-end">
            <a href="/<?= urlScope() ?>/scholarship/followup-comentors/<?= $comentor['id'] ?>/import" 
               class="btn btn-success me-2">
                <i class="bi bi-upload"></i> Import Peserta
            </a>
            <a href="/<?= urlScope() ?>/scholarship/followup-comentors" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<section class="section">
    <!-- Info Comentor -->
    <div class="info-card">
        <div class="row">
            <div class="col-md-8">
                <h4><i class="bi bi-person-circle"></i> <?= esc($comentor['name']) ?></h4>
                <p><i class="bi bi-envelope"></i> <?= esc($comentor['email']) ?></p>
                <p><i class="bi bi-phone"></i> <?= esc($comentor['phone'] ?? '-') ?></p>
            </div>
            <div class="col-md-4 text-end">
                <h2><?= number_format($total_followup) ?></h2>
                <p>Total Followup</p>
            </div>
        </div>
    </div>

    <!-- Table Daftar Followup -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Peserta Followup</h5>
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
                            <th width="3%">#</th>
                            <th width="20%">Nama Peserta</th>
                            <th width="20%">Email</th>
                            <th width="12%">Program</th>
                            <th width="12%">Progress</th>
                            <th width="10%">Live Attend</th>
                            <th width="10%">Status Lulus</th>
                            <th width="13%">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($followups)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data followup</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($followups as $followup): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?= esc($followup['fullname'] ?? $followup['user_name'] ?? '-') ?>
                                    </td>
                                    <td><?= esc($followup['email'] ?? $followup['user_email'] ?? '-') ?></td>
                                    <td><?= esc($followup['program'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        $progress = $followup['progress'] ?? 0;
                                        $progressClass = 'bg-danger';
                                        if ($progress >= 75) {
                                            $progressClass = 'bg-success';
                                        } elseif ($progress >= 50) {
                                            $progressClass = 'bg-warning';
                                        } elseif ($progress >= 25) {
                                            $progressClass = 'bg-info';
                                        }
                                        ?>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar <?= $progressClass ?>" 
                                                 role="progressbar" 
                                                 style="width: <?= $progress ?>%;" 
                                                 aria-valuenow="<?= $progress ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                <?= $progress ?>%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info" style="font-size: 0.9rem;">
                                            <?= esc($followup['total_live_attendance'] ?? 0) ?>x
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $graduate = $followup['graduate'] ?? 0;
                                        if ($graduate == 1) {
                                            echo '<span class="badge bg-success badge-status">Lulus</span>';
                                        } else {
                                            echo '<span class="badge bg-warning badge-status">Belum Lulus</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($followup['tanggal_daftar'])) {
                                            $date = new DateTime($followup['tanggal_daftar']);
                                            echo $date->format('d M Y');
                                        } elseif (isset($followup['created_at'])) {
                                            $date = new DateTime($followup['created_at']);
                                            echo $date->format('d M Y');
                                        } else {
                                            echo '-';
                                        }
                                        ?>
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
