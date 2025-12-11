<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<style>
.import-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.import-card h4 {
    color: white;
    margin-bottom: 5px;
}

.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    padding: 40px;
    text-align: center;
    background-color: #f8f9fa;
    transition: all 0.3s;
}

.upload-area:hover {
    border-color: #667eea;
    background-color: #e7f1ff;
}

.upload-area i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 20px;
}

.sample-format {
    background-color: #f8f9fa;
    border-left: 4px solid #667eea;
    padding: 15px;
    margin-top: 20px;
}

.sample-format code {
    background-color: #ffffff;
    padding: 2px 6px;
    border-radius: 3px;
}
</style>

<div class="page-heading">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Import Peserta Followup</h3>
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/scholarship/followup-comentors">Followup Comentor</a></li>
                    <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/scholarship/followup-comentors/<?= $comentor['id'] ?>/detail">Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Import</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first text-end">
            <a href="/<?= urlScope() ?>/scholarship/followup-comentors/<?= $comentor['id'] ?>/detail" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<section class="section">
    <!-- Info Comentor -->
    <div class="import-card">
        <div class="row">
            <div class="col-md-12">
                <h4><i class="bi bi-person-circle"></i> <?= esc($comentor['name']) ?></h4>
                <p><i class="bi bi-code-square"></i> Kode Referral: <strong><?= esc($comentor_code) ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Form Upload -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Upload File CSV</h5>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/<?= urlScope() ?>/scholarship/followup-comentors/<?= $comentor['id'] ?>/process-import" 
                  method="post" 
                  enctype="multipart/form-data"
                  id="importForm">
                
                <div class="upload-area" id="uploadArea">
                    <i class="bi bi-cloud-upload"></i>
                    <h5>Pilih File CSV</h5>
                    <p class="text-muted">Drag & drop file atau klik untuk memilih</p>
                    <input type="file" 
                           name="csv_file" 
                           id="csvFile" 
                           accept=".csv" 
                           class="form-control" 
                           required
                           style="display: none;">
                    <button type="button" class="btn btn-primary mt-3" onclick="document.getElementById('csvFile').click()">
                        <i class="bi bi-folder2-open"></i> Pilih File
                    </button>
                    <div id="fileName" class="mt-3"></div>
                </div>

                <div class="sample-format">
                    <h6><i class="bi bi-info-circle"></i> Format File CSV</h6>
                    <p class="mb-2">File CSV harus berisi kolom berikut:</p>
                    <ul class="mb-2">
                        <li><strong>Email</strong> - Email peserta yang terdaftar di scholarship_participants</li>
                    </ul>
                    <p class="mb-2">Contoh format:</p>
                    <pre style="background: white; padding: 10px; border-radius: 5px;"><code>email
peserta1@example.com
peserta2@example.com
peserta3@example.com</code></pre>
                    
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="bi bi-lightbulb"></i> 
                        <strong>Catatan:</strong> Sistem akan mengupdate field <code>reference_comentor</code> dan 
                        <code>is_reference_followup = 1</code> untuk setiap email yang ditemukan di database.
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                        <i class="bi bi-upload"></i> Upload & Proses Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('csvFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileName = document.getElementById('fileName');
    const submitBtn = document.getElementById('submitBtn');
    
    if (file) {
        fileName.innerHTML = `<div class="alert alert-success mt-3">
            <i class="bi bi-file-earmark-check"></i> File dipilih: <strong>${file.name}</strong> (${(file.size / 1024).toFixed(2)} KB)
        </div>`;
        submitBtn.disabled = false;
    } else {
        fileName.innerHTML = '';
        submitBtn.disabled = true;
    }
});

// Drag and drop functionality
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('csvFile');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
        uploadArea.style.borderColor = '#667eea';
        uploadArea.style.backgroundColor = '#e7f1ff';
    });
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
        uploadArea.style.borderColor = '#dee2e6';
        uploadArea.style.backgroundColor = '#f8f9fa';
    });
});

uploadArea.addEventListener('drop', function(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
});
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->
