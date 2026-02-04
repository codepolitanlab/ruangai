<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Challenge Submissions</h3>
                <p class="text-subtitle text-muted">Manage WAN Vision Clash submission</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Submissions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Submissions</h5>
                <div>
                    <a href="<?= site_url('challenge/submissions/export') ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-download"></i> Export CSV
                    </a>
                </div>
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

                <!-- Filter Status -->
                <div class="mb-3">
                    <label class="form-label">Filter by Status:</label>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary filter-status" data-status="">All</button>
                        <button type="button" class="btn btn-outline-warning filter-status" data-status="pending">Pending</button>
                        <button type="button" class="btn btn-outline-info filter-status" data-status="validated">Validated</button>
                        <button type="button" class="btn btn-outline-success filter-status" data-status="approved">Approved</button>
                        <button type="button" class="btn btn-outline-danger filter-status" data-status="rejected">Rejected</button>
                    </div>
                </div>

                <!-- DataTable -->
                <div class="table-responsive">
                    <table class="table table-striped" id="submissionsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Video Title</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
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

    const table = $('#submissionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= site_url('ruangpanel/challenge/submissions') ?>',
            type: 'POST',
            data: function(d) {
                d.status = statusFilter;
            }
        },
        columns: [
            { data: 'id' },
            { data: 'user_name' },
            { data: 'user_email' },
            { data: 'video_title' },
            { 
                data: 'status',
                render: function(data) {
                    const badges = {
                        'pending': '<span class="badge bg-warning">Pending</span>',
                        'validated': '<span class="badge bg-info">Validated</span>',
                        'approved': '<span class="badge bg-success">Approved</span>',
                        'rejected': '<span class="badge bg-danger">Rejected</span>'
                    };
                    return badges[data] || data;
                }
            },
            { data: 'submitted_at' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']]
    });

    // Filter by status
    $('.filter-status').on('click', function() {
        $('.filter-status').removeClass('active');
        $(this).addClass('active');
        statusFilter = $(this).data('status');
        table.ajax.reload();
    });
});
</script>
<?= $this->endSection() ?>
