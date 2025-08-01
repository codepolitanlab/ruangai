<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <form method="post" action="/<?= isset($course) ? urlScope() . '/course/form?id=' . $course->id : urlScope() . '/course/form' ?>">
            <div class="mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><a href="/<?= urlScope() ?>/course"><?= $page_title ?></a> • <?= isset($course) ? 'Edit' : 'New' ?></h2>
                        <nav aria-label="breadcrumb" class="breadcrumb-header">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/course">Course</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-end">
                        <a href="/<?= urlScope() ?>/course" class="btn btn-secondary mb-0"><span class="bi bi-arrow-left"></span> Kembali</a>
                        <button type="submit" name="save" class="btn btn-success mb-0"><span class="bi bi-save"></span> Simpan</button>
                        <button type="submit" name="save_and_exit" value="1" class="btn btn-success mb-0"><span class="bi bi-door-closed"></span> Simpan dan Tutup</button>
                    </div>
                </div>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->get('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle py-2 px-3 h5">Konten Utama Course</div>
                        <div class="card-body">
                            <?php if (isset($course)): ?>
                                <input type="hidden" name="id" value="<?= $course->id ?>">
                            <?php endif; ?>

                            <div class="my-3">
                                <label for="course_title" class="form-label">Judul Course <span class="text-danger">*</span></label>
                                <input type="text" id="course_title" name="course_title" value="<?= old('course_title', $course->course_title ?? '') ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" id="slug" name="slug" value="<?= old('slug', $course->slug ?? '') ?>" class="form-control" placeholder="Akan dibuat otomatis jika kosong">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea name="description" id="description" class="form-control" rows="10"><?= old('description', $course->description ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="total_module" class="form-label">Total Module</label>
                                <input type="number" id="total_module" name="total_module" value="<?= old('total_module', $course->total_module ?? 0) ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle py-2 px-3 h5">Pengaturan</div>
                        <div class="card-body">
                            <div class="my-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="draft" <?= old('status', $course->status ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= old('status', $course->status ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="partner_id" class="form-label">Partner/Instructor</label>
                                <select name="partner_id" id="partner_id" class="form-select">
                                    <option value="">Pilih Partner..</option>
                                    <?php foreach ($partners as $partner): ?>
                                        <option value="<?= $partner->id ?>" <?= old('partner_id', $course->partner_id ?? '') === $partner->id ? 'selected' : '' ?>>
                                            <?= $partner->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="level" class="form-label">Level</label>
                                <select name="level" id="level" class="form-select">
                                    <option value="">Pilih Level..</option>
                                    <option value="beginner" <?= old('level', $course->level ?? '') === 'beginner' ? 'selected' : '' ?>>Beginner</option>
                                    <option value="intermediate" <?= old('level', $course->level ?? '') === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                                    <option value="advanced" <?= old('level', $course->level ?? '') === 'advanced' ? 'selected' : '' ?>>Advanced</option>
                                </select>
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="premium" id="premium" value="1" <?= old('premium', $course->premium ?? 0) === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="premium">Course Premium</label>
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="has_modules" id="has_modules" value="1" <?= old('has_modules', $course->has_modules ?? 0) === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="has_modules">Memiliki Modul</label>
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="has_live_sessions" id="has_live_sessions" value="1" <?= old('has_live_sessions', $course->has_live_sessions ?? 0) === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="has_live_sessions">Ada Sesi Live</label>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle py-2 px-3 h5">Media & Atribut</div>
                        <div class="card-body">
                            <div class="my-3">
                                <label class="form-label">Cover</label>
                                <div class="input-group">
                                    <input type="text" id="cover" name="cover" class="form-control" placeholder="Pilih gambar.." value="<?= old('cover', $course->cover ?? '') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumbnail</label>
                                <div class="input-group">
                                    <input type="text" id="thumbnail" name="thumbnail" class="form-control" placeholder="Pilih gambar.." value="<?= old('thumbnail', $course->thumbnail ?? '') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Landing URL</label>
                                <div class="input-group">
                                    <input type="text" id="landing_url" name="landing_url" class="form-control" placeholder="Link halaman landing / pendaftaran" value="<?= old('landing_url', $course->landing_url ?? '') ?>">
                                </div>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" value="<?= old('tags', $course->tags ?? '') ?>" class="form-control" placeholder="misal: php, codeigniter, web">
                            </div> -->
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" data-role="tagsinput" value="<?= old('tags', $course->tags ?? '') ?>" class="form-control">
                                <script>
                                    $(document).ready(function() {
                                        $("#tags").tagsinput({
                                            trimValue: true, // Menghapus spasi berlebih
                                            allowDuplicates: false // Mencegah duplikasi tags
                                        });
                                    });
                                </script>
                            </div>
                            <div class="mb-3">
                                <label for="group_whatsapp" class="form-label">Link Grup WhatsApp</label>
                                <input type="text" id="group_whatsapp" name="group_whatsapp" value="<?= old('group_whatsapp', $course->group_whatsapp ?? '') ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="course_order" class="form-label">Urutan Course</label>
                                <input type="number" id="course_order" name="course_order" value="<?= old('course_order', $course->course_order ?? 0) ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="current_batch_id" class="form-label">Batch Saat Ini</label>
                                <input type="number" id="current_batch_id" name="current_batch_id" value="<?= old('current_batch_id', $course->current_batch_id ?? 0) ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="bunny_collection_id" class="form-label">Bunny Collection</label>
                                <input type="number" id="bunny_collection_id" name="bunny_collection_id" value="<?= old('bunny_collection_id', $course->bunny_collection_id ?? 0) ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <?php if (isset($course)): ?>
                            <button type="button" class="btn btn-danger mb-0" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <span class="bi bi-trash"></span> Hapus Course
                            </button>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success mb-0">
                            <span class="bi bi-save"></span> Simpan Course
                        </button>
                    </div>
                </div>
        </form>
        <?php if (isset($course)): ?>
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus course "<b><?= esc($course->course_title) ?></b>"? Tindakan ini tidak dapat dibatalkan.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form method="post" action="/<?= urlScope() ?>/course/form/delete" class="d-inline">
                                <input type="hidden" name="id" value="<?= $course->id ?>">
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<script>
    // Simple script to auto-generate slug from title for convenience
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('course_title');
        const slugInput = document.getElementById('slug');

        const slugify = text =>
            text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
            .replace(/\-\-+/g, '-'); // Replace multiple - with single -

        if (titleInput) {
            titleInput.addEventListener('keyup', (e) => {
                slugInput.value = slugify(e.target.value);
            });
        }
    });
</script>

<?php $this->endSection() ?>