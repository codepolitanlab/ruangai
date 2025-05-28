<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="container">
    <a href="/zpanel/course/live/schedule/<?= $batch['id'] ?>" class="btn btn-link"><i class="bi bi-arrow-left"></i> Kembali</a>
    <h2><?= ($meeting ?? null) ? 'Edit' : 'Add' ?> Meeting</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="<?= site_url('/zpanel/course/live/schedule/' . (isset($meeting) ? 'update' : 'create')) ?>" method="post">
                <div class="mb-3">
                    <label for="batch_name" class="form-label">Batch</label>
                    <input type="text" disabled class="form-control" value="<?= $batch['name'] ?>">
                    <input type="hidden" name="live_batch_id" value="<?= $batch['id'] ?>">
                    <input type="hidden" name="id" value="<?= $meeting['id'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Meeting</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= $meeting['title'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="subtitle" class="form-label">Sub Judul Meeting</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control" value="<?= $meeting['subtitle'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?= $meeting['description'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="mentor_name" class="form-label">Nama Mentor</label>
                    <input type="text" name="mentor_name" id="mentor_name" class="form-control" value="<?= $meeting['mentor_name'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="meeting_date" class="form-label">Tanggal Meeting</label>
                    <input type="date" name="meeting_date" id="meeting_date" class="form-control" value="<?= isset($meeting['meeting_date']) ? date('Y-m-d', strtotime($meeting['meeting_date'])) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="meeting_time" class="form-label">Waktu Meeting</label>
                    <input type="time" name="meeting_time" id="meeting_time" class="form-control" value="<?= isset($meeting['meeting_time']) ? date('H:i', strtotime($meeting['meeting_time'])) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="scheduled" <?= (isset($meeting['status']) && $meeting['status'] == 'scheduled') ? 'selected' : '' ?>>Scheduled</option>
                        <option value="ongoing" <?= (isset($meeting['status']) && $meeting['status'] == 'ongoing') ? 'selected' : '' ?>>Ongoing</option>
                        <option value="completed" <?= (isset($meeting['status']) && $meeting['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="zoom_link" class="form-label">Link Zoom</label>
                    <input type="url" name="zoom_link" id="zoom_link" class="form-control" value="<?= $meeting['zoom_link'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="recording_link" class="form-label">Link Recording</label>
                    <input type="url" name="recording_link" id="recording_link" class="form-control" value="<?= $meeting['recording_link'] ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label for="form_feedback_url" class="form-label">Form Feedback URL</label>
                    <input type="url" name="form_feedback_url" id="form_feedback_url" class="form-control" value="<?= $meeting['form_feedback_url'] ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->