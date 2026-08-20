<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<?php $isEdit = ! empty($work); ?>

<div class="page-heading" x-data="workForm(<?= $isEdit ? (int) $work['id'] : 0 ?>)">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $isEdit ? 'Edit Karya' : 'Buat Karya' ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/memberworks">Karya Member</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $isEdit ? 'Edit' : 'Buat' ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <form method="POST" action="/<?= urlScope() ?>/classroom/memberworks/<?= $isEdit ? $work['id'] . '/update' : 'store' ?>">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-block rounded-xl shadow">
                        <div class="card-header"><strong>Informasi Karya</strong></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required maxlength="255" value="<?= esc($work['title'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat <small class="text-muted">(maks 500 karakter)</small></label>
                                <input type="text" name="short_description" class="form-control" maxlength="500" value="<?= esc($work['short_description'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea name="description" class="form-control" rows="6"><?= esc($work['description'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumbnail URL</label>
                                <input type="text" name="thumbnail" class="form-control" value="<?= esc($work['thumbnail'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL Project</label>
                                <input type="text" name="url_project" class="form-control" value="<?= esc($work['url_project'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Galeri (daftar URL gambar)</label>
                                <template x-for="(photo, idx) in photos" :key="idx">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="photos[]" x-model="photos[idx]" placeholder="https://.../gambar.jpg">
                                        <button type="button" class="btn btn-outline-danger" @click="photos.splice(idx,1)"><i class="bi bi-trash"></i></button>
                                    </div>
                                </template>
                                <button type="button" class="btn btn-sm btn-outline-primary" @click="photos.push('')"><i class="bi bi-plus"></i> Tambah Foto</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-block rounded-xl shadow">
                        <div class="card-header"><strong>Status &amp; Pemilik</strong></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="pending" <?= ($work['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="published" <?= ($work['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                    <option value="rejected" <?= ($work['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ID Pemilik (user_id)</label>
                                <input type="number" name="user_id" class="form-control" value="<?= (int) ($work['user_id'] ?? user_id()) ?>">
                                <small class="text-muted">Kosongkan untuk memakai user yang sedang login.</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-save"></i> Simpan</button>
                            <a href="/<?= urlScope() ?>/classroom/memberworks" class="btn btn-outline-secondary w-100">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<script>
function workForm(id) {
    return {
        photos: <?= $isEdit ? json_encode($photos ?? []) : '[""]' ?>,
    };
}
</script>

<?php $this->endSection() ?>
