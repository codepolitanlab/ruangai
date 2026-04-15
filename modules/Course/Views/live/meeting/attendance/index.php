<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
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
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
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

                <?php
                $basePath = urlScope() . '/course/live/meeting/' . $live_meeting['id'] . '/attendant';
                $currentFilter = $filter ?? [];
                $currentPerPage = $per_page ?? 10;
                $currentSortBy = $sort_by ?? 'created_at';
                $currentSortOrder = $sort_order ?? 'desc';

                $buildUrl = static function (array $overrides = []) use ($basePath, $currentFilter, $currentPerPage, $currentSortBy, $currentSortOrder): string {
                    $params = [
                        'filter' => $currentFilter,
                        'perpage' => $currentPerPage,
                        'sort_by' => $currentSortBy,
                        'sort_order' => $currentSortOrder,
                    ];

                    foreach ($overrides as $key => $value) {
                        if ($value === null) {
                            unset($params[$key]);
                            continue;
                        }

                        $params[$key] = $value;
                    }

                    $query = http_build_query($params);
                    return site_url($basePath . ($query ? '?' . $query : ''));
                };

                $sortUrl = static function (string $column) use ($buildUrl, $currentSortBy, $currentSortOrder): string {
                    $nextOrder = ($currentSortBy === $column && $currentSortOrder === 'asc') ? 'desc' : 'asc';
                    return $buildUrl([
                        'sort_by' => $column,
                        'sort_order' => $nextOrder,
                        'page' => null,
                    ]);
                };

                $sortIcon = static function (string $column) use ($currentSortBy, $currentSortOrder): string {
                    if ($currentSortBy !== $column) {
                        return '<i class="bi bi-arrow-down-up ms-1 text-muted"></i>';
                    }

                    return $currentSortOrder === 'asc'
                        ? '<i class="bi bi-sort-up ms-1"></i>'
                        : '<i class="bi bi-sort-down ms-1"></i>';
                };
                ?>

                <div class="d-flex justify-content-end mb-3">
                    <form method="GET" action="<?= site_url($basePath) ?>" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="filter[name]" value="<?= esc($currentFilter['name'] ?? '') ?>">
                        <input type="hidden" name="filter[email]" value="<?= esc($currentFilter['email'] ?? '') ?>">
                        <input type="hidden" name="filter[durasi]" value="<?= esc($currentFilter['durasi'] ?? '') ?>">
                        <input type="hidden" name="filter[status]" value="<?= esc($currentFilter['status'] ?? '') ?>">
                        <input type="hidden" name="filter[graduate]" value="<?= esc($currentFilter['graduate'] ?? '') ?>">
                        <input type="hidden" name="sort_by" value="<?= esc($currentSortBy) ?>">
                        <input type="hidden" name="sort_order" value="<?= esc($currentSortOrder) ?>">

                        <label class="mb-0 text-nowrap" for="perpage">Per page</label>
                        <select id="perpage" name="perpage" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="10" <?= (int) $currentPerPage === 10 ? 'selected' : '' ?>>10</option>
                            <option value="25" <?= (int) $currentPerPage === 25 ? 'selected' : '' ?>>25</option>
                            <option value="50" <?= (int) $currentPerPage === 50 ? 'selected' : '' ?>>50</option>
                            <option value="100" <?= (int) $currentPerPage === 100 ? 'selected' : '' ?>>100</option>
                        </select>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('name')) ?>">
                                        Name <?= $sortIcon('name') ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('email')) ?>">
                                        Email <?= $sortIcon('email') ?>
                                    </a>
                                </th>
                                <th>Zoom Join Link</th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('duration')) ?>">
                                        Duration (s) <?= $sortIcon('duration') ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('status')) ?>">
                                        Status Hadir <?= $sortIcon('status') ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('graduate')) ?>">
                                        Graduate <?= $sortIcon('graduate') ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('graduate_at')) ?>">
                                        Tanggal Lulus <?= $sortIcon('graduate_at') ?>
                                    </a>
                                </th>
                                <th>
                                    <a class="text-decoration-none text-dark" href="<?= esc($sortUrl('comentor')) ?>">
                                        Comentor <?= $sortIcon('comentor') ?>
                                    </a>
                                </th>
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
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group">
                                            <input type="hidden" name="perpage" value="<?= esc($currentPerPage) ?>">
                                            <input type="hidden" name="sort_by" value="<?= esc($currentSortBy) ?>">
                                            <input type="hidden" name="sort_order" value="<?= esc($currentSortOrder) ?>">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="<?= site_url($basePath) ?>" class="btn btn-secondary">Reset</a>
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
                                    <td><?= ($attender->status ?? '0') === '1' ? '✅' : '❌' ?></td>
                                    <td><?= ($attender->graduate ?? '0') === '1' ? '✅' : '❌' ?></td>
                                    <td><?= ($attender->graduate_at ?? null) ? date('d F Y H:i', strtotime($attender->graduate_at)) : '-' ?></td>
                                    <td><?= $attender->reference_comentor ?? '-' ?></td>
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