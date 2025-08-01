<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('/zpanel'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/'); ?>">Courses</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/' . $live_meeting->live_batch_id); ?>">Live Batches</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/schedule/' . $live_meeting->live_batch_id); ?>">Schedule</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/schedule/attendance/' . $live_meeting->live_batch_id); ?>">Attendances</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Import</li>
                        </ol>
                    </nav>
                    <h2><a href="/zpanel/user"><?= $page_title ?></a> • <?= isset($event) ? 'Edit' : 'New' ?></h2>
                </div>
            </div>
        </div>

        <!-- Session flashdata error -->
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->get('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!-- Session flashdata success -->

        <div class="row">


            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Data Event</div>

                    <form
                        method="post"
                        enctype="multipart/form-data"
                        action="<?= site_url('/zpanel/course/live/schedule/attendance/import/' . $live_meeting_id); ?>">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Live Meeting <span class="text-danger">*</span></label>
                                <input type="text" value="<?= $live_meeting->title ?? '' ?>" class="form-control" required readonly disabled>
                                <input type="hidden" name="live_meeting_id" value="<?= $live_meeting->id ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CSV File <span class="text-danger">*</span></label>
                                <p class="text-muted">Format column: <code>email,duration</code></p>
                                <input type="file" name="userfile" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success mb-0"><span class="bi bi-upload"></span> Upload</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->