<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course'); ?>">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Live Batches</li>
                    </ol>
                </nav>
                <h3>Live Batches</h3>
                <h5 class="h6">Course: <?= $course['course_title']; ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url(urlScope() . '/course/' . $course['id'] . '/live/create'); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Batch</a>
                <a href="<?= site_url(urlScope() . '/course/' . $course['id'] . '/live/blueprint'); ?>" class="btn btn-outline-secondary"><i class="bi bi-plus"></i> Manage Meeting Blueprint</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($batches as $batch): ?>
                            <tr>
                                <td><?= $batch['id'] ?></td>
                                <td><?= $batch['name'] ?></td>
                                <td><?= $batch['start_date'] ?></td>
                                <td><?= $batch['end_date'] ?></td>
                                <td><?= $batch['status'] ?></td>
                                <td>
                                    <a href="<?= site_url(urlScope() . '/course/live/' . $batch['id'] . '/meeting') ?>" class="btn btn-sm btn-primary">Meeting Schedule</a>
                                    <a href="<?= site_url(urlScope() . '/course/' . $batch['course_id'] . '/live/' . $batch['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?= site_url(urlScope() . '/course/' . $batch['course_id'] . '/live/' . $batch['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?= $pager->links('default', 'bootstrap') ?>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
