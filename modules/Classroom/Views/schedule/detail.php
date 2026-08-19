<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Detail Materi — <?= esc($cm['material_title']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes">Kelas</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule">Jadwal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-4">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Info Materi</strong></div>
                <div class="card-body">
                    <dl class="mb-0 small">
                        <dt>Subtitle</dt><dd><?= esc($cm['material_subtitle'] ?? '-') ?></dd>
                        <dt>Deskripsi</dt><dd><?= esc($cm['material_description'] ?? '-') ?></dd>
                        <dt>Jadwal</dt>
                        <dd><?= $cm['scheduled_at'] ? date('d M Y H:i', strtotime($cm['scheduled_at'])) : '<span class="text-danger">Belum dijadwalkan</span>' ?></dd>
                        <dt>Status</dt>
                        <dd><?= $cm['is_open'] ? '<span class="badge text-bg-success">Terbuka</span>' : '<span class="badge text-bg-secondary">Tertutup</span>' ?></dd>
                        <dt>Instruktur ID</dt><dd><?= $cm['instructor_id'] ? (int) $cm['instructor_id'] : '-' ?></dd>
                        <dt>Catatan</dt><dd><?= esc($cm['notes'] ?? '-') ?></dd>
                    </dl>

                    <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/update" class="mt-3 border-top pt-3">
                        <div class="mb-2">
                            <label class="form-label">Jadwal (scheduled_at)</label>
                            <input type="datetime-local" name="scheduled_at" class="form-control"
                                value="<?= $cm['scheduled_at'] ? date('Y-m-d\TH:i', strtotime($cm['scheduled_at'])) : '' ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="2"><?= esc($cm['notes']) ?></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100">Simpan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Resource dalam Materi</strong>
                    <span class="badge text-bg-info ms-2"><?= count($resources) ?> resource</span>
                </div>
                <div class="table-responsive px-2 pb-2">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Urut</th>
                                <th>Tipe</th>
                                <th>Judul</th>
                                <th>Kriteria</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resources as $r) : ?>
                                <tr>
                                    <td><?= (int) $r['order_seq'] ?></td>
                                    <td><span class="badge text-bg-secondary"><?= esc($r['type']) ?></span></td>
                                    <td>
                                        <?= esc($r['title']) ?>
                                        <?php if ($r['is_required']) : ?><span class="badge text-bg-warning">wajib</span><?php endif; ?>
                                        <?php if ($r['type'] === 'meeting') : ?><span class="badge text-bg-info">tatap muka</span><?php endif; ?>
                                    </td>
                                    <td><?= esc($r['completion_criteria']) ?></td>
                                    <td class="text-end text-nowrap">
                                        <?php if ($r['type'] === 'meeting') : ?>
                                            <a class="btn btn-sm btn-outline-info" title="Kelola Tatap Muka"
                                                href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/resource/<?= $r['id'] ?>"><i class="bi bi-camera-video"></i></a>
                                        <?php elseif ($r['type'] === 'submission') : ?>
                                            <a class="btn btn-sm btn-outline-success" title="Matriks Submission"
                                                href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/resource/<?= $r['id'] ?>"><i class="bi bi-upload"></i></a>
                                        <?php elseif ($r['type'] === 'quiz') : ?>
                                            <a class="btn btn-sm btn-outline-warning" title="Matriks Kuis"
                                                href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/resource/<?= $r['id'] ?>"><i class="bi bi-patch-question"></i></a>
                                        <?php else : ?>
                                            <a class="btn btn-sm btn-outline-primary" title="Matriks Progress"
                                                href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/resource/<?= $r['id'] ?>"><i class="bi bi-graph-up"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if (! empty($resources)) : ?>
                <div class="card card-block rounded-xl shadow mt-3">
                    <div class="card-header"><strong>Pengaturan Info Meeting per Resource</strong></div>
                    <div class="card-body">
                        <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/meeting-info">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Pilih Resource Meeting</label>
                                    <select name="resource_id" class="form-select" required>
                                        <?php foreach ($resources as $r) : ?>
                                            <option value="<?= (int) $r['id'] ?>"><?= esc($r['title']) ?> (<?= esc($r['type']) ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-8 row">
                                    <div class="col-md-4 mb-2"><label class="form-label">URL / Zoom</label><input type="text" name="url" class="form-control"></div>
                                    <div class="col-md-4 mb-2"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control"></div>
                                    <div class="col-md-4 mb-2"><label class="form-label">Catatan</label><input type="text" name="notes" class="form-control"></div>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary mt-2">Simpan Info Meeting</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
