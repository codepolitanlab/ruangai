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
                    <div class="d-flex justify-content-between">
                        <p>Total: <b><?= $total ?></b></p>
                        <div>
                            <select name="filter[order]" class="form-control form-control-sm ms-1">
                                <option value="desc" <?= @$filter['order'] == 'desc' ? 'selected' : '' ?>>Terbaru</option>
                                <option value="asc" <?= @$filter['order'] == 'asc' ? 'selected' : '' ?>>Terlama</option>
                            </select>
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
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                            <a href="/zpanel/course/student" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Data Rows -->
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td width="20%"><?= esc($student->fullname) ?></td>
                                        <td><?= esc($student->whatsapp) ?></td>
                                        <td><?= esc($student->program) ?></td>
                                        <td><?= date('d M Y', strtotime($student->created_at)) ?></td>
                                        <td>
                                            <!-- data from $student->progress -->
                                            <svg class="progress-ring" width="120" height="120">
                                                <circle class="progress-ring__circle-bg" stroke="#e9ecef" stroke-width="7" fill="transparent" r="30" cx="60" cy="60" />
                                                <circle class="progress-ring__circle" stroke="#81B0CA" stroke-width="7" fill="transparent" r="30" cx="60" cy="60"
                                                    stroke-dasharray="314" stroke-dashoffset="<?php echo 314 - (314 * $student->progress) / 100; ?>" transform="rotate(-90 60 60)" />
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