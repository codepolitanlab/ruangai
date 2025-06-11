<?php $this->extend('layouts/admin') ?>

<?php $this->section('main') ?>

<div class="container">
    <a href="/zpanel/course/live" class="btn btn-link"><i class="bi bi-arrow-left"></i> Kembali</a>
    <h2><?= ($batch ?? null) ? 'Edit' : 'Add' ?> Batch</h2>

    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <div class="card rounded-xl shadow">
                    <div class="card-body">
                        <form action="<?= site_url('/zpanel/course/live/' . (isset($batch) ? 'update' : 'create')) ?>" method="post">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Course ID</label>
                                <input type="text" disabled class="form-control" value="<?= $course['course_title'] ?>">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <input type="hidden" name="id" value="<?= $batch['id'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Batch Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?= $batch['name'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $batch['start_date'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $batch['end_date'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="upcoming" <?= (isset($batch) && $batch['status'] == 'upcoming') ? 'selected' : '' ?>>Upcoming</option>
                                    <option value="ongoing" <?= (isset($batch) && $batch['status'] == 'ongoing') ? 'selected' : '' ?>>Ongoing</option>
                                    <option value="completed" <?= (isset($batch) && $batch['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>