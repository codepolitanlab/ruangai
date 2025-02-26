<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Quizzes</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/admin/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a> -->
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded shadow">
            <div class="card-body">

                <form>
                    <section class="mb-2">
                        <div class="mb-4">
                            <a href="/admin/quiz/form" class="btn btn-success rounded shadow-sm">
                                <span class="bi bi-plus"></span>
                                <span class="d-none d-sm-inline">Tambah Quiz</span>
                            </a>


                        </div>

                        <div class="row gx-3 align-items-center">
                            <div class="col-auto">
                                <div class="mb-2 px-1 pe-3 border-end py-2"><strong>Total baris: 0</strong></div>
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                <div class="mb-2 me-sm-2 text-nowrap"><label>Sort by: </label></div>
                                <select name="sort" class="form-select mb-2 me-sm-2">
                                    <option value="created_at">Tanggal submit</option>
                                    <option value="title">Title</option>
                                    <option value="kkm">Minimum Lulus (%)</option>
                                    <option value="type">Tipe</option>
                                    <option value="label">Label</option>
                                    <option value="duration">Durasi</option>
                                    <option value="status">Status</option>
                                </select>
                                <select name="sortdir" class="form-select mb-2 me-sm-2">
                                    <option value="desc">desc</option>
                                    <option value="asc">asc</option>
                                </select>
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                <div class="mb-2 me-sm-2"><label>Perpage: </label></div>
                                <select name="perpage" class="form-control mb-2 me-sm-2">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="80">80</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="col-auto btn-group mb-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="https://madrasahdigital.id/admin/quiz/group" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </section>

                    <div class="table-responsive">
                        <table class="table table-hover  table-sm">
                            <thead>
                                <tr style="background-color: #eee;">
                                    <th width="60px">No.</th>

                                    <th class="">
                                        Title </th>
                                    <th class="">
                                        Minimum Lulus (%) </th>
                                    <th class="">
                                        Tipe </th>
                                    <th class="">
                                        Label </th>
                                    <th class="">
                                        Durasi </th>
                                    <th class="">
                                        Status </th>


                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td></td>

                                    <td><input type="text" class="form-control form-control-sm form-filter" id="filter-title" name=" filter[title]" value="" placeholder="filter by Title"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="filter[kkm]" value="" placeholder="filter by Minimum Lulus (%)"></td>
                                    <td>
                                        <select name="filter[type]" class="form-select form-select-sm form-filter-dropdown" placeholder="filter by type" id="filter-type">
                                            <option value="" selected="selected"></option>
                                            <option value="lesson">Lesson</option>
                                            <option value="exam">Exam</option>
                                        </select>

                                    </td>
                                    <td><input type="text" class="form-control form-control-sm form-filter" id="filter-label" name=" filter[label]" value="" placeholder="filter by Label"></td>
                                    <td><input type="text" class="form-control form-control-sm form-filter" id="filter-duration" name=" filter[duration]" value="" placeholder="filter by Durasi"></td>
                                    <td>
                                        <select name="filter[status]" class="form-control form-control-sm" placeholder="filter by status">
                                            <option value="" selected="selected">Semua</option>
                                            <option value="draft">Draft</option>
                                            <option value="publish">Publish</option>
                                        </select>

                                    </td>



                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary"><span class="bi bi-search"></span></button>
                                            <a href="https://madrasahdigital.id/admin/quiz/group                    " class="btn btn-secondary">
                                                <span class="bi bi-arrow-counterclockwise"></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="5">Belum ada data.</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>

                </form>

                <div class="pagination">
                </div>

            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->