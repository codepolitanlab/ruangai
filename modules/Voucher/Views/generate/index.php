<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<?php $vBase = '/' . urlScope() . '/voucher'; ?>

<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= admin_url() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $vBase ?>/sales">Vouchers</a></li>
                        <li class="breadcrumb-item" aria-current="page">Generate</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="<?= $vBase ?>/sales" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">

            <!-- Form Column -->
            <div class="col-lg-6">
                <div class="card rounded-xl shadow">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-ticket-perforated me-2"></i>Form Generate Voucher</h5>
                    </div>
                    <div class="card-body">

                        <div id="alertResult" class="alert d-none mb-3"></div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipe Voucher <span class="text-danger">*</span></label>
                            <select id="voucher_type" class="form-select">
                                <option value="course">Online Course</option>
                                <option value="bootcamp">Bootcamp (Kelas)</option>
                            </select>
                        </div>

                        <div class="mb-3" id="courseField">
                            <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                            <select id="course_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"
                                        data-has-live="<?= $course['has_live_sessions'] ?>">
                                        <?= esc($course['course_title']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="bootcampField">
                            <label class="form-label fw-bold">Kelas Bootcamp <span class="text-danger">*</span></label>
                            <select id="class_id" class="form-select" required>
                                <option value="">-- Pilih Kelas Bootcamp --</option>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?= $class['id'] ?>">
                                        <?= esc($class['name']) ?><?= ! empty($class['syllabus_name']) ? ' — ' . esc($class['syllabus_name']) : '' ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="form-text">Voucher kelas bootcamp akan memakai <code>object_type = bootcamp</code>.</div>
                        </div>

                        <div id="batchWrapper" class="mb-3 d-none">
                            <label class="form-label fw-bold">Batch <span class="text-danger">*</span></label>
                            <select id="live_batch_id" class="form-select">
                                <option value="0">-- Pilih Batch --</option>
                            </select>
                            <div class="form-text">Kelas ini memiliki live session. Pilih batch yang akan dimasukkan ke voucher.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <input type="text" id="gen_name" class="form-control" value="CODEPOLITAN" placeholder="Nama pemilik voucher">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" id="gen_email" class="form-control" value="codepolitan@gmail.com" placeholder="Email pemilik voucher">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">WhatsApp</label>
                            <input type="text" id="gen_phone" class="form-control" value="-" placeholder="Nomor WhatsApp">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Voucher <span class="text-danger">*</span></label>
                            <input type="number" id="gen_quantity" class="form-control" value="1" min="1" max="500" placeholder="Jumlah voucher">
                            <div class="form-text">Maksimal 500 voucher sekaligus.</div>
                        </div>

                        <div class="mb-3 p-3 bg-light rounded border">
                            <label class="form-label fw-bold text-muted small">Preview Metadata</label>
                            <pre id="metadataPreview" class="mb-0 small font-monospace">{"duration":"0","live_batch_id":"0"}</pre>
                        </div>

                        <button type="button" id="btnGenerate" class="btn btn-primary w-100">
                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                            <i class="bi bi-ticket-perforated me-1"></i> Generate Voucher
                        </button>

                    </div>
                </div>
            </div>

            <!-- Result Column -->
            <div class="col-lg-6">
                <div class="card rounded-xl shadow h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-list-check me-2"></i>Hasil Generate</h5>
                        <button type="button" id="btnCopy" class="btn btn-sm btn-outline-secondary d-none">
                            <i class="bi bi-clipboard"></i> Copy Semua
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="resultPlaceholder" class="text-center text-muted py-5">
                            <i class="bi bi-ticket-perforated fs-1 opacity-25"></i>
                            <p class="mt-2">Voucher yang digenerate akan muncul di sini.</p>
                        </div>
                        <div id="resultContent" class="d-none">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <span id="resultSummary" class="fw-bold text-success"></span>
                                <small id="resultErrors" class="text-danger d-none"></small>
                            </div>
                            <textarea id="resultCodes" class="form-control font-monospace" rows="18" readonly style="font-size: 0.85rem; resize: none;"></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    const VOUCHER_BASE = '<?= $vBase ?>';

    const typeSelect      = document.getElementById('voucher_type');
    const courseField     = document.getElementById('courseField');
    const courseSelect    = document.getElementById('course_id');
    const bootcampField   = document.getElementById('bootcampField');
    const classSelect     = document.getElementById('class_id');
    const batchWrapper    = document.getElementById('batchWrapper');
    const batchSelect     = document.getElementById('live_batch_id');
    const metadataPreview = document.getElementById('metadataPreview');

    function currentType() {
        return typeSelect.value === 'bootcamp' ? 'bootcamp' : 'course';
    }

    function toggleTypeFields() {
        const type = currentType();
        courseField.classList.toggle('d-none', type === 'bootcamp');
        bootcampField.classList.toggle('d-none', type === 'course');
        if (type === 'bootcamp') {
            batchWrapper.classList.add('d-none');
            batchSelect.innerHTML = '<option value="0">-- Pilih Batch --</option>';
        }
        updateMetadataPreview();
    }

    function updateMetadataPreview() {
        if (currentType() === 'bootcamp') {
            metadataPreview.textContent = JSON.stringify({ duration: '0' }, null, 2);
            return;
        }
        const batchId = batchWrapper.classList.contains('d-none') ? '0' : batchSelect.value;
        metadataPreview.textContent = JSON.stringify({ duration: '0', live_batch_id: String(batchId) }, null, 2);
    }

    typeSelect.addEventListener('change', toggleTypeFields);

    courseSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const hasLive  = selected.dataset.hasLive === '1';

        if (hasLive && this.value) {
            batchWrapper.classList.remove('d-none');
            batchSelect.innerHTML = '<option value="0">Memuat batch...</option>';

            fetch(VOUCHER_BASE + '/generate/batches?course_id=' + this.value, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(batches => {
                batchSelect.innerHTML = '<option value="0">-- Pilih Batch --</option>';
                batches.forEach(function(b) {
                    const opt = document.createElement('option');
                    opt.value = b.id;
                    opt.textContent = b.name;
                    batchSelect.appendChild(opt);
                });
                updateMetadataPreview();
            });
        } else {
            batchWrapper.classList.add('d-none');
            batchSelect.innerHTML = '<option value="0">-- Pilih Batch --</option>';
            updateMetadataPreview();
        }
    });

    batchSelect.addEventListener('change', updateMetadataPreview);

    document.getElementById('btnGenerate').addEventListener('click', function() {
        const type     = currentType();
        const objectId = type === 'bootcamp' ? classSelect.value : courseSelect.value;
        const batchId  = (type === 'course' && !batchWrapper.classList.contains('d-none')) ? batchSelect.value : '0';
        const name     = document.getElementById('gen_name').value;
        const email    = document.getElementById('gen_email').value;
        const phone    = document.getElementById('gen_phone').value;
        const quantity = document.getElementById('gen_quantity').value;
        const alertEl  = document.getElementById('alertResult');
        const spinner  = document.getElementById('btnSpinner');

        alertEl.className = 'alert d-none';

        if (!objectId) {
            alertEl.className = 'alert alert-danger';
            alertEl.textContent = 'Pilih kelas terlebih dahulu.';
            return;
        }

        spinner.classList.remove('d-none');
        this.disabled = true;

        const formData = new FormData();
        formData.append('object_type',   type);
        formData.append('object_id',     objectId);
        formData.append('live_batch_id', batchId);
        formData.append('name',          name);
        formData.append('email',         email);
        formData.append('phone',         phone);
        formData.append('quantity',      quantity);

        fetch(VOUCHER_BASE + '/generate/store', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            spinner.classList.add('d-none');
            document.getElementById('btnGenerate').disabled = false;

            if (data.success) {
                alertEl.className = 'alert alert-success';
                alertEl.innerHTML = data.message + ' &nbsp; <a href="' + VOUCHER_BASE + '/generated" class="alert-link">Lihat daftar voucher &rarr;</a>';

                document.getElementById('resultPlaceholder').classList.add('d-none');
                document.getElementById('resultContent').classList.remove('d-none');
                document.getElementById('resultSummary').textContent = data.message;
                document.getElementById('resultCodes').value = data.generated.join('\n');
                document.getElementById('btnCopy').classList.remove('d-none');

                if (data.errors && data.errors.length > 0) {
                    const errEl = document.getElementById('resultErrors');
                    errEl.textContent = data.errors.length + ' error(s)';
                    errEl.classList.remove('d-none');
                }
            } else {
                alertEl.className = 'alert alert-danger';
                alertEl.textContent = data.message;
            }
        })
        .catch(() => {
            spinner.classList.add('d-none');
            document.getElementById('btnGenerate').disabled = false;
            alertEl.className = 'alert alert-danger';
            alertEl.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
        });
    });

    document.getElementById('btnCopy').addEventListener('click', function() {
        const ta = document.getElementById('resultCodes');
        ta.select();
        navigator.clipboard.writeText(ta.value).then(() => {
            this.innerHTML = '<i class="bi bi-check2"></i> Tersalin!';
            setTimeout(() => { this.innerHTML = '<i class="bi bi-clipboard"></i> Copy Semua'; }, 2000);
        });
    });
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->
