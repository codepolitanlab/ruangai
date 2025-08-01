<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <form method="post" action="<?= isset($event) ? '/zpanel/events/form?id=' . $event->id : '/zpanel/events/form' ?>">
            <div class="mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><a href="/zpanel/user"><?= $page_title ?></a> • <?= isset($event) ? 'Edit' : 'New' ?></h2>
                        <nav aria-label="breadcrumb" class="breadcrumb-header">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/zpanel/events">Events</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form</li>
                            </ol>
                        </nav>
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
            <?php endif; ?>
            <!-- Session flashdata success -->

            <div class="row">


                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Data Event</div>

                        <div class="card-body">
                            <?php if(isset($event)): ?>
                            <input type="hidden" name="id" value="<?= $event->id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="<?= $event->title ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" value="<?= $event->code ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <input type="text" name="description" value="<?= $event->description ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date Start <span class="text-danger">*</span></label>
                                <input type="date" name="date_start" value="<?= ! empty($event->date_start) ? date('Y-m-d', strtotime($event->date_start)) : '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date End <span class="text-danger">*</span></label>
                                <input type="date" name="date_end" value="<?= ! empty($event->date_end) ? date('Y-m-d', strtotime($event->date_end)) : '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quota <span class="text-danger">*</span></label>
                                <input type="text" name="quota" value="<?= $event->quota ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Organizer <span class="text-danger">*</span></label>
                                <input type="text" name="organizer" value="<?= $event->organizer ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Telegram Link <span class="text-danger">*</span></label>
                                <input type="text" name="telegram_link" value="<?= $event->telegram_link ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Link Banner Image <span class="text-danger">*</span></label>
                                <input type="text" name="banner_image" value="<?= $event->banner_image ?? '' ?>" class="form-control" required>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">Pilih...</option>
                                    <option value="published" <?= (isset($event) && $event->status === 'published') ? 'selected' : ''?>>Published</option>
                                    <option value="draft" <?= (isset($event) && $event->status === 'draft') ? 'selected' : ''?>>Draft</option>
                                </select>
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