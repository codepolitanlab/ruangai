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
                <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant/exports'); ?>" class="btn btn-outline-primary"><i class="bi bi-download"></i> Export Data</a>
                <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['meeting_code'] . '/attendant/import'); ?>" class="btn btn-outline-primary"><i class="bi bi-file-earmark-arrow-up"></i> Import Data</a>
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
                    <label>Belum Isi Feedback:</label>
                    <h4 class="text-warning"><?= $stats['belum_isi_feedback']; ?></h4>
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
                                <th>Graduate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="GET">
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[name]" value="<?= @$filter['name'] ?>" placeholder="filter name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[email]" value="<?= @$filter['email'] ?>" placeholder="filter name"></td>
                                    <td></td>
                                    <td>
                                        <select name="filter[durasi]" class="form-select form-select-sm">
                                            <option value="">Semua</option>
                                            <option value="1" <?= @$filter['durasi'] === '1' ? 'selected' : '' ?>>Valid (30+)</option>
                                            <option value="0" <?= @$filter['durasi'] === '0' ? 'selected' : '' ?>>Tidak Valid (30-)</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="filter[feedback]" class="form-select form-select-sm">
                                            <option value="">Semua</option>
                                            <option value="1" <?= @$filter['feedback'] === '1' ? 'selected' : '' ?>>Mengisi</option>
                                            <option value="0" <?= @$filter['feedback'] === '0' ? 'selected' : '' ?>>Belum Mengisi</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="filter[status]" class="form-select form-select-sm">
                                            <option value="">Semua</option>
                                            <option value="1" <?= @$filter['status'] === '1' ? 'selected' : '' ?>>Valid</option>
                                            <option value="0" <?= @$filter['status'] === '0' ? 'selected' : '' ?>>Tidak Valid</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="filter[graduate]" class="form-select form-select-sm">
                                            <option value="">Semua</option>
                                            <option value="1" <?= @$filter['graduate'] === '1' ? 'selected' : '' ?>>Lulus</option>
                                            <option value="0" <?= @$filter['graduate'] === '0' ? 'selected' : '' ?>>Belum Lulus</option>
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
                                        <h6 class="m-0"><?= $attender->name ?></h6>
                                        <small class="text-muted"><?= $attender->phone ?></small>
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
                                        <?php if ($attender->meeting_feedback_id ?? null): ?>
                                            ✅
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-link text-nowrap"
                                                data-bs-toggle="modal"
                                                data-bs-target="#feedbackModal"
                                                data-feedback='<?= json_encode($attender->feedback_content, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                                                <span class="bi bi-search"></span> Lihat
                                            </button>
                                        <?php else: ?>
                                            ❌
                                        <?php endif ?>
                                    </td>

                                    <td><?= ($attender->status ?? '0') === '1' ? '✅' : '❌' ?></td>
                                    <td><?= ($attender->graduate ?? '0') === '1' ? '✅' : '❌' ?></td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant/' . $attender->id . '/edit'); ?>"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>

                                            <form action="<?= site_url(urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant/' . $attender->id . '/delete'); ?>"
                                                method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                    <i class="bi bi-trash"></i> Delete
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

<!-- Modal Feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Detail Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tbody id="feedbackDetail"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var feedbackModal = document.getElementById('feedbackModal');
        feedbackModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var feedback = button.getAttribute('data-feedback');

            try {
                var data = JSON.parse(feedback);
            } catch (e) {
                var data = {};
            }
            console.log(data);
            var tbody = feedbackModal.querySelector('#feedbackDetail');
            tbody.innerHTML = '';

            for (const key in data) {
                tbody.innerHTML += `
                <tr>
                    <th style="width:200px">${key}</th>
                    <td>${data[key]}</td>
                </tr>
            `;
            }
        });
    });
</script>
<?php $this->endSection() ?>
<!-- END Content Section -->