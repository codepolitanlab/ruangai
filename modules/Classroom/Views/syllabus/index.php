<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Silabus</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Classroom / Silabus</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#syllabusModal"
                    onclick="openSyllabusModal()">
                    <i class="bi bi-plus"></i> Buat Silabus
                </button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="header-block header-block-search ps-1 mt-2 mb-2">
                <form method="GET" role="search" class="d-flex gap-2 flex-wrap align-items-center px-3 pt-2">
                    <div class="input-group" style="max-width: 320px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari silabus..."
                            value="<?= esc($search ?? '') ?>">
                        <button type="submit" class="btn btn-outline-primary"><span class="bi bi-search"></span></button>
                        <a href="/<?= urlScope() ?>/classroom/syllabuses" class="btn btn-outline-secondary"><span class="bi bi-arrow-repeat"></span></a>
                    </div>
                    <select name="status" class="form-select" style="max-width: 180px;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= ($status ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                </form>
            </div>

            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Silabus</th>
                            <th>Subtitle</th>
                            <th>Jml Materi</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($syllabuses)) : ?>
                            <?php foreach ($syllabuses as $i => $s) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <a href="/<?= urlScope() ?>/classroom/syllabuses/<?= $s['id'] ?>/materials" class="fw-bold text-decoration-none">
                                            <?= esc($s['name']) ?>
                                        </a>
                                    </td>
                                    <td class="text-muted"><?= esc($s['subtitle']) ?></td>
                                    <td><span class="badge text-bg-info"><?= (int) $s['material_count'] ?></span></td>
                                    <td>
                                        <?php if ($s['status'] === 'published') : ?>
                                            <span class="badge text-bg-success">Published</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-secondary">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $s['created_at'] ? date('d M Y', strtotime($s['created_at'])) : '-' ?></td>
                                    <td class="text-end text-nowrap">
                                        <a class="btn btn-sm btn-outline-secondary"
                                            href="/<?= urlScope() ?>/classroom/syllabuses/<?= $s['id'] ?>/materials"
                                            title="Kelola Materi"><span class="bi bi-list-check"></span></a>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit"
                                            onclick='openSyllabusModal(<?= json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                            <span class="bi bi-pencil-square"></span>
                                        </button>
                                        <form method="POST" action="/<?= urlScope() ?>/classroom/syllabuses/<?= $s['id'] ?>/duplicate"
                                            class="d-inline" onsubmit="return confirm('Duplikasi silabus ini beserta seluruh materi & resource?')">
                                            <button type="submit" class="btn btn-sm btn-outline-info" title="Duplikasi"><span class="bi bi-copy"></span></button>
                                        </form>
                                        <form method="POST" action="/<?= urlScope() ?>/classroom/syllabuses/<?= $s['id'] ?>/delete"
                                            class="d-inline" onsubmit="return confirm('Hapus silabus ini?')">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><span class="bi bi-trash"></span></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada silabus. Klik "Buat Silabus" untuk memulai.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal Buat/Edit Silabus -->
<div class="modal fade" id="syllabusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="syllabusForm" action="/<?= urlScope() ?>/classroom/syllabuses/store">
                <div class="modal-header">
                    <h5 class="modal-title" id="syllabusModalTitle">Buat Silabus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="syllabus_id">
                    <div class="mb-3">
                        <label class="form-label">Nama Silabus <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="syllabus_name" class="form-control" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" id="syllabus_subtitle" class="form-control" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="syllabus_description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="syllabus_status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                        <small class="text-muted">Silabus hanya bisa published jika memiliki minimal 1 materi.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openSyllabusModal(syllabus = null) {
    const form = document.getElementById('syllabusForm');
    const title = document.getElementById('syllabusModalTitle');

    if (syllabus) {
        title.textContent = 'Edit Silabus';
        form.action = '/<?= urlScope() ?>/classroom/syllabuses/' + syllabus.id + '/update';
        document.getElementById('syllabus_id').value = syllabus.id;
        document.getElementById('syllabus_name').value = syllabus.name || '';
        document.getElementById('syllabus_subtitle').value = syllabus.subtitle || '';
        document.getElementById('syllabus_description').value = syllabus.description || '';
        document.getElementById('syllabus_status').value = syllabus.status || 'draft';
    } else {
        title.textContent = 'Buat Silabus';
        form.action = '/<?= urlScope() ?>/classroom/syllabuses/store';
        form.reset();
        document.getElementById('syllabus_id').value = '';
    }
}
</script>

<?php $this->endSection() ?>
