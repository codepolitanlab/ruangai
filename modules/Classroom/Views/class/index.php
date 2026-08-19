<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Kelas</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Classroom / Kelas</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes/form" class="btn btn-primary"><i class="bi bi-plus"></i> Buat Kelas</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="header-block header-block-search ps-1 mt-2 mb-2">
                <form method="GET" role="search" class="d-flex gap-2 flex-wrap align-items-center px-3 pt-2">
                    <div class="input-group" style="max-width: 320px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari kelas..."
                            value="<?= esc($search ?? '') ?>">
                        <button type="submit" class="btn btn-outline-primary"><span class="bi bi-search"></span></button>
                        <a href="/<?= urlScope() ?>/classroom/classes" class="btn btn-outline-secondary"><span class="bi bi-arrow-repeat"></span></a>
                    </div>
                    <select name="status" class="form-select" style="max-width: 180px;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="archived" <?= ($status ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                    </select>
                </form>
            </div>

            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kelas</th>
                            <th>Silabus</th>
                            <th>Peserta</th>
                            <th>Tanggal Mulai</th>
                            <th>Sertifikat</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($classes)) : ?>
                            <?php foreach ($classes as $i => $c) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td class="fw-bold">
                                        <?= esc($c['name']) ?>
                                        <?php if ($c['status'] === 'active') : ?>
                                            <span class="badge text-bg-success">Active</span>
                                        <?php elseif ($c['status'] === 'archived') : ?>
                                            <span class="badge text-bg-secondary">Archived</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-warning">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($c['syllabus_name']) ?></td>
                                    <td><span class="badge text-bg-info"><?= (int) $c['member_count'] ?></span></td>
                                    <td><?= $c['start_date'] ? date('d M Y', strtotime($c['start_date'])) : '-' ?></td>
                                    <td>
                                        <?php if ($c['certificate_claimable']) : ?>
                                            <span class="badge text-bg-success">Claimable</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-light border">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($c['status'] === 'active') : ?>
                                            <span class="badge text-bg-success">Active</span>
                                        <?php elseif ($c['status'] === 'archived') : ?>
                                            <span class="badge text-bg-secondary">Archived</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-warning">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <a class="btn btn-sm btn-outline-secondary" title="Jadwal"
                                            href="/<?= urlScope() ?>/classroom/classes/<?= $c['id'] ?>/schedule"><i class="bi bi-calendar-week"></i></a>
                                        <a class="btn btn-sm btn-outline-info" title="Peserta"
                                            href="/<?= urlScope() ?>/classroom/classes/<?= $c['id'] ?>/members"><i class="bi bi-people"></i></a>
                                        <a class="btn btn-sm btn-outline-warning" title="Pengumuman"
                                            href="/<?= urlScope() ?>/classroom/classes/<?= $c['id'] ?>/feeds"><i class="bi bi-megaphone"></i></a>
                                        <a class="btn btn-sm btn-outline-success" title="Feedback"
                                            href="/<?= urlScope() ?>/classroom/classes/<?= $c['id'] ?>/feedbacks"><i class="bi bi-chat-square-text"></i></a>
                                        <a class="btn btn-sm btn-outline-primary" title="Edit"
                                            href="/<?= urlScope() ?>/classroom/classes/<?= $c['id'] ?>/edit"><i class="bi bi-pencil-square"></i></a>
                                        <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $c['id'] ?>/delete"
                                            class="d-inline" onsubmit="return confirm('Hapus kelas ini?')">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada kelas.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
