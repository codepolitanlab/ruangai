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
                            <?= csrf_field() ?>

                            <?php if (isset($attendance)): ?>
                                <input type="hidden" name="id" value="<?= esc($attendance->id ?? '') ?>">
                                <input type="hidden" name="meeting_feedback_id" value="<?= esc($attendance->meeting_feedback_id ?? '') ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Live Meeting <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="<?= esc($meeting['title'] . ' - ' . $meeting['subtitle'] . ' - ' . $meeting['batch']) ?>" class="form-control" required readonly disabled>
                                <!-- FIXED: nama input tanpa spasi -->
                                <input type="hidden" name="live_meeting_id" value="<?= esc($meeting['id'] ?? '') ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="<?= esc($attendance->email ?? '') ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Durasi <span class="text-danger">*</span></label>
                                <input type="number" name="duration" value="<?= esc($attendance->duration ?? 5400) ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <?php $statusValue = isset($attendance) ? (string)$attendance->status : ''; ?>
                                <select name="status" id="status" class="form-select">
                                    <option value="" <?= $statusValue === '' ? 'selected' : '' ?>>--</option>
                                    <option value="1" <?= $statusValue === '1' ? 'selected' : '' ?>>Valid</option>
                                    <option value="0" <?= $statusValue === '0' ? 'selected' : '' ?>>Tidak Valid</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rate <span class="text-danger">*</span></label>
                                <select name="rate" id="rate" class="form-select">
                                    <option value="" <?= (isset($attendance)) && $attendance->rate === '' ? 'selected' : '' ?>>--</option>
                                    <option value="1" <?= (isset($attendance)) && $attendance->rate === '1' ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= (isset($attendance)) && $attendance->rate === '2' ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= (isset($attendance)) && $attendance->rate === '3' ? 'selected' : '' ?>>3</option>
                                    <option value="4" <?= (isset($attendance)) && $attendance->rate === '4' ? 'selected' : '' ?>>4</option>
                                    <option value="5" <?= (isset($attendance)) && $attendance->rate === '5' ? 'selected' : '' ?>>5</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Feedback <span class="text-danger">*</span></label>
                                <textarea name="feedback" id="feedback" class="form-control"><?= esc($attendance->feedback ?? '') ?></textarea>
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