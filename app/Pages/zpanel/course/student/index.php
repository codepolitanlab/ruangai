<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Students</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/zpanel/course">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow pb-4">
            <div class="card-body table-responsive">
                <form method="GET" action="/zpanel/course/student">
                    <?php $total = count($students) ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0">Total: <b><?= $total ?></b></p>
                        <div class="d-flex align-items-center gap-2">
                            <small class="fw-bold">Order By:</small>
                            <select name="filter[field]" class="form-select form-select-sm" style="width: auto;">
                                <option value="fullname" <?= @$filter['field'] == 'fullname' ? 'selected' : '' ?>>Fullname</option>
                                <option value="whatsapp" <?= @$filter['field'] == 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                                <option value="progress" <?= @$filter['field'] == 'progress' ? 'selected' : '' ?>>Progress</option>
                                <option value="last_progress_at" <?= @$filter['field'] == 'last_progress_at' ? 'selected' : '' ?>>Last Progress</option>
                            </select>
                            <select name="filter[order]" class="form-select form-select-sm" style="width: auto;">
                                <option value="desc" <?= @$filter['order'] == 'desc' ? 'selected' : '' ?>>Desc</option>
                                <option value="asc" <?= @$filter['order'] == 'asc' ? 'selected' : '' ?>>Asc</option>
                            </select>
                            <small class="fw-bold">Perpage:</small>
                            <input type="number" name="perpage" class="form-control form-control-sm" style="width: 70px;" value="<?= @$perpage ?? 10 ?>" placeholder="Per Page">
                            <div class="btn-group ms-3">
                                <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                <a href="/zpanel/course/student" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Whatsapp</th>
                                    <th>Program</th>
                                    <th width="15%">Joined At</th>
                                    <th class="text-center">Progress</th>
                                    <th width="15%">Last Progress</th>
                                    <th width="15%">Last Login</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filter Row -->
                                <tr>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[fullname]" value="<?= @$filter['fullname'] ?>" placeholder="filter name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[whatsapp]" value="<?= @$filter['whatsapp'] ?>" placeholder="filter whatsapp"></td>
                                    <td>
                                        <select name="filter[program]" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            <?php foreach ($programs as $program): ?>
                                                <option value="<?= $program['code'] ?>" <?= @$filter['program'] == $program['code'] ? 'selected' : '' ?>><?= $program['code'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control form-control-sm" name="filter[created_at]" value="<?= @$filter['created_at'] ?>">
                                    </td>
                                    <td>
                                        <input type="number" min="0" max="100" class="form-control form-control-sm text-center mx-auto" name="filter[progress]" value="<?= @$filter['progress'] ?>" placeholder="filter progress">
                                    </td>
                                    <td></td>
                                </tr>
                                <!-- Data Rows -->
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td width="20%"><?= esc($student->fullname) ?></td>
                                        <td><?= esc($student->whatsapp) ?></td>
                                        <td><?= esc($student->program) ?></td>
                                        <td><?= date('d M Y', strtotime($student->created_at)) ?></td>
                                        <td>
                                            <svg class="progress-ring" width="80" height="80">
                                                <!-- Lingkaran Background -->
                                                <circle class="progress-ring__circle-bg" stroke="#e9ecef" stroke-width="7" fill="transparent" r="30" cx="40" cy="40" />

                                                <!-- Lingkaran Progres -->
                                                <circle
                                                    class="progress-ring__circle"
                                                    stroke="#81B0CA"
                                                    stroke-width="7"
                                                    fill="transparent"
                                                    r="30"
                                                    cx="40" cy="40"
                                                    stroke-dasharray="188.4"
                                                    stroke-dashoffset="<?= 188.4 - (188.4 * ($student->progress ?? 0) / 100); ?>"
                                                    transform="rotate(-90 40 40)" />

                                                <!-- Teks Persen -->
                                                <text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size=".8rem" fill="#81B0CA">
                                                    <?= $student->progress ?? 0; ?>%
                                                </text>
                                            </svg>
                                        </td>
                                        <td><?= $student->last_progress_at ? date('d M Y H:i', strtotime($student->last_progress_at)) : '-' ?></td>
                                        <td><?= $student->last_active ? date('d M Y H:i', strtotime($student->last_active)) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <?= $pager->links('default', 'bootstrap') ?>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->