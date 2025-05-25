<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="container">
    <a href="/zpanel/course/live/blueprint/<?= $course['id'] ?>" class="btn btn-link"><i class="bi bi-arrow-left"></i> Kembali</a>
    <h2>Edit Blueprint</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="<?= site_url('/zpanel/course/live/blueprint/create') ?>" method="post">
                <div class="mb-3">
                    <label for="course_id" class="form-label">Course ID</label>
                    <input type="text" disabled class="form-control" value="<?= $course['course_title'] ?>">
                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Meeting</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="mentor_name" class="form-label">Nama Mentor</label>
                    <input type="text" name="mentor_name" id="mentor_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Durasi (jj:mm)</label>
                    <input type="text" name="duration" id="duration" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Urutan</label>
                    <input type="number" name="order" id="order" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>


<?php $this->endSection() ?>
<!-- END Content Section -->