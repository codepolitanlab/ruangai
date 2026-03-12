<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Challenge CSV Importer</h3>
                <p class="text-subtitle text-muted">Import data peserta dari platform eksternal</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('ruangpanel/challenge/submissions') ?>">Challenge</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Importer</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <!-- Upload Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Upload File CSV</h5>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('warning')): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('warning') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('ruangpanel/challenge/importer/process') ?>" method="post" enctype="multipart/form-data" id="importForm">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Pilih File CSV <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                                <div class="form-text">
                                    Format file: CSV (Comma Separated Values). Maksimal 10MB.
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <strong><i class="bi bi-info-circle"></i> Catatan Penting:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>File CSV harus memiliki header sesuai template</li>
                                    <li>Email yang sudah terdaftar tidak akan dibuat ulang</li>
                                    <li>Password default untuk user baru: <code>BelajarAI@2026</code></li>
                                    <li>Kolom <code>source</code> akan digunakan sebagai sumber registrasi</li>
                                    <li>Province dan City ID akan dikonversi ke nama</li>
                                    <li>User otomatis didaftarkan ke beasiswa & course</li>
                                    <li>Proses import menggunakan database transaction</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-upload"></i> Upload & Process
                                </button>
                                <a href="<?= site_url('ruangpanel/challenge/importer/download-template') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download Template
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Panduan Import</h5>
                    </div>
                    <div class="card-body">
                        <h6>Langkah-langkah:</h6>
                        <ol>
                            <li>Download template CSV</li>
                            <li>Isi data sesuai format</li>
                            <li>Upload file CSV</li>
                            <li>Tunggu proses selesai</li>
                        </ol>

                        <hr>

                        <h6>Pengaturan Otomatis:</h6>
                        <ul class="list-unstyled small">
                            <li><strong>Challenge ID:</strong> <code>wan-vision-clash-2025</code></li>
                            <li><strong>Program Beasiswa:</strong> <code>RuangAI2026WSGenAI</code></li>
                            <li><strong>Course ID:</strong> <code>1</code> (Otomatis enrolled)</li>
                            <li><strong>Status:</strong> <code>pending</code> (Challenge)</li>
                        </ul>

                        <hr>

                        <h6>Data yang Diproses:</h6>
                        <ul class="small">
                            <li>✓ User account (login credentials)</li>
                            <li>✓ User profile (data pribadi)</li>
                            <li>✓ Challenge participation</li>
                            <li>✓ Scholarship registration</li>
                            <li>✓ Course enrollment (Course ID: 1)</li>
                        </ul>

                        <div class="alert alert-warning mt-3">
                            <small>
                                <strong>Perhatian:</strong> Kolom <code>program</code> dari CSV akan disimpan 
                                sebagai <code>prev_chapter</code> untuk referensi historis.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>

<!-- START Script Section -->
<?php $this->section('script') ?>
<script>
    // Show loading on form submit
    document.getElementById('importForm').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    });
</script>
<?php $this->endSection() ?>
