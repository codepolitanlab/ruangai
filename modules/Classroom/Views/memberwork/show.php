<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Detail Karya — <?= esc($work['title']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/memberworks">Karya Member</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/memberworks" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                <a href="/<?= urlScope() ?>/classroom/memberworks/<?= $work['id'] ?>/edit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <?php if ($work['thumbnail']) : ?>
                            <img src="<?= esc($work['thumbnail']) ?>" class="img-fluid rounded mb-3" style="max-height:300px;object-fit:cover" alt="Thumbnail">
                        <?php else : ?>
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center mb-3" style="height:200px">
                                <span class="text-muted">Tidak ada thumbnail</span>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <span class="badge <?= ['pending' => 'text-bg-warning', 'published' => 'text-bg-success', 'rejected' => 'text-bg-danger'][$work['status']] ?? 'text-bg-secondary' ?> fs-6">
                                <?= esc($work['status']) ?>
                            </span>
                        </div>
                        <dl class="small">
                            <dt>Penulis</dt><dd><?= esc($work['user_name'] ?? '-') ?> (<?= esc($work['user_email'] ?? '-') ?>)</dd>
                            <dt>URL Project</dt>
                            <dd>
                                <?php if ($work['url_project']) : ?>
                                    <a href="<?= esc($work['url_project']) ?>" target="_blank"><?= esc($work['url_project']) ?></a>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </dd>
                            <dt>Dibuat</dt><dd><?= $work['created_at'] ? date('d M Y H:i', strtotime($work['created_at'])) : '-' ?></dd>
                            <dt>Diperbarui</dt><dd><?= $work['updated_at'] ? date('d M Y H:i', strtotime($work['updated_at'])) : '-' ?></dd>
                        </dl>
                    </div>
                    <div class="col-lg-8">
                        <h5><?= esc($work['title']) ?></h5>
                        <p class="text-muted fst-italic"><?= esc($work['short_description']) ?></p>
                        <hr>
                        <div class="mb-4"><?= nl2br(esc($work['description'])) ?></div>

                        <?php if (! empty($photos)) : ?>
                            <h6 class="text-muted">Galeri</h6>
                            <div class="row g-2">
                                <?php foreach ($photos as $photo) : ?>
                                    <div class="col-6 col-md-4">
                                        <img src="<?= esc($photo) ?>" class="img-fluid rounded" style="height:150px;object-fit:cover;width:100%">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
