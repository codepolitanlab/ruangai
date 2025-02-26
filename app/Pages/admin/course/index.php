<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Online Class</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/admin/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="header-block header-block-search ps-1 mt-2 mb-2">
                <form role="search">
                    <div class="input-group w-25 ms-auto me-3 mt-2">
                        <input type="text" name="search" class="form-control" placeholder="Search course" value="">
                        <button type="submit" class="btn btn-outline-primary"><span class="bi bi-search"></span></button>
                        <a href="https://madrasahdigital.id/admin/course" class="btn btn-outline-secondary"><span class="bi bi-arrow-repeat"></span></a>
                    </div>
                </form>
            </div>

            <ul class="list-unstyled mt-3">
                <li class="media border-top">
                    <div class="media-body px-3 py-2">
                        <div class="row">
                            <div class="col-lg-6 pl-2 d-flex justify-content-start mb-2">
                                <img src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png" style="margin-top:10px; width:100px;height:100px;object-fit:cover;">
                                <div class="ps-3 pt-2">
                                    <h5 class="mt-0 mb-1 d-inline-block">
                                        Ngonten Sakti dengan AI
                                    </h5>
                                    <div class="d-inline-block align-text-bottom ms-1">
                                        <span class="badge rounded-pill text-bg-success">publish</span>
                                    </div>
                                    <br>
                                    <a class="text-info font-weight-bold" href="https://madrasahdigital.id/courses/intro/ngonten-sakti-dengan-ai" target="_blank">
                                        <span class="text-muted"><em>ngonten-sakti-dengan-ai</em> <span class="bi bi-box-arrow-up-right"></span></span>
                                    </a>

                                    <div>
                                        <small>Tags:</small>
                                        <span class="badge mb-1 rounded-pill text-bg-light">ngonten</span>
                                        <span class="badge mb-1 rounded-pill text-bg-light">ai</span>
                                        <span class="badge mb-1 rounded-pill text-bg-light">artificial intelligence</span>
                                        <span class="badge mb-1 rounded-pill text-bg-light">kecerdasan buatan</span>
                                    </div>

                                    <div class="option-menu mt-3">
                                        <small class="text-muted">
                                            <a class="btn btn-sm btn-outline-secondary" href="/admin/course/lessons/1"><span class="bi bi-list"></span> Manage Lessons</a>
                                            <a class="btn btn-sm btn-outline-secondary" href="/admin/course/student"><span class="bi bi-users"></span> Student list</a>
                                            <a class="btn btn-sm btn-outline-secondary" href="/admin/course/form/1"><span class="bi bi-pencil-square"></span> Edit</a>
                                            <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Sure?')" href="https://madrasahdigital.id/admin/course/remove/1"><span class="bi bi-trash"></span> Delete</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-2 mb-2 font-smaller">
                                <div class="row">
                                    <div class="col-6 col-sm-4">
                                        <div class="text-nowrap"><strong>Total modul:</strong> 50</div>
                                        <div><strong>Durasi:</strong> 08:54:51</div>
                                        <div><strong class="text-nowrap">Last update:</strong> <br>30 December -0001</div>
                                    </div>
                                    <div class="col-6 col-sm-4 px-2">
                                        <div class="d-flex gap-1"><span class="pe-1 bi bi-dash-circle text-muted" title="quiz enabled"></span> <span>Enable Quiz</span></div>
                                        <div class="d-flex gap-1"><span class="pe-1 bi bi-check-circle text-success" title="lesson checklist enabled"></span> <span>Enable Checklist</span></div>
                                        <div class="d-flex gap-1"><span class="pe-1 bi bi-dash-circle text-muted" title="lesson checklist enabled"></span> <span>Lock Learning Step</span></div>
                                    </div>
                                    <div class="col-sm-4 px-2">
                                        <h5>Price</h5>
                                        <div>
                                            <span class="font-weight-bold">Lifetime: </span>
                                            <span class="text-nowrap text-success">
                                                <del class="text-muted">500.000</del>
                                                225.000 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->