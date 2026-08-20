<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Karya Member</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Classroom / Karya Member</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/memberworks/create" class="btn btn-primary"><i class="bi bi-plus"></i> Buat Karya</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="header-block header-block-search ps-1 mt-2 mb-2">
                <form method="GET" role="search" class="d-flex gap-2 flex-wrap align-items-center px-3 pt-2">
                    <div class="input-group" style="max-width: 320px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari karya / penulis..."
                            value="<?= esc($search ?? '') ?>">
                        <button type="submit" class="btn btn-outline-primary"><span class="bi bi-search"></span></button>
                        <a href="/<?= urlScope() ?>/classroom/memberworks" class="btn btn-outline-secondary"><span class="bi bi-arrow-repeat"></span></a>
                    </div>
                    <select name="status" class="form-select" style="max-width: 180px;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="published" <?= ($status ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                        <option value="rejected" <?= ($status ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </form>
            </div>

            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Deskripsi Singkat</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($works)) : ?>
                            <?php foreach ($works as $i => $w) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td class="fw-bold"><?= esc($w['title']) ?></td>
                                    <td><?= esc($w['user_name'] ?? '-') ?><br><small class="text-muted"><?= esc($w['user_email'] ?? '') ?></small></td>
                                    <td class="text-muted" style="max-width:280px"><?= esc($w['short_description']) ?></td>
                                    <td>
                                        <?php
                                        $badge = ['pending' => 'text-bg-warning', 'published' => 'text-bg-success', 'rejected' => 'text-bg-danger'][$w['status']] ?? 'text-bg-secondary';
                                        ?>
                                        <span class="badge <?= $badge ?>"><?= esc($w['status']) ?></span>
                                    </td>
                                    <td><?= $w['created_at'] ? date('d M Y', strtotime($w['created_at'])) : '-' ?></td>
                                    <td class="text-end text-nowrap">
                                        <a class="btn btn-sm btn-outline-primary" title="Detail"
                                            href="/<?= urlScope() ?>/classroom/memberworks/<?= $w['id'] ?>"><i class="bi bi-eye"></i></a>
                                        <a class="btn btn-sm btn-outline-secondary" title="Edit"
                                            href="/<?= urlScope() ?>/classroom/memberworks/<?= $w['id'] ?>/edit"><i class="bi bi-pencil-square"></i></a>
                                        <?php if ($w['status'] !== 'published') : ?>
                                            <form method="POST" action="/<?= urlScope() ?>/classroom/memberworks/<?= $w['id'] ?>/moderate" class="d-inline">
                                                <input type="hidden" name="status" value="published">
                                                <button class="btn btn-sm btn-success" title="Publish" onclick="return confirm('Setujui & publikasikan karya ini?')"><i class="bi bi-check-lg"></i></button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if ($w['status'] !== 'rejected') : ?>
                                            <form method="POST" action="/<?= urlScope() ?>/classroom/memberworks/<?= $w['id'] ?>/moderate" class="d-inline">
                                                <input type="hidden" name="status" value="rejected">
                                                <button class="btn btn-sm btn-outline-danger" title="Tolak" onclick="return confirm('Tolak karya ini?')"><i class="bi bi-x-lg"></i></button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" action="/<?= urlScope() ?>/classroom/memberworks/<?= $w['id'] ?>/delete"
                                            class="d-inline" onsubmit="return confirm('Hapus karya ini?')">
                                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada karya.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
