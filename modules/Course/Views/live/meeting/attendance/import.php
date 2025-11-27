<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/'); ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/' . $meeting['course_id'] . '/live'); ?>">Live Batches</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/live/' . $live_meeting['live_batch_id'] . '/meeting'); ?>">Meetings</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant'); ?>">Meeting Attendance</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Import CSV</li>
                    </ol>
                </nav>
                <h3>Import Meeting Attendance</h3>
                <h5 class="h6">Live Meeting: <?= esc($live_meeting['title']); ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant'); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">
                

                <p class="mb-3">Unggah file CSV dengan kolom berikut: <code>email,rating,duration,comment</code>.</p>

                <form action="<?= site_url(urlScope() . '/course/live/meeting/' . $slug . '/attendant/import'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">File CSV</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Upload & Import</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>