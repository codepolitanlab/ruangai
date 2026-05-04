<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Import Alibaba Cloud ID</h3>
                <p class="text-subtitle text-muted">Update alibaba_cloud_id pada user_profiles via CSV.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Import Alibaba Cloud ID</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload File CSV</h4>
                    </div>
                    <div class="card-body">
                        <?= view('Heroicadmin\Views\_partials\alerts') ?>

                        <div class="alert alert-info">
                            <strong>Format CSV yang diperlukan:</strong><br>
                            Header kolom: <code>email,alibaba_cloud_id</code><br>
                            Proses: join ke tabel <code>users</code> by email &rarr; update <code>user_profiles.alibaba_cloud_id</code>
                        </div>

                        <form method="post" action="/<?= urlScope() ?>/dashboard/alibaba-import" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">File CSV</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                                <div class="form-text">Pastikan file berformat <code>.csv</code> dengan header <code>email</code> dan <code>alibaba_cloud_id</code>.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Proses Import
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->endSection() ?>
