<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Submission Detail</h3>
                <p class="text-subtitle text-muted">ID: #<?= $submission['id'] ?></p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('challenge/submissions') ?>">Submissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
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

        <div class="row">
            <!-- User Info -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>User Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?= esc($submission['user_name']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?= esc($submission['user_email']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td><?= esc($submission['user_phone']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><?= challenge_status_badge($submission['status']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Submitted:</strong></td>
                                <td><?= $submission['submitted_at'] ? date('d M Y H:i', strtotime($submission['submitted_at'])) : '-' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5>Admin Actions</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($submission['status'] === 'pending'): ?>
                            <form action="<?= site_url('challenge/submissions/validateSubmission/' . $submission['id']) ?>" method="post" class="mb-2">
                                <?= csrf_field() ?>
                                <div class="mb-2">
                                    <textarea name="admin_notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-info w-100">Validate Submission</button>
                            </form>
                        <?php endif; ?>

                        <?php if (in_array($submission['status'], ['pending', 'validated'])): ?>
                            <form action="<?= site_url('challenge/submissions/approve/' . $submission['id']) ?>" method="post" class="mb-2">
                                <?= csrf_field() ?>
                                <div class="mb-2">
                                    <textarea name="admin_notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Approve</button>
                            </form>

                            <form action="<?= site_url('challenge/submissions/reject/' . $submission['id']) ?>" method="post" onsubmit="return confirm('Are you sure want to reject this submission?')">
                                <?= csrf_field() ?>
                                <div class="mb-2">
                                    <textarea name="admin_notes" class="form-control" rows="2" placeholder="Reason for rejection (required)" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100">Reject</button>
                            </form>
                        <?php endif; ?>

                        <?php if (!empty($submission['admin_notes'])): ?>
                            <div class="alert alert-info mt-3">
                                <strong>Admin Notes:</strong><br>
                                <?= nl2br(esc($submission['admin_notes'])) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Submission Details -->
            <div class="col-md-8">
                <!-- Video Info -->
                <div class="card">
                    <div class="card-header">
                        <h5>Video Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>Video Title:</strong></label>
                            <p><?= esc($submission['video_title']) ?></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Video Description:</strong></label>
                            <p><?= nl2br(esc($submission['video_description'])) ?></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Twitter Post URL:</strong></label>
                            <p><a href="<?= esc($submission['twitter_post_url']) ?>" target="_blank"><?= esc($submission['twitter_post_url']) ?></a></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Ethical Statement:</strong></label>
                            <p>
                                <?php if ($submission['ethical_statement_agreed']): ?>
                                    <span class="badge bg-success">Agreed</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Not Agreed</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="card">
                    <div class="card-header">
                        <h5>Team Members</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($submission['team_members_array'])): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($submission['team_members_array'] as $member): ?>
                                            <tr>
                                                <td><?= esc($member['name']) ?></td>
                                                <td><?= esc($member['email']) ?></td>
                                                <td><span class="badge bg-secondary"><?= esc($member['role'] ?? 'Member') ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Solo submission</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Files -->
                <div class="card">
                    <div class="card-header">
                        <h5>Uploaded Files</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php if (!empty($submission['prompt_file'])): ?>
                                <a href="<?= site_url('challenge/submissions/download/' . $submission['id'] . '/prompt_file') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi <?= challenge_file_icon($submission['prompt_file']) ?>"></i>
                                    <strong>Prompt File:</strong> <?= esc($submission['prompt_file']) ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($submission['params_file'])): ?>
                                <a href="<?= site_url('challenge/submissions/download/' . $submission['id'] . '/params_file') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi <?= challenge_file_icon($submission['params_file']) ?>"></i>
                                    <strong>Params File (JSON):</strong> <?= esc($submission['params_file']) ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($submission['assets_list_file'])): ?>
                                <a href="<?= site_url('challenge/submissions/download/' . $submission['id'] . '/assets_list_file') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi <?= challenge_file_icon($submission['assets_list_file']) ?>"></i>
                                    <strong>Assets List:</strong> <?= esc($submission['assets_list_file']) ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($submission['alibaba_screenshot'])): ?>
                                <a href="<?= site_url('challenge/submissions/download/' . $submission['id'] . '/alibaba_screenshot') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi <?= challenge_file_icon($submission['alibaba_screenshot']) ?>"></i>
                                    <strong>Alibaba Screenshot:</strong> <?= esc($submission['alibaba_screenshot']) ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($submission['twitter_follow_screenshot'])): ?>
                                <a href="<?= site_url('challenge/submissions/download/' . $submission['id'] . '/twitter_follow_screenshot') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi <?= challenge_file_icon($submission['twitter_follow_screenshot']) ?>"></i>
                                    <strong>Twitter Follow Screenshot:</strong> <?= esc($submission['twitter_follow_screenshot']) ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
