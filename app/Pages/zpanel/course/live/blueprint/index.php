<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course'); ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/'.$course['id']); ?>">Live Session</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Blueprints</li>
                    </ol>
                </nav>
                <h3>Live Meeting Blueprints</h3>
                <h5 class="h6">Course: <?= $course['course_title']; ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url('/zpanel/course/live/blueprint/create/' . $course['id']); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Meeting</a>
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
                            <th>Title</th>
                            <th>Description</th>
                            <th>Mentor</th>
                            <th>Duration</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blueprints as $b): ?>
                            <tr>
                                <td><?= $b['id'] ?></td>
                                <td><?= $b['title'] ?></td>
                                <td><?= $b['description'] ?></td>
                                <td><?= $b['mentor_name'] ?></td>
                                <td><?= $b['duration'] ?></td>
                                <td><?= $b['order'] ?></td>
                                <td>
                                    <a href="<?= site_url('zpanel/course/live/blueprint/update/'. $b['course_id'] . '/' . $b['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?= site_url('zpanel/course/live/blueprint/delete/'. $b['course_id'] . '/' .$b['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
<!-- END Content Section -->