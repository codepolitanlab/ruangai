<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Feedback Peserta — <?= esc($class['name']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Feedback</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="card-header"><strong>Daftar Feedback</strong>
                <span class="badge text-bg-info ms-2"><?= count($feedbacks) ?> feedback</span>
                <span class="small text-muted ms-2">Gunakan untuk verifikasi syarat klaim sertifikat</span>
            </div>
            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peserta</th>
                            <th>Profesi</th>
                            <th>Kota</th>
                            <th>Kondisi Awal</th>
                            <th>Rating</th>
                            <th>Testimoni?</th>
                            <th>Dikirim</th>
                            <th class="text-end">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($feedbacks)) : ?>
                            <?php foreach ($feedbacks as $i => $f) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($f['user_name'] ?? '-') ?></td>
                                    <td><?= esc($f['profession']) ?></td>
                                    <td><?= esc($f['city']) ?></td>
                                    <td>
                                        <?= esc($condition_labels[$f['condition_before']] ?? $f['condition_before']) ?>
                                        <?php if ($f['condition_before_other']) : ?>
                                            <small class="text-muted">(<?= esc($f['condition_before_other']) ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php for ($s = 1; $s <= 5; $s++) : ?>
                                            <i class="bi <?= $s <= (int) $f['rating'] ? 'bi-star-fill text-warning' : 'bi-star text-muted' ?>"></i>
                                        <?php endfor; ?>
                                    </td>
                                    <td><?= $f['allow_testimonial'] ? '<span class="badge text-bg-success">Ya</span>' : '<span class="badge text-bg-secondary">Tidak</span>' ?></td>
                                    <td><?= $f['created_at'] ? date('d M Y', strtotime($f['created_at'])) : '-' ?></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#fb<?= $f['id'] ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="fb<?= $f['id'] ?>">
                                    <td colspan="9">
                                        <div class="row g-3 small">
                                            <div class="col-md-6"><strong>Alasan memilih:</strong><br><?= nl2br(esc($f['reason_choice'])) ?></div>
                                            <div class="col-md-6"><strong>Momen berkesan:</strong><br><?= nl2br(esc($f['favorite_moment'])) ?></div>
                                            <div class="col-md-6"><strong>Skill konkret:</strong><br><?= nl2br(esc($f['concrete_skill'])) ?></div>
                                            <div class="col-md-6"><strong>Pesan ke teman:</strong><br><?= nl2br(esc($f['message_to_friend'])) ?></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada feedback dari peserta.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
