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
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/' . $batch['course_id']); ?>">Live Session</a></li>
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


    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">
                <?php if (session()->getFlashdata('successMsg')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('successMsg') ?>
                    </div>
                <?php endif; ?>

                <div class="overflow-auto">
                    <table class="table table-bordered" style="table-layout: fixed;min-width: 1300px;">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="25%">Status</th>
                                <th width="20%">Title</th>
                                <th width="20%">Subtitle</th>
                                <th width="30%">Description</th>
                                <th width="20%">Mentor</th>
                                <th width="25%" class="text-nowrap">Meeting Date</th>
                                <th width="25%" class="text-nowrap">Meeting Time</th>
                                <th width="20%">Zoom Link</th>
                                <th width="20%">Recording</th>
                                <th width="20%">Feedback</th>
                                <th width="150xp">Actions</th>
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
                                    <td><?= $meeting['subtitle'] ?></td>
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
                                    <td> <a href="<?= $meeting['form_feedback_url'] ?>" target="_blank"><?= $meeting['form_feedback_url'] ?></a></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('zpanel/course/live/schedule/attendance/' . $meeting['id']) ?>" class="btn btn-sm btn-primary mb-1"><i class="bi bi-people"></i></a>
                                        <a href="<?= site_url('zpanel/course/live/schedule/update/' . $batch['id'] . '/' . $meeting['id']) ?>" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                                        <a href="<?= site_url('zpanel/course/live/schedule/delete/' . $batch['id'] . '/' . $meeting['id']) ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?= $pager->links('default', 'bootstrap') ?>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->