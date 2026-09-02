<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Sumber Webhook</h3>
                <p class="text-subtitle text-muted">Daftar provider/sistem eksternal pengirim webhook beserta secret key</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()) ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('webhook') ?>">Webhook</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sumber</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Sumber</h5>
                <a href="<?= admin_url('webhook/sources/add') ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Sumber
                </a>
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

                <div class="alert bg-info bg-opacity-50 py-2">
                    <i class="bi bi-info-circle"></i>
                    Endpoint publik penerima: <code><?= site_url('webhook/receive') ?>/[slug]</code>
                    (POST), misal <code><?= site_url('webhook/receive/codepolitan_cp') ?></code>.
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="sourceTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Slug</th>
                                <th>Secret</th>
                                <th>Header Token</th>
                                <th>Handler</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('#sourceTable').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        ajax: {
            url: '<?= admin_url('webhook/sources') ?>',
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'slug' },
            { data: 'secret' },
            { data: 'header_name' },
            { data: 'handler' },
            {
                data: 'status',
                render: function(data) {
                    return data === 'active'
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>';
                }
            },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
<?= $this->endSection() ?>
