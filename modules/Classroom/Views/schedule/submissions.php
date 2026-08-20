<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Submission Tugas — <?= esc($cm['material_title']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule">Jadwal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Submission</li>
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
            <div class="card-header"><strong>Daftar Pengumpulan Tugas</strong>
                <span class="badge text-bg-info ms-2"><?= count($submissions) ?> submission</span>
            </div>
            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peserta</th>
                            <th>Tugas</th>
                            <th>Tipe</th>
                            <th>Berkas / URL</th>
                            <th>Status</th>
                            <th>Skor</th>
                            <th>Dikumpulkan</th>
                            <th class="text-end">Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($submissions)) : ?>
                            <?php foreach ($submissions as $i => $s) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($s['user_name'] ?? '-') ?></td>
                                    <td><?= esc($s['resource_title'] ?? '-') ?></td>
                                    <td><span class="badge text-bg-secondary"><?= esc($s['type']) ?></span></td>
                                    <td style="max-width:220px">
                                        <?php if ($s['type'] === 'file' && $s['file_path']) : ?>
                                            <a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/submissions/<?= $s['id'] ?>/download" class="text-decoration-none">
                                                <i class="bi bi-download"></i> <?= esc($s['file_name'] ?: basename($s['file_path'])) ?>
                                            </a>
                                            <small class="d-block text-muted"><?= $s['file_size'] ? number_format($s['file_size'] / 1024, 1) . ' KB' : '' ?></small>
                                        <?php elseif ($s['type'] === 'url' && $s['url']) : ?>
                                            <a href="<?= esc($s['url']) ?>" target="_blank" class="text-decoration-none"><i class="bi bi-box-arrow-up-right"></i> <?= esc($s['url']) ?></a>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badge = [
                                            'submitted' => 'text-bg-secondary',
                                            'accepted' => 'text-bg-success',
                                            'revision_needed' => 'text-bg-warning',
                                        ][$s['status']] ?? 'text-bg-secondary';
                                        ?>
                                        <span class="badge <?= $badge ?>"><?= esc($s['status']) ?></span>
                                    </td>
                                    <td><?= $s['review_score'] !== null ? (float) $s['review_score'] : '-' ?></td>
                                    <td><?= $s['submitted_at'] ? date('d M Y H:i', strtotime($s['submitted_at'])) : '-' ?></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#review<?= $s['id'] ?>">
                                            <i class="bi bi-pencil-square"></i> Review
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="review<?= $s['id'] ?>">
                                    <td colspan="9">
                                        <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/submissions/<?= $s['id'] ?>/review" class="row g-2 align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label small">Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="accepted" <?= $s['status'] === 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                                    <option value="revision_needed" <?= $s['status'] === 'revision_needed' ? 'selected' : '' ?>>Revisi</option>
                                                    <option value="submitted" <?= $s['status'] === 'submitted' ? 'selected' : '' ?>>Submitted (pending)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small">Skor (0-100)</label>
                                                <input type="number" name="review_score" class="form-control" min="0" max="100" step="0.01"
                                                    value="<?= esc($s['review_score']) ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label small">Catatan Review</label>
                                                <input type="text" name="review_note" class="form-control" value="<?= esc($s['review_note']) ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-primary w-100">Simpan</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada submission.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
