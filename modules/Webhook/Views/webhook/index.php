<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Riwayat Webhook</h3>
                <p class="text-subtitle text-muted">Review setiap notifikasi webhook yang masuk dari sistem eksternal</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()) ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('webhook') ?>">Webhook</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Riwayat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Semua Webhook Masuk</h5>
                <a href="<?= admin_url('webhook/sources') ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-hdd-stack"></i> Kelola Sumber
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

                <!-- Filter -->
                <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                    <div class="btn-group" role="group" aria-label="Filter status">
                        <button type="button" class="btn btn-outline-secondary filter-status active" data-status="">Semua</button>
                        <button type="button" class="btn btn-outline-warning filter-status" data-status="pending">Pending</button>
                        <button type="button" class="btn btn-outline-success filter-status" data-status="success">Sukses</button>
                        <button type="button" class="btn btn-outline-danger filter-status" data-status="failed">Gagal</button>
                    </div>
                    <div class="btn-group" role="group" aria-label="Filter review">
                        <button type="button" class="btn btn-outline-secondary filter-review active" data-reviewed="">Semua</button>
                        <button type="button" class="btn btn-outline-primary filter-review" data-reviewed="0">Belum Direview</button>
                        <button type="button" class="btn btn-outline-dark filter-review" data-reviewed="1">Sudah Direview</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="webhookTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sumber</th>
                                <th>Event</th>
                                <th>Status</th>
                                <th>Metode</th>
                                <th>IP</th>
                                <th>Review</th>
                                <th>Diterima</th>
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
    let statusFilter = '';
    let reviewedFilter = '';

    const table = $('#webhookTable').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: '<?= admin_url('webhook') ?>',
            type: 'POST',
            data: function(d) {
                d.status = statusFilter;
                d.reviewed = reviewedFilter;
            }
        },
        columns: [
            { data: 'id' },
            { data: 'source_name' },
            { data: 'event' },
            {
                data: 'status',
                render: function(data) {
                    const badges = {
                        'pending': '<span class="badge bg-warning">Pending</span>',
                        'success': '<span class="badge bg-success">Sukses</span>',
                        'failed': '<span class="badge bg-danger">Gagal</span>'
                    };
                    return badges[data] || data;
                }
            },
            { data: 'method' },
            { data: 'ip_address' },
            {
                data: 'is_reviewed',
                render: function(data) {
                    return data == 1
                        ? '<span class="badge bg-dark">Sudah direview</span>'
                        : '<span class="badge bg-light text-dark border">Belum</span>';
                }
            },
            { data: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });

    // Filter status
    $('.filter-status').on('click', function() {
        $('.filter-status').removeClass('active');
        $(this).addClass('active');
        statusFilter = $(this).data('status');
        table.ajax.reload();
    });

    // Filter review
    $('.filter-review').on('click', function() {
        $('.filter-review').removeClass('active');
        $(this).addClass('active');
        reviewedFilter = String($(this).data('reviewed'));
        table.ajax.reload();
    });
});
</script>
<?= $this->endSection() ?>
