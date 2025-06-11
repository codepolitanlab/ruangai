<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <form method="post" action="<?= isset($event) ? '/zpanel/course/live/schedule/attendance/form?id=' . $event->id : '/zpanel/course/live/schedule/attendance/form' ?>">
            <div class="mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><a href="/zpanel/user"><?= $page_title ?></a> • <?= isset($event) ? 'Edit' : 'New' ?></h2>
                        <!-- <nav aria-label="breadcrumb" class="breadcrumb-header">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/zpanel/events">Events</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form</li>
                            </ol>
                        </nav> -->
                    </div>
                    <div class="col-lg-6 text-end">
                        <button type="submit" class="btn btn-success mb-0"><span class="bi bi-save"></span> Simpan</button>
                    </div>
                </div>
            </div>

            <!-- Session flashdata error -->
            <?php if(session()->has('error')):?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->get('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif;?>
            <!-- Session flashdata success -->

            <div class="row">
                

                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Data Event</div>

                        <div class="card-body">
                            <?php if(isset($attendance)): ?>
                            <input type="hidden" name="id" value="<?= $attendance->id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Live Meeting <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="<?= $live_meeting->title ?? '' ?>" class="form-control" required readonly disabled>
                                <input type="hidden" name="live_meeting_id" value="<?= $live_meeting->id ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="<?= $attendance->email ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                <input type="number" name="duration" value="<?= $attendance->duration ?? '' ?>" class="form-control" required>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card mb-5">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-success mb-0"><span class="bi bi-save"></span> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->