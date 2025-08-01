<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2><a href="/<?= urlScope() ?>/course/live/meeting/<?= $meeting['id'] ?>/attendant">
                        <?= $page_title ?></a> &middot; <?= isset($event) ? 'Edit' : 'Add' ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <form method="post">

                            <?php if (isset($attendance)): ?>
                                <input type="hidden" name="id" value="<?= $attendance->id ?? '' ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Live Meeting <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="<?= $meeting['title'] . ' - ' . $meeting['subtitle'] . ' - ' . $meeting['batch'] ?>" class="form-control" required readonly disabled>
                                <input type="hidden" name="live _meeting_id" value="<?= $meeting['id'] ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="<?= $attendance->email ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Durasi <span class="text-danger">*</span></label>
                                <input type="number" name="duration" value="<?= $attendance->duration ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">--</option>
                                    <option value="1">Valid</option>
                                    <option value="0">Tidak Valid</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mb-0"><span class="bi bi-save"></span> Simpan</button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->