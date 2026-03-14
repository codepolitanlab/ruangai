<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Challenge Submission Importer</h3>
                <p class="text-subtitle text-muted">Import data submission challenge dari CSV</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('ruangpanel/challenge/submissions') ?>">Challenge</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Submission Importer</li>
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
                        <h5 class="mb-0">Upload File CSV Submission</h5>
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

                        <form action="<?= site_url('ruangpanel/challenge/importer/process-submission') ?>" method="post" enctype="multipart/form-data" id="importForm">
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
                                    <li>Email harus sudah terdaftar di challenge_alibaba</li>
                                    <li>Data submission akan di-update berdasarkan email</li>
                                    <li>Status otomatis berubah ke <code>review</code> jika ada submission</li>
                                    <li>Field untuk <strong>user_profiles</strong>: alibaba_cloud_id, alibaba_cloud_screenshot</li>
                                    <li>Field untuk <strong>challenge_alibaba</strong>: twitter_post_url, video_title, video_category, video_description, other_tools</li>
                                    <li>Token <code>genaivideofest</code> akan di-generate otomatis untuk user yang berhasil</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-upload"></i> Upload & Sync
                                </button>
                                <a href="<?= site_url('ruangpanel/challenge/importer/download-submission-template') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download Template
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-3">
                    <a href="<?= site_url('ruangpanel/challenge/importer') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke User Import
                    </a>
                </div>
            </div>

            <!-- Instructions -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Panduan Import Submission</h5>
                    </div>
                    <div class="card-body">
                        <h6>Langkah-langkah:</h6>
                        <ol>
                            <li>Download template CSV</li>
                            <li>Isi data submission</li>
                            <li>Upload file CSV</li>
                            <li>Sistem akan sync data submission</li>
                        </ol>

                        <hr>

                        <h6>Format Header CSV (Tab-separated):</h6>
                        <div class="bg-dark text-light rounded p-2 mb-2" style="font-size:11px; word-break:break-all;">
                            <code class="text-warning">email</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">alibaba_cloud_id</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">alibaba_cloud_screenshot</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">twitter_post_url</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">video_title</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">video_category</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">video_description</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">other_tools</code>
                            <code class="text-muted">&nbsp;&nbsp;[TAB]&nbsp;&nbsp;</code>
                            <code class="text-warning">submitted_at</code>
                        </div>
                        <table class="table table-sm table-bordered small">
                            <thead class="table-dark">
                                <tr><th>Kolom</th><th>Keterangan</th></tr>
                            </thead>
                            <tbody>
                                <tr><td><code>email</code></td><td>Email peserta <span class="badge bg-danger">required</span></td></tr>
                                <tr><td><code>alibaba_cloud_id</code></td><td>ID Alibaba Cloud</td></tr>
                                <tr><td><code>alibaba_cloud_screenshot</code></td><td>URL screenshot</td></tr>
                                <tr><td><code>twitter_post_url</code></td><td>Link post Twitter/X</td></tr>
                                <tr><td><code>video_title</code></td><td>Judul video</td></tr>
                                <tr><td><code>video_category</code></td><td>Kategori video</td></tr>
                                <tr><td><code>video_description</code></td><td>Deskripsi video</td></tr>
                                <tr><td><code>other_tools</code></td><td>Tools AI lain yang digunakan</td></tr>
                                <tr><td><code>submitted_at</code></td><td>Waktu submit (format: Y-m-d H:i:s), jika kosong pakai waktu import</td></tr>
                            </tbody>
                        </table>

                        <hr>

                        <h6>Data akan di-update ke:</h6>
                        <ul class="small">
                            <li><strong>user_profiles</strong>:
                                <ul>
                                    <li>alibaba_cloud_id</li>
                                    <li>alibaba_cloud_screenshot</li>
                                </ul>
                            </li>
                            <li><strong>challenge_alibaba</strong>:
                                <ul>
                                    <li>twitter_post_url</li>
                                    <li>video_title</li>
                                    <li>video_category</li>
                                    <li>video_description</li>
                                    <li>other_tools</li>
                                    <li>status → <code>review</code></li>
                                </ul>
                            </li>
                        </ul>

                        <hr>

                        <h6>Bonus:</h6>
                        <ul class="small">
                            <li>✓ Token <code>genaivideofest</code> di-generate otomatis</li>
                            <li>✓ Token hanya dibuat 1x per user</li>
                        </ul>

                        <div class="alert alert-success mt-3">
                            <small>
                                <strong>Info:</strong> File CSV menggunakan format <strong>tab-separated</strong> (TSV).
                            </small>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <small>
                                <strong>Perhatian:</strong> Email yang tidak ditemukan akan di-skip. 
                                Pastikan user sudah di-import terlebih dahulu.
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
