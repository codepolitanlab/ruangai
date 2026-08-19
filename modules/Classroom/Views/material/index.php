<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Materi — <?= esc($syllabus['name']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/syllabuses">Silabus</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Materi</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/syllabuses" class="btn btn-outline-secondary"><span class="bi bi-arrow-left"></span> Kembali</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materialModal" onclick="materialResetForm()">
                    <i class="bi bi-plus"></i> Tambah Materi
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- LEFT PANEL: Daftar Materi -->
        <div class="col-lg-6">
            <div class="card card-block rounded-xl shadow">
                <div class="card-header"><strong>Daftar Materi</strong>
                    <span class="badge text-bg-info ms-2"><?= count($materials) ?> materi</span>
                </div>
                <div class="card-body p-2">
                    <?php if (empty($materials)) : ?>
                        <div class="text-center text-muted py-4">Belum ada materi. Tambahkan materi pertama.</div>
                    <?php endif; ?>

                    <?php foreach ($materials as $mi => $material) : ?>
                        <div class="border rounded mb-2">
                            <div class="d-flex align-items-center p-2 bg-light-subtle rounded">
                                <div class="me-2 text-muted" style="cursor:grab" title="Drag untuk reorder"><i class="bi bi-grip-vertical"></i></div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold"><?= esc($material['title']) ?>
                                        <span class="badge text-bg-light border ms-1"><?= esc($material['scoring_type']) ?></span>
                                        <span class="badge text-bg-light border">W: <?= (int) $material['weight'] ?></span>
                                    </div>
                                    <small class="text-muted"><?= esc($material['subtitle']) ?> · <?= count($material['resources']) ?> resource</small>
                                </div>
                                <div class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick='materialEdit(<?= json_encode($material, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' title="Edit materi"><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-success" title="Tambah resource"
                                        onclick="materialSelectResource(<?= (int) $material['id'] ?>)"><i class="bi bi-plus-lg"></i></button>
                                    <form method="POST" action="/<?= urlScope() ?>/classroom/syllabuses/<?= $syllabus['id'] ?>/materials/<?= $material['id'] ?>/delete"
                                        class="d-inline" onsubmit="return confirm('Hapus materi ini beserta seluruh resource-nya?')">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="p-2" style="background:#f8f9fa">
                                <?php if (empty($material['resources'])) : ?>
                                    <small class="text-muted ps-2">Tidak ada resource.</small>
                                <?php endif; ?>
                                <?php foreach ($material['resources'] as $ri => $resource) : ?>
                                    <div class="d-flex align-items-center border-bottom py-1 ps-2">
                                        <span class="badge text-bg-secondary me-2" style="width:90px"><?= esc($resource['type']) ?></span>
                                        <span class="flex-grow-1 small"><?= esc($resource['title']) ?>
                                            <?php if ($resource['is_required']) : ?><span class="badge text-bg-warning">wajib</span><?php endif; ?>
                                            <?php if (! $resource['need_review']) : ?><span class="badge text-bg-success">auto-acc</span><?php endif; ?>
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick='materialResourceEdit(<?= (int) $material['id'] ?>, <?= json_encode($resource, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'><i class="bi bi-pencil-square"></i></button>
                                        <form method="POST" action="/<?= urlScope() ?>/classroom/syllabuses/<?= $syllabus['id'] ?>/materials/<?= $material['id'] ?>/resources/<?= $resource['id'] ?>/delete"
                                            class="d-inline" onsubmit="return confirm('Hapus resource ini?')">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: Info / Form Resource -->
        <div class="col-lg-6">
            <div class="card card-block rounded-xl shadow sticky-top" style="top:20px">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Tambah / Edit Resource</strong>
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#resourceModal"
                        onclick="materialResourceOpen()">
                        <i class="bi bi-plus"></i> Resource Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="text-muted small">
                        <p class="mb-1"><i class="bi bi-info-circle"></i> Resource adalah unit belajar dalam materi: video, PDF, kuis, tugas (submission), meeting, dan lain-lain.</p>
                        <p class="mb-0">Klik tombol <span class="bi bi-plus-lg"></span> di samping materi, atau "Resource Baru" di atas untuk membuka form dinamis.</p>
                    </div>
                    <hr>
                    <div class="alert alert-light border small">
                        <strong>Konten per tipe (JSON):</strong>
                        <ul class="mb-0">
                            <li><code>text</code> — html, instructions</li>
                            <li><code>video</code> — url, platform, duration</li>
                            <li><code>pdf/audio</code> — file_path, duration</li>
                            <li><code>slide</code> — embed_url, provider</li>
                            <li><code>url</code> — url, open_in</li>
                            <li><code>book_ref</code> — book_title, author, chapter, isbn</li>
                            <li><code>quiz</code> — pass_score, time_limit_minutes, max_attempts</li>
                            <li><code>submission</code> — submission_type, allowed_types, max_size_mb</li>
                            <li><code>meeting</code> — description, duration, mode</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Materi -->
<div class="modal fade" id="materialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="materialForm" action="/<?= urlScope() ?>/classroom/syllabuses/<?= $syllabus['id'] ?>/materials/store">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialModalTitle">Tambah Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="material_id">
                    <div class="mb-3">
                        <label class="form-label">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="material_title" class="form-control" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" id="material_subtitle" class="form-control" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="material_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Bobot Nilai (weight)</label>
                            <input type="number" name="weight" id="material_weight" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Tipe Penilaian</label>
                            <select name="scoring_type" id="material_scoring_type" class="form-select">
                                <option value="auto">Auto</option>
                                <option value="manual">Manual</option>
                            </select>
                        </div>
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

<!-- Modal Resource (dinamis per tipe) -->
<div class="modal fade modal-xl" id="resourceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="resourceForm" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="resourceModalTitle">Tambah Resource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="resource_id">
                    <div class="mb-3">
                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                        <select name="material_id" id="resource_material_id" class="form-select" required>
                            <option value="">— Pilih Materi —</option>
                            <?php foreach ($materials as $material) : ?>
                                <option value="<?= (int) $material['id'] ?>"><?= esc($material['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipe <span class="text-danger">*</span></label>
                            <select name="type" id="resource_type" class="form-select" onchange="materialResourceTypeChange()">
                                <option value="text">Text</option>
                                <option value="video">Video</option>
                                <option value="pdf">PDF</option>
                                <option value="slide">Slide</option>
                                <option value="audio">Audio</option>
                                <option value="url">URL / Tautan</option>
                                <option value="book_ref">Referensi Buku</option>
                                <option value="quiz">Kuis</option>
                                <option value="submission">Tugas / Submission</option>
                                <option value="meeting">Meeting / Tatap Muka</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Judul Resource <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="resource_title" class="form-control" required maxlength="255">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kriteria Selesai</label>
                            <select name="completion_criteria" id="resource_completion_criteria" class="form-select">
                                <option value="view">View (Dilihat)</option>
                                <option value="submit">Submit (Dikumpul)</option>
                                <option value="score_pass">Score Pass (Lulus Nilai)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Wajib</label>
                            <select name="is_required" id="resource_is_required" class="form-select">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Perlu Review</label>
                            <select name="need_review" id="resource_need_review" class="form-select">
                                <option value="1">Ya</option>
                                <option value="0">Tidak (auto-accept)</option>
                            </select>
                        </div>
                    </div>

                    <div class="border rounded p-3 bg-light-subtle">
                        <div class="fw-bold small mb-2 text-muted">Konten Tipe: <span id="resource_type_label">Text</span></div>

                        <!-- text -->
                        <div data-type="text">
                            <div class="mb-2">
                                <label class="form-label">HTML Konten</label>
                                <textarea name="html" class="form-control content-field" rows="5"></textarea>
                            </div>
                        </div>

                        <!-- video & url -->
                        <div data-type="video" style="display:none">
                            <div class="row">
                                <div class="col-8 mb-2">
                                    <label class="form-label">URL Video</label>
                                    <input type="text" name="url" class="form-control content-field">
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="form-label">Platform</label>
                                    <select name="platform" class="form-select content-field">
                                        <option value="youtube">YouTube</option>
                                        <option value="vimeo">Vimeo</option>
                                        <option value="bunny">Bunny</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Durasi (menit)</label>
                                <input type="number" name="duration" class="form-control content-field">
                            </div>
                        </div>

                        <!-- pdf & audio -->
                        <div data-type="pdf" style="display:none">
                            <div class="mb-2">
                                <label class="form-label">File Path / URL PDF</label>
                                <input type="text" name="file_path" class="form-control content-field">
                            </div>
                        </div>
                        <div data-type="audio" style="display:none">
                            <div class="mb-2">
                                <label class="form-label">File Path / URL Audio</label>
                                <input type="text" name="file_path" class="form-control content-field">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Durasi (menit)</label>
                                <input type="number" name="duration" class="form-control content-field">
                            </div>
                        </div>

                        <!-- slide -->
                        <div data-type="slide" style="display:none">
                            <div class="mb-2">
                                <label class="form-label">Embed URL</label>
                                <input type="text" name="embed_url" class="form-control content-field">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Provider</label>
                                <input type="text" name="provider" class="form-control content-field" placeholder="Google Slides, Canva, dll">
                            </div>
                        </div>

                        <!-- url -->
                        <div data-type="url" style="display:none">
                            <div class="row">
                                <div class="col-8 mb-2">
                                    <label class="form-label">URL</label>
                                    <input type="text" name="url" class="form-control content-field">
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="form-label">Buka di</label>
                                    <select name="open_in" class="form-select content-field">
                                        <option value="tab">Tab Baru</option>
                                        <option value="frame">Frame / iframe</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- book_ref -->
                        <div data-type="book_ref" style="display:none">
                            <div class="row">
                                <div class="col-6 mb-2"><label class="form-label">Judul Buku</label><input type="text" name="book_title" class="form-control content-field"></div>
                                <div class="col-6 mb-2"><label class="form-label">Penulis</label><input type="text" name="author" class="form-control content-field"></div>
                                <div class="col-4 mb-2"><label class="form-label">Bab</label><input type="text" name="chapter" class="form-control content-field"></div>
                                <div class="col-4 mb-2"><label class="form-label">Halaman Awal</label><input type="number" name="page_start" class="form-control content-field"></div>
                                <div class="col-4 mb-2"><label class="form-label">Halaman Akhir</label><input type="number" name="page_end" class="form-control content-field"></div>
                                <div class="col-6 mb-2"><label class="form-label">ISBN</label><input type="text" name="isbn" class="form-control content-field"></div>
                            </div>
                        </div>

                        <!-- quiz -->
                        <div data-type="quiz" style="display:none">
                            <div class="row">
                                <div class="col-4 mb-2"><label class="form-label">Pass Score (%)</label><input type="number" name="pass_score" class="form-control content-field" value="70"></div>
                                <div class="col-4 mb-2"><label class="form-label">Batas Waktu (menit, 0=tanpa batas)</label><input type="number" name="time_limit_minutes" class="form-control content-field" value="0"></div>
                                <div class="col-4 mb-2"><label class="form-label">Maks Percobaan</label><input type="number" name="max_attempts" class="form-control content-field" value="1"></div>
                            </div>
                        </div>

                        <!-- submission -->
                        <div data-type="submission" style="display:none">
                            <div class="row">
                                <div class="col-4 mb-2">
                                    <label class="form-label">Tipe Pengumpulan</label>
                                    <select name="submission_type" class="form-control content-field" onchange="materialSubmissionTypeChange()">
                                        <option value="upload">Upload File</option>
                                        <option value="url">URL</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2"><label class="form-label">Deadline Offset (hari)</label><input type="number" name="deadline_offset_days" class="form-control content-field"></div>
                                <div class="col-4 mb-2" data-submission-upload><label class="form-label">Max Size (MB)</label><input type="number" name="max_size_mb" class="form-control content-field" value="10"></div>
                                <div class="col-12 mb-2" data-submission-upload><label class="form-label">Allowed Types (comma)</label><input type="text" name="allowed_types" class="form-control content-field" placeholder="pdf, docx, zip, png, jpg"></div>
                            </div>
                        </div>

                        <!-- meeting -->
                        <div data-type="meeting" style="display:none">
                            <div class="row">
                                <div class="col-6 mb-2"><label class="form-label">Deskripsi</label><input type="text" name="description" class="form-control content-field"></div>
                                <div class="col-3 mb-2"><label class="form-label">Durasi (menit)</label><input type="number" name="duration" class="form-control content-field"></div>
                                <div class="col-3 mb-2">
                                    <label class="form-label">Mode</label>
                                    <select name="mode" class="form-select content-field">
                                        <option value="offline">Offline</option>
                                        <option value="offline_online">Offline + Online</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Instruksi / Catatan Tambahan</label>
                            <textarea name="instructions" class="form-control content-field" rows="2"></textarea>
                        </div>
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
const URL_SCOPE = '/<?= urlScope() ?>';
const SYLLABUS_ID = <?= (int) $syllabus['id'] ?>;

function materialResetForm() {
    const form = document.getElementById('materialForm');
    form.action = URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID + '/materials/store';
    document.getElementById('materialModalTitle').textContent = 'Tambah Materi';
    form.reset();
    document.getElementById('material_weight').value = 0;
}

function materialEdit(material) {
    if (!material) return materialResetForm();
    const form = document.getElementById('materialForm');
    form.action = URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID + '/materials/' + material.id + '/update';
    document.getElementById('materialModalTitle').textContent = 'Edit Materi';
    document.getElementById('material_id').value = material.id;
    document.getElementById('material_title').value = material.title || '';
    document.getElementById('material_subtitle').value = material.subtitle || '';
    document.getElementById('material_description').value = material.description || '';
    document.getElementById('material_weight').value = material.weight || 0;
    document.getElementById('material_scoring_type').value = material.scoring_type || 'auto';
}

function materialResourceOpen(materialId = null) {
    const form = document.getElementById('resourceForm');
    form.action = URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID + '/materials/' + (materialId || '') + '/resources/store';
    document.querySelectorAll('#resourceModal .content-field').forEach(el => el.value = '');
    document.getElementById('resource_completion_criteria').value = 'view';
    document.getElementById('resource_is_required').value = '1';
    document.getElementById('resource_need_review').value = '1';
    document.getElementById('resourceModalTitle').textContent = 'Tambah Resource';
    document.getElementById('resource_id').value = '';
    document.getElementById('resource_type').value = 'text';
    document.getElementById('resource_title').value = '';
    if (materialId) document.getElementById('resource_material_id').value = materialId;
    materialResourceTypeChange();
}

function materialSelectResource(materialId) {
    document.getElementById('resource_material_id').value = materialId;
    materialResourceOpen(materialId);
}

function materialResourceEdit(materialId, resource) {
    materialResourceOpen();
    const form = document.getElementById('resourceForm');
    form.action = URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID + '/materials/' + resource.material_id + '/resources/' + resource.id + '/update';
    document.getElementById('resourceModalTitle').textContent = 'Edit Resource';
    document.getElementById('resource_id').value = resource.id;
    document.getElementById('resource_material_id').value = resource.material_id;
    document.getElementById('resource_type').value = resource.type || 'text';
    document.getElementById('resource_title').value = resource.title || '';
    document.getElementById('resource_completion_criteria').value = resource.completion_criteria || 'view';
    document.getElementById('resource_is_required').value = resource.is_required ? '1' : '0';
    document.getElementById('resource_need_review').value = resource.need_review ? '1' : '0';

    let content = {};
    try { content = JSON.parse(resource.content || '{}'); } catch (e) {}
    const map = {
        text: ['html'], video: ['url', 'platform', 'duration'], pdf: ['file_path'],
        audio: ['file_path', 'duration'], slide: ['embed_url', 'provider'],
        url: ['url', 'open_in'], book_ref: ['book_title', 'author', 'chapter', 'page_start', 'page_end', 'isbn'],
        quiz: ['pass_score', 'time_limit_minutes', 'max_attempts'],
        submission: ['submission_type', 'deadline_offset_days', 'allowed_types', 'max_size_mb'],
        meeting: ['description', 'duration', 'mode']
    };
    (map[resource.type] || []).forEach(key => {
        const el = document.querySelector(`#resourceModal [name="${key}"]`);
        if (el && content[key] !== undefined) el.value = content[key];
    });
    const instr = document.querySelector('#resourceModal [name=instructions]');
    if (instr && content.instructions !== undefined) instr.value = content.instructions;
    materialResourceTypeChange();
}

const RESOURCE_TYPE_LABELS = {
    text: 'Text', video: 'Video', pdf: 'PDF', slide: 'Slide', audio: 'Audio',
    url: 'URL / Tautan', book_ref: 'Referensi Buku', quiz: 'Kuis',
    submission: 'Tugas / Submission', meeting: 'Meeting / Tatap Muka'
};

function materialResourceTypeChange() {
    const type = document.getElementById('resource_type').value;
    document.getElementById('resource_type_label').textContent = RESOURCE_TYPE_LABELS[type] || type;
    document.querySelectorAll('#resourceModal [data-type]').forEach(el => {
        el.style.display = el.dataset.type === type ? '' : 'none';
    });
    materialSubmissionTypeChange();
}

function materialSubmissionTypeChange() {
    const st = document.querySelector('#resourceModal [name=submission_type]');
    const isUpload = !st || st.value === 'upload';
    document.querySelectorAll('#resourceModal [data-submission-upload]').forEach(el => {
        el.style.display = isUpload ? '' : 'none';
    });
}
</script>

<?php $this->endSection() ?>
