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
                                <div class="mb-2 px-1 pe-3 border-end py-2"><strong>Total baris: 214</strong></div>
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
                                <a href="https://course.taeyangkulture.com/admin/quiz/group" class="btn btn-outline-white"></a>
                            </div>
                        </div>
                    </section>

                    <div class="table-responsive">
                        <table class="table table-sm">
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
                                            <a href="https://course.taeyangkulture.com/admin/quiz/group" class="btn btn-outline-white"text-primary                                         <span class="bi bi-refresh"></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>1</td>


                                    <td>
                                        <span class="">PLACEMENT TEST TOPIK II</span>
                                    </td>
                                    <td>
                                        75 </td>
                                    <td>
                                        Lesson </td>
                                    <td>
                                        <span class=""></span>
                                    </td>
                                    <td>
                                        2 jam 10 menit </td>
                                    <td>
                                        <span class="text-primary">Publish</span>
                                    </td>


                                    <td class="text-end">
                                        <div class="btn-group mb-1">


                                            <a data-pjax="false" target="_blank" href="https://course.taeyangkulture.com/admin/entry/exam/action/row/room/218" class="btn btn-sm btn-outline-white text-info room" title="Room">
                                                <span class="bi bi-pc-display-horizontal"></span> Room </a>


                                            <a data-pjax="false" target="_blank" href="https://course.taeyangkulture.com/admin/entry/exam/action/row/preview/218" class="btn btn-sm btn-outline-white text-info preview" title="Preview">
                                                <span class="bi bi-eye"></span> Preview </a>


                                            <a target="_self" href="/admin/quiz/question" class="btn btn-sm btn-outline-white text-info questions" title="Questions">
                                                <span class="bi bi-list-ul"></span> Questions </a>


                                            <a target="_self" href="/admin/quiz/student" class="btn btn-sm btn-outline-white text-info student" title="Students">
                                                <span class="bi bi-people-fill"></span> Students </a>
                                        </div>

                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-sm btn-outline-white text-secondary" data-url="admin/entry/exam/detail/218" data-bs-caption="Detail data" data-bs-toggle="modal" data-bs-target="#detailModal" title="Detail"><span class="bi bi-search"></span> Detail</button>

                                            <a class="btn btn-sm btn-outline-white text-success " href="https://course.taeyangkulture.com/admin/entry/exam/edit/218?" title="Edit"><span class="bi bi-pencil"></span> Edit</a>

                                            <a data-no-swup="" class="btn btn-sm btn-outline-white text-danger" onclick="return confirm('Yakin akan menghapus?')" href="https://course.taeyangkulture.com/admin/entry/exam/delete/218?" title="Delete"><span class="bi bi-remove"></span> Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>


                                    <td>
                                        <span class="">PLACEMENT TEST TOPIK I</span>
                                    </td>
                                    <td>
                                        75 </td>
                                    <td>
                                        Lesson </td>
                                    <td>
                                        <span class=""></span>
                                    </td>
                                    <td>
                                        1 jam 40 menit </td>
                                    <td>
                                        <span class="text-primary">Publish</span>
                                    </td>


                                    <td class="text-end">
                                        <div class="btn-group mb-1">


                                            <a data-pjax="false" target="_blank" href="https://course.taeyangkulture.com/admin/entry/exam/action/row/room/217" class="btn btn-sm btn-outline-white text-info room" title="Room">
                                                <span class="bi bi-pc-display-horizontal"></span> Room </a>


                                            <a data-pjax="false" target="_blank" href="https://course.taeyangkulture.com/admin/entry/exam/action/row/preview/217" class="btn btn-sm btn-outline-white text-info preview" title="Preview">
                                                <span class="bi bi-eye"></span> Preview </a>


                                            <a target="_self" href="/admin/quiz/question" class="btn btn-sm btn-outline-white text-info questions" title="Questions">
                                                <span class="bi bi-list-ul"></span> Questions </a>


                                            <a target="_self" href="/admin/quiz/student" class="btn btn-sm btn-outline-white text-info student" title="Students">
                                                <span class="bi bi-people-fill"></span> Students </a>
                                        </div>

                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-sm btn-outline-white text-secondary" data-url="admin/entry/exam/detail/217" data-bs-caption="Detail data" data-bs-toggle="modal" data-bs-target="#detailModal" title="Detail"><span class="bi bi-search"></span> Detail</button>

                                            <a class="btn btn-sm btn-outline-white text-success" href="https://course.taeyangkulture.com/admin/entry/exam/edit/217?" title="Edit"><span class="bi bi-pencil"></span> Edit</a>

                                            <a data-no-swup="" class="btn btn-sm btn-outline-white text-danger" onclick="return confirm('Yakin akan menghapus?')" href="https://course.taeyangkulture.com/admin/entry/exam/delete/217?" title="Delete"><span class="bi bi-remove"></span> Hapus</a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </form>

                <div class="pagination">
                    <strong>1</strong><a href="https://course.taeyangkulture.com/admin/quiz/group?page=2" data-ci-pagination-page="2">2</a><a href="https://course.taeyangkulture.com/admin/quiz/group?page=3" data-ci-pagination-page="3">3</a><a href="https://course.taeyangkulture.com/admin/quiz/group?page=2" data-ci-pagination-page="2" rel="next">&gt;</a><a href="https://course.taeyangkulture.com/admin/quiz/group?page=22" data-ci-pagination-page="22">Terakhir ›</a>
                </div>

            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->