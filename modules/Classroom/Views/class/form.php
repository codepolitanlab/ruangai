<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<?php
$isEdit    = ! empty($class);
$selectedRequirement = [];
if ($isEdit && ! empty($class['certificate_requirement'])) {
    $selectedRequirement = array_map('trim', explode(',', $class['certificate_requirement']));
}
?>

<div class="page-heading" x-data="classForm(<?= $isEdit ? 'true' : 'false' ?>)" x-init="init()">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $isEdit ? 'Edit Kelas' : 'Buat Kelas' ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $isEdit ? 'Edit' : 'Buat' ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $isEdit ? $class['id'] . '/update' : 'store' ?>">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-block rounded-xl shadow">
                        <div class="card-header"><strong>Informasi Kelas</strong></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Silabus <span class="text-danger">*</span></label>
                                <select name="syllabus_id" id="syllabus_id" class="form-select" required
                                    <?= $isEdit ? 'disabled' : '' ?> @change="loadResources()">
                                    <option value="">— Pilih Silabus (published) —</option>
                                    <?php foreach ($syllabuses as $s) : ?>
                                        <option value="<?= (int) $s['id'] ?>" <?= $isEdit && (int) $class['syllabus_id'] === (int) $s['id'] ? 'selected' : '' ?>>
                                            <?= esc($s['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($isEdit) : ?>
                                    <input type="hidden" name="syllabus_id" value="<?= (int) $class['syllabus_id'] ?>">
                                    <small class="text-muted">Silabus tidak dapat diubah setelah kelas dibuat.</small>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required maxlength="255"
                                    value="<?= esc($class['name'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumbnail URL</label>
                                <input type="text" name="thumbnail" class="form-control" maxlength="500"
                                    value="<?= esc($class['thumbnail'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4"><?= esc($class['description'] ?? '') ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control" value="<?= esc($class['start_date'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Link Grup WhatsApp</label>
                                    <input type="text" name="whatsapp_group_url" class="form-control" maxlength="500"
                                        value="<?= esc($class['whatsapp_group_url'] ?? '') ?>">
                                </div>
                            </div>
                            <?php if ($isEdit) : ?>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="draft" <?= $class['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="active" <?= $class['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="archived" <?= $class['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                                    </select>
                                    <small class="text-muted">Aktivasi (draft → active) diblokir jika ada materi belum ter-sync atau belum dijadwalkan.</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card card-block rounded-xl shadow mt-3">
                        <div class="card-header"><strong>Pengaturan Sertifikat</strong></div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="certificate_claimable" id="certificate_claimable" value="1"
                                    <?= ! empty($class['certificate_claimable']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="certificate_claimable">Sertifikat siap diklaim member</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="required_feedback_before_claim_certificate" id="required_feedback" value="1"
                                    <?= ! empty($class['required_feedback_before_claim_certificate']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="required_feedback">Wajib isi feedback sebelum klaim sertifikat</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Resource Tugas (Submission) Wajib untuk Klaim</label>
                                <div id="certificate_resources" class="border rounded p-2" style="max-height:240px;overflow:auto">
                                    <?php if (! empty($certificateResources)) : ?>
                                        <?php foreach ($certificateResources as $r) : ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="certificate_requirement[]" value="<?= (int) $r['id'] ?>"
                                                    id="cert_req_<?= (int) $r['id'] ?>"
                                                    <?= in_array((string) $r['id'], $selectedRequirement, true) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="cert_req_<?= (int) $r['id'] ?>">
                                                    [<?= esc($r['material_title']) ?>] <?= esc($r['title']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <small class="text-muted">Tidak ada resource submission. Silakan pilih silabus yang memiliki tugas (submission).</small>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted">Semua resource yang dicentang wajib berstatus completed sebelum member bisa klaim sertifikat.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-block rounded-xl shadow sticky-top" style="top:20px">
                        <div class="card-header"><strong>Simpan</strong></div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-save"></i> Simpan Kelas</button>
                            <a href="/<?= urlScope() ?>/classroom/classes" class="btn btn-outline-secondary w-100">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<script>
function classForm(isEdit) {
    return {
        init() {
            // Saat edit, resource sudah di-render server (termasuk state centang) — jangan timpa
            if (!isEdit) {
                this.loadResources();
            }
        },
        loadResources() {
            const id = document.getElementById('syllabus_id').value;
            const container = document.getElementById('certificate_resources');
            if (!id) {
                container.innerHTML = '<small class="text-muted">Pilih silabus untuk melihat resource submission.</small>';
                return;
            }
            fetch('/<?= urlScope() ?>/classroom/classes/resources?syllabus_id=' + id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    if (!data || !data.length) {
                        container.innerHTML = '<small class="text-muted">Tidak ada resource submission pada silabus ini.</small>';
                        return;
                    }
                    container.innerHTML = data.map(r =>
                        '<div class="form-check">' +
                        '<input class="form-check-input" type="checkbox" name="certificate_requirement[]" value="' + r.id + '" id="cert_req_' + r.id + '">' +
                        '<label class="form-check-label" for="cert_req_' + r.id + '">[' + this.esc(r.material_title) + '] ' + this.esc(r.title) + '</label>' +
                        '</div>'
                    ).join('');
                });
        },
        esc(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
    };
}
</script>

<?php $this->endSection() ?>
