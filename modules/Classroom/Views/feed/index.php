<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Pengumuman — <?= esc($class['name']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-5">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Buat Pengumuman</strong></div>
                <div class="card-body">
                    <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/feeds/store">
                        <div class="mb-3">
                            <label class="form-label">Judul (opsional)</label>
                            <input type="text" name="title" class="form-control" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                            <textarea name="body" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="pinned" value="1" id="pin_new">
                            <label class="form-check-label" for="pin_new">Pin (tampil paling atas)</label>
                        </div>
                        <button class="btn btn-primary w-100">Terbitkan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Daftar Pengumuman</strong>
                    <span class="badge text-bg-info ms-2"><?= count($feeds) ?> pengumuman</span>
                </div>
                <div class="card-body p-2">
                    <?php if (empty($feeds)) : ?>
                        <div class="text-center text-muted py-4">Belum ada pengumuman.</div>
                    <?php endif; ?>
                    <?php foreach ($feeds as $f) : ?>
                        <div class="border rounded p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <?php if ($f['pinned']) : ?><span class="badge text-bg-danger mb-1"><i class="bi bi-pin-angle-fill"></i> Pinned</span><?php endif; ?>
                                    <?php if ($f['title']) : ?><h6 class="mb-1"><?= esc($f['title']) ?></h6><?php endif; ?>
                                    <div class="small text-muted mb-1"><?= $f['created_at'] ? date('d M Y H:i', strtotime($f['created_at'])) : '-' ?></div>
                                    <p class="mb-0"><?= nl2br(esc($f['body'])) ?></p>
                                </div>
                                <div class="text-nowrap ms-2">
                                    <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/feeds/<?= $f['id'] ?>/toggle-pin" class="d-inline">
                                        <button class="btn btn-sm btn-outline-danger" title="Pin/Unpin"><i class="bi bi-pin"></i></button>
                                    </form>
                                    <button class="btn btn-sm btn-outline-primary" title="Edit"
                                        data-bs-toggle="collapse" data-bs-target="#feedEdit<?= $f['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                    <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/feeds/<?= $f['id'] ?>/delete"
                                        class="d-inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="collapse mt-2" id="feedEdit<?= $f['id'] ?>">
                                <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/feeds/<?= $f['id'] ?>/update" class="border-top pt-2">
                                    <div class="mb-2"><input type="text" name="title" class="form-control" value="<?= esc($f['title']) ?>" placeholder="Judul"></div>
                                    <div class="mb-2"><textarea name="body" class="form-control" rows="3" required><?= esc($f['body']) ?></textarea></div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="pinned" value="1" id="pin_edit_<?= $f['id'] ?>" <?= $f['pinned'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pin_edit_<?= $f['id'] ?>">Pin</label>
                                    </div>
                                    <button class="btn btn-sm btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
