<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<?php
// Ikon & label pendek per tipe resource (dipakai di daftar materi & preview)
$resourceTypeIcons = [
    'text'       => 'bi-file-text',
    'video'      => 'bi-play-circle',
    'pdf'        => 'bi-file-earmark-pdf',
    'slide'      => 'bi-easel',
    'audio'      => 'bi-music-note-beamed',
    'url'        => 'bi-link-45deg',
    'book_ref'   => 'bi-book',
    'quiz'       => 'bi-patch-question',
    'submission' => 'bi-upload',
    'meeting'    => 'bi-camera-video',
];
$resourceTypeShortLabels = [
    'text'       => 'Text',
    'video'      => 'Video',
    'pdf'        => 'PDF',
    'slide'      => 'Slide',
    'audio'      => 'Audio',
    'url'        => 'URL',
    'book_ref'   => 'Buku',
    'quiz'       => 'Kuis',
    'submission' => 'Tugas',
    'meeting'    => 'Meeting',
];
?>

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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resourceModal"
                    onclick="materialResourceOpen()">
                    <i class="bi bi-plus"></i> Tambah Resource
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- LEFT PANEL: Daftar Materi -->
        <div class="col-lg-5">
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
                                    <div class="fw-bold">
                                        <a href="javascript:void(0)" class="text-decoration-none" title="Klik untuk preview"
                                            onclick="materialPreview(<?= (int) $material['id'] ?>)"><?= esc($material['title']) ?></a>
                                        <span class="badge text-bg-light border ms-1"><?= esc($material['scoring_type']) ?></span>
                                        <span class="badge text-bg-light border">W: <?= (int) $material['weight'] ?></span>
                                    </div>
                                    <small class="text-muted"><?= esc($material['subtitle']) ?> · <?= count($material['resources']) ?> resource</small>
                                </div>
                                <div class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-outline-success" title="Tambah resource"
                                        data-bs-toggle="modal" data-bs-target="#resourceModal"
                                        onclick="materialSelectResource(<?= (int) $material['id'] ?>)"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                            <div class="p-2" style="background:#f8f9fa">
                                <?php if (empty($material['resources'])) : ?>
                                    <small class="text-muted ps-2">Tidak ada resource.</small>
                                <?php endif; ?>
                                <?php foreach ($material['resources'] as $ri => $resource) : ?>
                                    <div class="d-flex align-items-center border-bottom py-1 ps-2">
                                        <span class="me-2" title="<?= esc($resource['type']) ?>">
                                            <i class="bi <?= $resourceTypeIcons[$resource['type']] ?? 'bi-question-circle' ?> me-1"></i>
                                        </span>
                                        <span class="flex-grow-1 small">
                                            <a href="javascript:void(0)" class="text-decoration-none" title="Klik untuk preview"
                                                onclick="resourcePreview(<?= (int) $material['id'] ?>, <?= (int) $resource['id'] ?>)"><?= esc($resource['title']) ?></a>
                                            <?php if ($resource['is_required']) : ?><span class="badge text-bg-warning">wajib</span><?php endif; ?>
                                            <?php if (! $resource['need_review']) : ?><span class="badge text-bg-success">auto-acc</span><?php endif; ?>
                                        </span>
                                        <div class="text-nowrap">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" title="Naikkan urutan"
                                                onclick="resourceMove(<?= (int) $material['id'] ?>, <?= (int) $resource['id'] ?>, 'up')"
                                                <?= $ri === 0 ? 'disabled' : '' ?>><i class="bi bi-arrow-up-short"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" title="Turunkan urutan"
                                                onclick="resourceMove(<?= (int) $material['id'] ?>, <?= (int) $resource['id'] ?>, 'down')"
                                                <?= $ri === count($material['resources']) - 1 ? 'disabled' : '' ?>><i class="bi bi-arrow-down-short"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: Preview Materi & Resource -->
        <div class="col-lg-7">
            <div class="card card-block rounded-xl shadow sticky-top" style="top:20px">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong><i class="bi bi-eye me-1"></i> Preview</strong>
                </div>
                <div class="card-body" id="previewArea">
                    <div id="previewEmpty" class="text-center text-muted small py-5">
                        <i class="bi bi-mouse fs-3 d-block mb-2"></i>
                        Klik judul <strong>materi</strong> atau <strong>resource</strong> di daftar kiri untuk melihat preview.
                    </div>
                    <div id="previewContent" style="display:none"></div>
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
            <form method="POST" id="resourceForm" action="" onsubmit="return materialResourceSubmit(this)">
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
const MATERIALS = <?= json_encode($materials, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

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
    // Action dibangun saat submit (lihat materialResourceSubmit) agar selalu
    // menyertakan material_id yang valid — tombol "Resource Baru" dibuka
    // tanpa material terpilih, sehingga URL tidak boleh di-hardcode di sini.
    const mid = materialId || document.getElementById('resource_material_id').value;
    form.action = URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID + '/materials/' + (mid || '') + '/resources/store';
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

/**
 * Bangun URL submit resource berdasarkan materi & mode (store/update)
 * yang dipilih saat ini. Dipanggil dari onsubmit #resourceForm.
 */
function materialResourceSubmit(form) {
    const materialId = document.getElementById('resource_material_id').value;
    const resourceId = document.getElementById('resource_id').value;
    const type = document.getElementById('resource_type').value;

    if (!materialId) {
        alert('Silakan pilih materi terlebih dahulu.');
        return false;
    }

    // Final guard: hanya field konten dari tipe aktif yang ikut terkirim.
    // Mencegah tabrakan name duplikat (name="url" di blok video & url,
    // name="file_path" di blok pdf & audio, name="duration" di video/audio/meeting)
    // yang membuat PHP mengambil nilai kosong dari blok terakhir.
    document.querySelectorAll('#resourceModal [data-type]').forEach(el => {
        const isActive = el.dataset.type === type;
        el.querySelectorAll('.content-field').forEach(field => { field.disabled = !isActive; });
    });

    form.action = URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID
        + '/materials/' + materialId
        + '/resources/' + (resourceId ? resourceId + '/update' : 'store');

    return true;
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
    // Scope pencarian ke blok tipe aktif agar tidak salah isi pada input
    // dengan name duplikat (mis. name="url" ada di blok video DAN blok url).
    const typeBlock = document.querySelector(`#resourceModal [data-type="${resource.type}"]`);
    (map[resource.type] || []).forEach(key => {
        const el = typeBlock ? typeBlock.querySelector(`[name="${key}"]`) : null;
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

const RESOURCE_TYPE_ICONS = {
    text: 'bi-file-text', video: 'bi-play-circle', pdf: 'bi-file-earmark-pdf',
    slide: 'bi-easel', audio: 'bi-music-note-beamed', url: 'bi-link-45deg',
    book_ref: 'bi-book', quiz: 'bi-patch-question', submission: 'bi-upload',
    meeting: 'bi-camera-video'
};

const RESOURCE_TYPE_SHORT = {
    text: 'Text', video: 'Video', pdf: 'PDF', slide: 'Slide', audio: 'Audio',
    url: 'URL', book_ref: 'Buku', quiz: 'Kuis', submission: 'Tugas', meeting: 'Meeting'
};

function materialResourceTypeChange() {
    const type = document.getElementById('resource_type').value;
    document.getElementById('resource_type_label').textContent = RESOURCE_TYPE_LABELS[type] || type;
    document.querySelectorAll('#resourceModal [data-type]').forEach(el => {
        const isActive = el.dataset.type === type;
        el.style.display = isActive ? '' : 'none';
        // Nonaktifkan field tipe lain agar tidak ikut terkirim saat submit
        // (menghindari name duplikat: url, file_path, duration).
        el.querySelectorAll('.content-field').forEach(field => { field.disabled = !isActive; });
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

// ==================== PREVIEW MATERI & RESOURCE ====================

function previewEsc(str) {
    if (str === null || str === undefined) return '';
    const div = document.createElement('div');
    div.textContent = String(str);
    return div.innerHTML;
}

function previewNl2br(str) {
    return String(str).replace(/\n/g, '<br>');
}

function showPreview(html) {
    document.getElementById('previewContent').innerHTML = html;
    document.getElementById('previewContent').style.display = '';
    document.getElementById('previewEmpty').style.display = 'none';
}

function materialPreview(materialId) {
    const m = (MATERIALS || []).find(x => parseInt(x.id, 10) === parseInt(materialId, 10));
    if (!m) return;

    const resources = m.resources || [];
    const html = `
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h5 class="mb-1">${previewEsc(m.title)}</h5>
                ${m.subtitle ? `<div class="text-muted small">${previewEsc(m.subtitle)}</div>` : ''}
            </div>
            <div class="text-nowrap">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#materialModal"
                    onclick="materialEditById(${m.id})"><i class="bi bi-pencil-square"></i> Edit</button>
                <form method="POST" action="${URL_SCOPE}/classroom/syllabuses/${SYLLABUS_ID}/materials/${m.id}/delete"
                    class="d-inline" onsubmit="return confirm('Hapus materi ini beserta seluruh resource-nya?')">
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
        <div class="mb-2">
            <span class="badge text-bg-light border">${previewEsc(m.scoring_type)}</span>
            <span class="badge text-bg-light border">W: ${parseInt(m.weight, 10) || 0}</span>
            <span class="badge text-bg-info">${resources.length} resource</span>
        </div>
        ${m.description ? `<div class="small mb-3 text-muted">${previewNl2br(previewEsc(m.description))}</div>` : ''}
    `;
    showPreview(html);
}

function resourcePreview(materialId, resourceId) {
    const m = (MATERIALS || []).find(x => parseInt(x.id, 10) === parseInt(materialId, 10));
    const r = m ? (m.resources || []).find(x => parseInt(x.id, 10) === parseInt(resourceId, 10)) : null;
    if (!m || !r) return;

    let content = {};
    try { content = JSON.parse(r.content || '{}'); } catch (e) {}

    const badges = [
        `<span class="badge text-bg-secondary" title="${previewEsc(r.type)}"><i class="bi ${RESOURCE_TYPE_ICONS[r.type] || 'bi-question-circle'} me-1"></i>${previewEsc(RESOURCE_TYPE_SHORT[r.type] || r.type)}</span>`,
        `<span class="badge text-bg-light border">${previewEsc(r.completion_criteria)}</span>`,
        r.is_required ? '<span class="badge text-bg-warning">wajib</span>' : '',
        !r.need_review ? '<span class="badge text-bg-success">auto-acc</span>' : ''
    ].filter(Boolean).join(' ');

    const html = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="small text-muted">
                <a href="javascript:void(0)" class="text-decoration-none" onclick="materialPreview(${m.id})">
                    <i class="bi bi-arrow-left"></i> ${previewEsc(m.title)}
                </a>
            </div>
            <div class="text-nowrap">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#resourceModal"
                    onclick="resourceEdit(${m.id}, ${r.id})"><i class="bi bi-pencil-square"></i> Edit</button>
                <form method="POST" action="${URL_SCOPE}/classroom/syllabuses/${SYLLABUS_ID}/materials/${m.id}/resources/${r.id}/delete"
                    class="d-inline" onsubmit="return confirm('Hapus resource ini?')">
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
        <h5 class="mb-1">${previewEsc(r.title)}</h5>
        <div class="mb-2">${badges}</div>
        ${resourceDetailRows(r.type, content)}
        ${content.instructions ? `<div class="alert alert-light border small mt-2 mb-0"><strong>Instruksi:</strong><br>${previewNl2br(previewEsc(content.instructions))}</div>` : ''}
    `;
    showPreview(html);
}

// Edit materi dari preview (membuka modal dengan data materi terpilih)
function materialEditById(materialId) {
    const m = (MATERIALS || []).find(x => parseInt(x.id, 10) === parseInt(materialId, 10));
    if (!m) return;
    materialEdit(m);
}

// Edit resource dari preview (membuka modal dengan data resource terpilih)
function resourceEdit(materialId, resourceId) {
    const m = (MATERIALS || []).find(x => parseInt(x.id, 10) === parseInt(materialId, 10));
    const r = m ? (m.resources || []).find(x => parseInt(x.id, 10) === parseInt(resourceId, 10)) : null;
    if (!m || !r) return;
    materialResourceEdit(materialId, r);
}

// Ubah posisi urutan resource (naik/turun) lalu simpan via endpoint reorder
function resourceMove(materialId, resourceId, direction) {
    const m = (MATERIALS || []).find(x => parseInt(x.id, 10) === parseInt(materialId, 10));
    if (!m) return;

    const list = (m.resources || []).slice();
    const idx = list.findIndex(r => parseInt(r.id, 10) === parseInt(resourceId, 10));
    if (idx < 0) return;

    const target = direction === 'up' ? idx - 1 : idx + 1;
    if (target < 0 || target >= list.length) return;

    [list[idx], list[target]] = [list[target], list[idx]];

    const orders = list.map(r => parseInt(r.id, 10));

    const body = new URLSearchParams();
    body.append('orders', JSON.stringify(orders));

    fetch(URL_SCOPE + '/classroom/syllabuses/' + SYLLABUS_ID + '/materials/' + materialId + '/resources/reorder', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body
    }).finally(() => location.reload());
}

function resourceDetailRows(type, content) {
    if (type === 'text') {
        return content.html
            ? `<div class="border rounded p-2 bg-light small mb-0">${content.html}</div>`
            : '<div class="text-muted small">Tidak ada konten.</div>';
    }

    const rows = [];
    const add = (label, val) => {
        if (val !== undefined && val !== null && val !== '') {
            rows.push({ label, val });
        }
    };

    switch (type) {
        case 'video': add('URL Video', content.url); add('Platform', content.platform); add('Durasi (menit)', content.duration); break;
        case 'pdf': add('File Path', content.file_path); break;
        case 'audio': add('File Path', content.file_path); add('Durasi (menit)', content.duration); break;
        case 'slide': add('Embed URL', content.embed_url); add('Provider', content.provider); break;
        case 'url': add('URL', content.url); add('Buka di', content.open_in); break;
        case 'book_ref':
            add('Judul Buku', content.book_title); add('Penulis', content.author); add('Bab', content.chapter);
            add('Halaman', content.page_start && content.page_end ? `${content.page_start}–${content.page_end}` : (content.page_start || content.page_end));
            add('ISBN', content.isbn);
            break;
        case 'quiz': add('Pass Score (%)', content.pass_score); add('Batas Waktu (menit)', content.time_limit_minutes); add('Maks Percobaan', content.max_attempts); break;
        case 'submission':
            add('Tipe Pengumpulan', content.submission_type); add('Deadline (hari)', content.deadline_offset_days);
            add('Allowed Types', content.allowed_types); add('Max Size (MB)', content.max_size_mb);
            break;
        case 'meeting': add('Deskripsi', content.description); add('Durasi (menit)', content.duration); add('Mode', content.mode); break;
    }

    return rows.length
        ? `<dl class="row mb-0">${rows.map(r => `<dt class="col-sm-5 small text-muted fw-normal">${previewEsc(r.label)}</dt><dd class="col-sm-7 small mb-1">${previewEsc(r.val)}</dd>`).join('')}</dl>`
        : '<div class="text-muted small">Tidak ada detail konten.</div>';
}
</script>

<?php $this->endSection() ?>
