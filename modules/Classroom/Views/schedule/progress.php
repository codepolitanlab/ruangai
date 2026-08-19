<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Progres Peserta — <?= esc($cm['material_title']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule">Jadwal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Progres</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="card-header"><strong>Persentase Selesai (resource wajib)</strong></div>
            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Selesai</th>
                            <th style="min-width:200px">Progres</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($members)) : ?>
                            <?php foreach ($members as $i => $m) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($m['user_name'] ?? '-') ?></td>
                                    <td><?= esc($m['email'] ?? '-') ?></td>
                                    <td><?= (int) $m['completed_count'] ?> / <?= (int) $m['required_count'] ?></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: <?= (float) $m['percent'] ?>%"
                                                aria-valuenow="<?= (float) $m['percent'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td><strong><?= (float) $m['percent'] ?>%</strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada peserta aktif.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
