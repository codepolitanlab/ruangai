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
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/'); ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/' . $meeting['course_id'] . '/live'); ?>">Live Batches</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url(urlScope() . '/course/live/' . $live_meeting['live_batch_id'] . '/meeting'); ?>">Meetings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Attendance</li>
                    </ol>
                </nav>
                <h3>Meeting Attendance</h3>
                <h5 class="h6">Live Meeting: <?= $live_meeting['title']; ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant/sync'); ?>" class="btn btn-outline-primary"><i class="bi bi-arrow-clockwise"></i> Sync Data</a>
                <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant/add'); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Attendance</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex gap-5">
                <div class="m-0">
                    <label>Hadir Min. 30 Menit:</label>
                    <h4 class="text-info"><?= $stats['users_durasi_gt_1800']; ?></h4>
                </div>
                <div class="m-0">
                    <label>Mengisi Feedback:</label>
                    <h4 class="text-info"><?= $stats['users_isi_feedback']; ?></h4>
                </div>
                <div class="m-0">
                    <label>Total Partisipan Valid:</label>
                    <h4 class="text-success"><?= $stats['users_valid']; ?></h4>
                </div>
                <div class="m-0">
                    <label>Total Partisipan Tidak Valid:</label>
                    <h4 class="text-secondary opacity-50"><?= $stats['users_tidak_valid']; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->get('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Zoom Join Link</th>
                                <th>Duration (s)</th>
                                <th>Feedback</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="GET">
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[name]" value="<?= @$filter['name'] ?>" placeholder="filter name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[email]" value="<?= @$filter['email'] ?>" placeholder="filter name"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <select name="filter[status]" class="form-select form-select-sm" >
                                            <option value="">All</option>
                                            <option value="1" <?= @$filter['status'] === '1' ? 'selected' : '' ?>>Valid</option>
                                            <option value="0" <?= @$filter['status'] === '0' ? 'selected' : '' ?>>Tidak Valid</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/zpanel/events" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </tr>
                            </form>

                            <?php
                            $no = ($current_page - 1) * $per_page + 1;

foreach ($attenders as $attender) :
    ?>
                                <tr>
                                    <td width="5%"><?= $no++ ?></td>
                                    <td>
                                        <?= $attender->name ?>
                                    </td>
                                    <td>
                                        <?= $attender->email ?></td>
                                    <td>
                                        <span class="text-ellipsis" title="<?= $attender->zoom_join_link ?? '-' ?>">
                                            <?= $attender->zoom_join_link ?? null ? '✅' : '❌' ?>
                                        </span>
                                    </td>
                                    <td class="<?= $attender->duration >= 1800 ? 'text-success' : 'text-danger' ?>"><?= $attender->duration ?? '-' ?></td>
                                    <td>
                                        <?= ($attender->meeting_feedback_id ?? null) 
                                            ? '✅ <a href="/zpanel/course/live/meeting/feedback/' . $attender->meeting_feedback_id . '/detail" class="btn btn-sm btn-link text-nowrap"><span class="bi bi-search"></span> Lihat</a>' 
                                            : '❌' ?>
                                    </td>
                                    <td><?= ($attender->status ?? '0') === '1' ? '✅' : '❌' ?></td>
                                    <td class="text-end">
                                        <div class="btn-group">

                                            <!-- <a class="btn btn-sm btn-outline-secondary text-nowrap"
                                                href="/<?= urlScope() ?>/course/live/meeting/<?= $live_meeting['id'] ?>/attendant/<?= $attender->id ?>/edit">
                                                <span class="bi bi-pencil-square"></span> Edit
                                            </a> -->

                                            <!-- <form action="/<?= urlScope() ?>/course/live/meeting/<?= $live_meeting['id'] ?>/attendant/<?= $attender->id ?>/delete" method="post" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <input type="hidden" name="id" value="<?= $attender->id ?>">
                                                <input type="hidden" name="live_meeting_id" value="<?= $live_meeting['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger text-nowrap">
                                                    <span class="bi bi-x-lg"></span> Delete
                                                </button>
                                            </form> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <?= $pager->links('default', 'bootstrap') ?>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->