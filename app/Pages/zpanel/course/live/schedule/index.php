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
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/'.$batch['course_id']); ?>">Live Session</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Schedule</li>
                    </ol>
                </nav>
                <h3>Live Meeting Schedule</h3>
                <h5 class="h6">Batch: <?= $batch['name']; ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url('/zpanel/course/live/schedule/create/' . $batch['id']); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Meeting</a>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('successMsg')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('successMsg') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Mentor</th>
                    <th>Meeting Date</th>
                    <th>Meeting Time</th>
                    <th>Zoom Link</th>
                    <th>Recording</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meetings as $meeting): ?>
                    <tr>
                        <td><?= $meeting['id'] ?></td>
                        <td>
                            <span class="badge bg-<?= $meeting['status'] === 'completed' ? 'success' : ($meeting['status'] === 'ongoing' ? 'warning' : 'secondary') ?>">
                                <?= ucfirst($meeting['status']) ?>
                            </span>
                        </td>
                        <td><?= $meeting['title'] ?></td>
                        <td><?= $meeting['description'] ?></td>
                        <td><?= $meeting['mentor_name'] ?></td>
                        <td><?= date('d M Y', strtotime($meeting['meeting_date'])) ?></td>
                        <td><?= date('H:i', strtotime($meeting['meeting_time'])) ?> WIB</td>
                        <td>
                            <?php if ($meeting['zoom_link']): ?>
                                <a href="<?= $meeting['zoom_link'] ?>" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-camera-video"></i> Join</a>
                            <?php else: ?>
                                <span class="text-muted">Not set</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($meeting['recording_link']): ?>
                                <a href="<?= $meeting['recording_link'] ?>" target="_blank" class="btn btn-sm btn-secondary"><i class="bi bi-play-circle"></i> Watch</a>
                            <?php else: ?>
                                <span class="text-muted">Not available</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= site_url('zpanel/course/live/schedule/update/'. $batch['id'] . '/' . $meeting['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="<?= site_url('zpanel/course/live/schedule/delete/'. $batch['id'] . '/' . $meeting['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $pager->links('default', 'bootstrap') ?>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->