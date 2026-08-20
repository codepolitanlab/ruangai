<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Hasil Kuis — <?= esc($cm['material_title']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/schedule">Jadwal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hasil Kuis</li>
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
            <div class="card-header"><strong>Riwayat Percobaan Kuis</strong></div>
            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peserta</th>
                            <th>Resource / Kuis</th>
                            <th>Attempt</th>
                            <th>Skor</th>
                            <th>Status</th>
                            <th>Dikerjakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($results)) : ?>
                            <?php foreach ($results as $i => $qr) : ?>
                                <?php
                                $answers = json_decode($qr['answers'] ?? '[]', true) ?: [];
                                ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($qr['user_name'] ?? '-') ?></td>
                                    <td><?= esc($qr['resource_title'] ?? '-') ?></td>
                                    <td>#<?= (int) $qr['attempt_number'] ?></td>
                                    <td><strong><?= (float) $qr['score'] ?></strong> / <?= (float) $qr['max_score'] ?></td>
                                    <td>
                                        <?php if ($qr['passed']) : ?>
                                            <span class="badge text-bg-success">Lulus</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-danger">Tidak Lulus</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $qr['submitted_at'] ? date('d M Y H:i', strtotime($qr['submitted_at'])) : '-' ?></td>
                                </tr>
                                <?php if (! empty($answers)) : ?>
                                    <tr class="table-light">
                                        <td></td>
                                        <td colspan="6">
                                            <details>
                                                <summary class="small text-muted">Lihat jawaban (<?= count($answers) ?> soal)</summary>
                                                <pre class="small mb-0 mt-1" style="max-height:200px;overflow:auto"><?= esc(json_encode($answers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                                            </details>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada hasil kuis.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
