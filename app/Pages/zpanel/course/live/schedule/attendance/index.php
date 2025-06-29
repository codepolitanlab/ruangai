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
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/'); ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/' . $live_session['live_batch_id']); ?>">Live Batches</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('/zpanel/course/live/schedule/' . $live_session['live_batch_id']); ?>">Schedule</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Live Session Attendance</li>
                    </ol>
                </nav>
                <h3>Live Session Attendance</h3>
                <h5 class="h6">Live Session: <?= $live_session['title']; ?></h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="<?= site_url('/zpanel/course/live/schedule/attendance/import/' . $live_session['id']); ?>" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Import</a>
                <a href="<?= site_url('/zpanel/course/live/schedule/attendance/form?live_meeting_id=' . $live_session['id']); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Attendance</a>
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
                    <p>Total : <b><?= $total_records ?></b></p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="GET" action="/zpanel/course/live/schedule/attendance/<?= $live_session['id'] ?>">
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[name]" value="<?= @$filter['name'] ?>" placeholder="filter name"></td>
                                    <td><input type="text" class="form-control form-control-sm"  name="filter[email]" value="<?= @$filter['email'] ?>" placeholder="filter email"></td>
                                    <td><input type="text" class="form-control form-control-sm"  name="filter[duration]" value="<?= @$filter['duration'] ?>" placeholder="filter duration"></td>
                                    <td></td>
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
                                    <td><?= $attender->name ?></td>
                                    <td><?= $attender->email ?></td>
                                    <td><?= $attender->duration ?? '-' ?></td>
                                    <td class="text-end">
                                        <div class="btn-group">

                                            <a class="btn btn-sm btn-outline-secondary text-nowrap"
                                                href="/zpanel/course/live/schedule/attendance/form?id=<?= $attender->id ?>&live_meeting_id=<?= $live_session['id'] ?>">
                                                <span class="bi bi-pencil-square"></span> Edit
                                            </a>

                                            <form action="/zpanel/course/live/schedule/attendance/form/delete" method="post" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <input type="hidden" name="id" value="<?= $attender->id ?>">
                                                <input type="hidden" name="live_meeting_id" value="<?= $live_session['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger text-nowrap">
                                                    <span class="bi bi-x-lg"></span> Delete
                                                </button>
                                            </form>
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