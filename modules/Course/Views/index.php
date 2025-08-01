<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Online Class</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Courses</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="header-block header-block-search ps-1 mt-2 mb-2">
                <form method="GET" role="search">
                    <div class="input-group w-25 ms-auto me-3 mt-2">
                        <input type="text" name="search" class="form-control" placeholder="Search course" value="<?= $search ?? '' ?>">
                        <button type="submit" class="btn btn-outline-primary"><span class="bi bi-search"></span></button>
                        <a href="/<?= urlScope() ?>/course" class="btn btn-outline-secondary"><span class="bi bi-arrow-repeat"></span></a>
                    </div>
                </form>
            </div>

            <ul class="list-unstyled mt-3">
                <?php if($courses) : ?>
                <?php foreach ($courses as $course) : ?>
                <li class="media border-top">
                    <div class="media-body px-3 py-2">
                        <div class="row">
                            <div class="col-lg-6 pl-2 d-flex justify-content-start mb-2">
                                <img src="<?= $course['cover'] ?>"
                                    style="margin-top:10px; width:100px;height:100px;object-fit:cover;">
                                <div class="ps-3 pt-2">
                                    <h5 class="mt-0 mb-1 d-inline-block">
                                        <?= $course['course_title'] ?>
                                    </h5>
                                    <div class="d-inline-block align-text-bottom ms-1">
                                        <span class="badge rounded-pill text-bg-success"><?= $course['status'] ?></span>
                                    </div>
                                    <br>
                                    <a class="text-info font-weight-bold" href="<?= site_url('courses/intro/' . $course['id'] . '/') ?>" target="_blank">
                                        <span class="text-muted"><em><?= $course['slug'] ?></em> <sup class="bi bi-box-arrow-up-right ms-1"></sup></span>
                                    </a>

                                    <div class="option-menu mt-3">
                                        <small class="text-muted">
                                            <?php if ($course['has_modules'] === '1') : ?>
                                                <a class="btn btn-sm btn-outline-secondary" href="/<?= urlScope() ?>/course/<?= $course['id'] ?>"><span class="bi bi-list"></span> Lessons</a>
                                            <?php endif; ?>
                                            <?php if ($course['has_live_sessions'] === '1') : ?>
                                                <a class="btn btn-sm btn-outline-secondary" href="/<?= urlScope() ?>/course/<?= $course['id'] ?>/live"><span class="bi bi-camera"></span> Live Session</a>
                                            <?php endif; ?>
                                            <a class="btn btn-sm btn-outline-secondary" href="/<?= urlScope() ?>/course/<?= $course['id'] ?>/student"><span class="bi bi-people"></span> Student</a>
                                            <a class="btn btn-sm btn-outline-secondary" href="/<?= urlScope() ?>/course/form?id=<?= $course['id'] ?>"><span class="bi bi-pencil-square"></span> Edit</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-2 mb-2 font-smaller">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-nowrap"><strong>Total modul:</strong> <?= $course['total_module'] ?></div>
                                        <div class="text-nowrap"><strong>Jenis kelas:</strong> <?= $course['has_modules'] === 1 ? 'Video' : 'Live Session' ?></div>
                                        <div><strong>Durasi:</strong> <?= $course['duration'] ?> Menit</div>
                                        <div><strong class="text-nowrap">Last update:</strong> <br><?= $course['last_update'] || $course['updated_at'] ? date('d-m-Y, H:i', strtotime($course['last_update'] ?? $course['updated_at'])) : '-' ?></div>
                                    </div>
                                    <!-- <div class="col-2 bg-danger px-2">
                                        <div class="d-flex gap-1"><span class="pe-1 bi bi-dash-circle text-muted" title="quiz enabled"></span> <span>Enable Quiz</span></div>
                                        <div class="d-flex gap-1"><span class="pe-1 bi bi-check-circle text-success" title="lesson checklist enabled"></span> <span>Enable Checklist</span></div>
                                        <div class="d-flex gap-1"><span class="pe-1 bi bi-dash-circle text-muted" title="lesson checklist enabled"></span> <span>Lock Learning Step</span></div>
                                    </div> -->
                                    <div class="col-6 px-2">
                                        <h5>Price</h5>
                                        <div>
                                            <div class="font-weight-bold">Lifetime: </div>
                                            <span class="text-nowrap text-success">
                                                <del class="text-muted">Rp <?= number_format($course['normal_price']) ?></del> <br>
                                                Rp <?= number_format($course['price']) ?> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
                <?php else : ?>
                    <li class="border-top text-center py-2">No course found</li>
                <?php endif; ?>
            </ul>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->