<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope()); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course'); ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/' . $batch['course_id'] . '/live'); ?>">Live Batches</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Schedule</li>
                    </ol>
                </nav>
                <h3>Live Meeting Schedule</h3>
                <h5 class="h6">Batch: <?= $batch['name']; ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url(urlScope() . '/course/live/' . $batch['id'] . '/meeting/create'); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Meeting</a>
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

                <div class="overflow-auto table-responsive">
                    <table class="table table-bordered" style="table-layout: fixed;min-width: 1300px;">
                        <thead>
                            <tr>
                                <th width="20%">ID &amp; Code</th>
                                <th width="30%">Title & Sub</th>
                                <th width="30%">Description</th>
                                <th width="20%">Mentor</th>
                                <th width="25%" class="text-nowrap">Meeting Time</th>
                                <th width="20%">Zoom Meeting ID/Link</th>
                                <th width="20%">Recording URL</th>
                                <th width="20%">Feedback URL</th>
                                <th width="20%">Module URL</th>
                                <th width="150xp">Actions</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php foreach ($meetings as $meeting): ?>
                                <tr>
                                    <td>
                                        <?= $meeting['id'] ?><br>
                                        <div class="badge text-bg-light mb-1"><?= $meeting['meeting_code'] ?? 'code not set' ?></div>
                                        <div class="badge rounded-pill bg-<?= $meeting['status'] === 'completed' ? 'success' : ($meeting['status'] === 'ongoing' ? 'warning' : 'secondary') ?>">
                                            <?= $meeting['status'] ?>
                                        </d>
                                    </td>
                                    <td>
                                        <div class="h6 mb-1"><?= $meeting['title'] ?></div>
                                        <small><?= $meeting['subtitle'] ?></small>
                                        <small class="badge rounded-pill fw-normal text-bg-light"><?= $meeting['theme_code'] ?></small>
                                    </td>
                                    <td><span class="text-ellipsis-2"><?= $meeting['description'] ?></span></td>
                                    <td><?= $meeting['mentor_name'] ?></td>
                                    <td>
                                        <?= date('d M Y', strtotime($meeting['meeting_date'])) ?><br>
                                        <?= date('H:i', strtotime($meeting['meeting_time'])) ?> WIB <br>
                                        <?= $meeting['meeting_duration'] ?? '' ?> menit
                                    </td>
                                    <td>
                                        <?= $meeting['zoom_meeting_id'] ?? '' ?>
                                        <div>
                                            <?php if (!empty($meeting['zoom_link']) || !empty($meeting['zoom_meeting_id'])): ?>
                                                <a href="<?= site_url('zoom/' . $meeting['meeting_code']) ?>" 
                                                target="_blank" 
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-camera-video"></i> Zoom Link</a>
                                            <?php else: ?>
                                                <span class="text-muted">Meeting code not set</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($meeting['recording_link']): ?>
                                            <a href="<?= $meeting['recording_link'] ?>" target="_blank" class="btn btn-sm btn-secondary"><i class="bi bi-play-circle"></i> Watch</a>
                                        <?php else: ?>
                                            <span class="text-muted">Not available</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($meeting['form_feedback_url']): ?>
                                            <a href="<?= $meeting['form_feedback_url'] ?>" target="_blank"><?= $meeting['form_feedback_url'] ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">Not available</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($meeting['module_url']): ?>
                                            <a href="<?= $meeting['module_url'] ?>" target="_blank"><?= $meeting['module_url'] ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">Not available</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $meeting['id'] . '/attendant') ?>" class="btn btn-sm btn-outline-primary mb-1"><i class="bi bi-people"></i> Partisipan</a>
                                        <a href="<?= site_url(urlScope() . '/course/live/' . $batch['id'] . '/meeting/' . $meeting['id'] . '/edit') ?>" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                                        <a href="<?= site_url(urlScope() . '/course/live/' . $batch['id'] . '/meeting/' . $meeting['id'] . '/delete') ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
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
