<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<?php $isMeeting = $resource['type'] === 'meeting'; ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Matriks Resource — <?= esc($resource['title']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule">Jadwal</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>">Detail</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Matriks</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-4">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Info Resource</strong></div>
                <div class="card-body small">
                    <dl class="mb-0">
                        <dt>Judul</dt><dd><?= esc($resource['title']) ?></dd>
                        <dt>Tipe</dt><dd><span class="badge text-bg-secondary"><?= esc($resource['type']) ?></span></dd>
                        <dt>Kriteria Selesai</dt><dd><?= esc($resource['completion_criteria']) ?></dd>
                        <dt>Wajib</dt><dd><?= $resource['is_required'] ? 'Ya' : 'Tidak' ?></dd>
                        <dt>Perlu Review</dt><dd><?= $resource['need_review'] ? 'Ya' : 'Tidak' ?></dd>
                    </dl>

                    <?php if ($isMeeting) : ?>
                        <hr>
                        <strong class="small">Detail Tatap Muka</strong>
                        <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/resource/<?= $resource['id'] ?>/meeting-detail" class="mt-2">
                            <?php $md = $resource['meeting_detail'] ?? []; ?>
                            <div class="mb-2">
                                <label class="form-label">Mode</label>
                                <select name="mode" class="form-select">
                                    <option value="online" <?= ($md['mode'] ?? '') === 'online' ? 'selected' : '' ?>>Online</option>
                                    <option value="offline" <?= ($md['mode'] ?? '') === 'offline' ? 'selected' : '' ?>>Offline</option>
                                    <option value="offline_online" <?= ($md['mode'] ?? '') === 'offline_online' ? 'selected' : '' ?>>Offline + Online</option>
                                </select>
                            </div>
                            <div class="mb-2"><label class="form-label">Nama Instruktur</label><input type="text" name="instructor_name" class="form-control" value="<?= esc($md['instructor_name'] ?? '') ?>"></div>
                            <div class="mb-2"><label class="form-label">Zoom Link</label><input type="text" name="zoom_link" class="form-control" value="<?= esc($md['zoom_link'] ?? '') ?>"></div>
                            <div class="mb-2"><label class="form-label">Venue / Tempat</label><input type="text" name="venue" class="form-control" value="<?= esc($md['venue'] ?? '') ?>"></div>
                            <div class="mb-2"><label class="form-label">Password</label><input type="text" name="password" class="form-control" value="<?= esc($md['password'] ?? '') ?>"></div>
                            <div class="mb-2"><label class="form-label">URL Rekaman</label><input type="text" name="recording_url" class="form-control" value="<?= esc($md['recording_url'] ?? '') ?>"></div>
                            <button class="btn btn-sm btn-primary w-100">Simpan Detail Meeting</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Status Peserta</strong>
                    <span class="badge text-bg-info ms-2"><?= count($members) ?> peserta</span>
                </div>
                <div class="table-responsive px-2 pb-2">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Peserta</th>
                                <th>Status Progress</th>
                                <?php if ($resource['type'] === 'quiz') : ?>
                                    <th>Hasil Kuis</th>
                                <?php elseif ($resource['type'] === 'submission') : ?>
                                    <th>Submission</th>
                                <?php endif; ?>
                                <?php if ($isMeeting) : ?>
                                    <th class="text-end">Absensi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($members)) : ?>
                                <?php foreach ($members as $i => $m) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($m['user_name'] ?? '-') ?></td>
                                        <td>
                                            <?php
                                            $st = $m['progress']['status'] ?? 'not_started';
                                            $badge = [
                                                'not_started' => 'text-bg-secondary',
                                                'in_progress' => 'text-bg-warning',
                                                'completed' => 'text-bg-success',
                                            ][$st] ?? 'text-bg-secondary';
                                            ?>
                                            <span class="badge <?= $badge ?>"><?= esc($st) ?></span>
                                        </td>
                                        <?php if ($resource['type'] === 'quiz') : ?>
                                            <td>
                                                <?php if (! empty($m['quiz_result'])) : ?>
                                                    <?= (float) $m['quiz_result']['score'] ?> / <?= (float) $m['quiz_result']['max_score'] ?>
                                                    (attempt #<?= (int) $m['quiz_result']['attempt_number'] ?>)
                                                    <?= $m['quiz_result']['passed'] ? '<span class="badge text-bg-success">Lulus</span>' : '<span class="badge text-bg-danger">Gagal</span>' ?>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php elseif ($resource['type'] === 'submission') : ?>
                                            <td>
                                                <?php if (! empty($m['submission'])) : ?>
                                                    <span class="badge text-bg-<?= $m['submission']['status'] === 'accepted' ? 'success' : ($m['submission']['status'] === 'revision_needed' ? 'warning' : 'secondary') ?>">
                                                        <?= esc($m['submission']['status']) ?>
                                                    </span>
                                                    <?php if ($m['submission']['review_score'] !== null) : ?>
                                                        · <?= (float) $m['submission']['review_score'] ?>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if ($isMeeting) : ?>
                                            <td class="text-end">
                                                <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule/<?= $cm['id'] ?>/resource/<?= $resource['id'] ?>/attendance" class="d-inline">
                                                    <input type="hidden" name="user_id" value="<?= (int) $m['user_id'] ?>">
                                                    <button type="submit" name="status" value="completed" class="btn btn-sm btn-success"
                                                        <?= ($m['progress']['status'] ?? '') === 'completed' ? 'disabled' : '' ?>>
                                                        <i class="bi bi-check-lg"></i> Hadir
                                                    </button>
                                                    <button type="submit" name="status" value="not_started" class="btn btn-sm btn-outline-secondary"
                                                        <?= ($m['progress']['status'] ?? '') !== 'completed' ? 'disabled' : '' ?>>
                                                        <i class="bi bi-x-lg"></i> Batal
                                                    </button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada peserta aktif.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
