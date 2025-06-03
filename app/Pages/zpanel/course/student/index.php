<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

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
                    <p>Total: <b><?= $total ?></b></p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Whatsapp</th>
                                        <th>Program</th>
                                        <th width="15%">Joined At</th>
                                        <th>Progress</th>
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
                                        <td><input type="text" class="form-control form-control-sm" name="filter[program]" value="<?= @$filter['program'] ?>" placeholder="filter program"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                                <a href="/zpanel/course/student" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Data Rows -->
                                    <?php foreach($students as $student): ?>
                                    <tr>
                                        <td><?= esc($student->fullname) ?></td>
                                        <td><?= esc($student->whatsapp) ?></td>
                                        <td><?= esc($student->program) ?></td>
                                        <td><?= date('d M Y', strtotime($student->created_at)) ?></td>
                                        <td><?= esc($student->lesson_title) ?></td>
                                        <td><?= $student->last_progress_at ? date('d M Y H:i', strtotime($student->last_progress_at)) : '-' ?></td>
                                        <td><?= date('d M Y', strtotime($student->last_active)) ?></td>
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