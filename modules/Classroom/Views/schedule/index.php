<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Jadwal &amp; Detail Materi — <?= esc($class['name']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jadwal</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/sync" class="d-inline"
                    onsubmit="return confirm('Sinkronkan semua materi silabus ke jadwal kelas?')">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-arrow-repeat"></i> Sinkronkan Materi</button>
                </form>
                <a href="/<?= urlScope() ?>/classroom/classes" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <?php if (! empty($unsyncedMaterials)) : ?>
        <div class="alert alert-warning d-flex align-items-center">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <div>
                <strong><?= count($unsyncedMaterials) ?> materi silabus belum ter-sync ke kelas.</strong>
                Klik "Sinkronkan Materi" untuk menambahkan ke jadwal.
                <ul class="mb-0 mt-1">
                    <?php foreach ($unsyncedMaterials as $m) : ?>
                        <li><?= esc($m['title']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="card-header"><strong>Daftar Materi Kelas</strong>
                <span class="badge text-bg-info ms-2"><?= count($classMaterials) ?> materi</span>
            </div>
            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Urut</th>
                            <th>Materi</th>
                            <th>Jadwal</th>
                            <th>Status Buka</th>
                            <th>Dibuka</th>
                            <th>Catatan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classMaterials as $cm) : ?>
                            <tr>
                                <td><?= (int) $cm['material_order_seq'] ?></td>
                                <td>
                                    <a class="fw-bold text-decoration-none" href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>">
                                        <?= esc($cm['material_title']) ?>
                                    </a>
                                    <br><small class="text-muted"><?= esc($cm['material_subtitle']) ?></small>
                                </td>
                                <td>
                                    <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/update" class="d-flex gap-1">
                                        <input type="datetime-local" name="scheduled_at" class="form-control form-control-sm"
                                            value="<?= $cm['scheduled_at'] ? date('Y-m-d\TH:i', strtotime($cm['scheduled_at'])) : '' ?>">
                                        <button class="btn btn-sm btn-outline-primary" title="Simpan jadwal"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/toggle-open">
                                        <button type="submit" class="btn btn-sm <?= $cm['is_open'] ? 'btn-success' : 'btn-secondary' ?>">
                                            <i class="bi <?= $cm['is_open'] ? 'bi-unlock' : 'bi-lock' ?>"></i>
                                            <?= $cm['is_open'] ? 'Terbuka' : 'Tertutup' ?>
                                        </button>
                                    </form>
                                </td>
                                <td><?= $cm['opened_at'] ? date('d M Y H:i', strtotime($cm['opened_at'])) : '-' ?></td>
                                <td class="text-muted" style="max-width:200px"><?= esc($cm['notes']) ?></td>
                                <td class="text-end text-nowrap">
                                    <a class="btn btn-sm btn-outline-primary" title="Detail"
                                        href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>"><i class="bi bi-eye"></i></a>
                                    <a class="btn btn-sm btn-outline-info" title="Progres Peserta"
                                        href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/progress"><i class="bi bi-graph-up"></i></a>
                                    <a class="btn btn-sm btn-outline-warning" title="Hasil Kuis"
                                        href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/quiz-results"><i class="bi bi-patch-question"></i></a>
                                    <a class="btn btn-sm btn-outline-success" title="Submission"
                                        href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/submissions"><i class="bi bi-upload"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
