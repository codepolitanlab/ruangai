<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Question</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/ruangpanel/quiz">Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/ruangpanel/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a> -->
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-sm rounded shadow mb-2">
            <div class="card-body px-3 py-2">
                <h4 class="pt-2 d-flex justify-content-between">
                    <span style="line-height:36px;">PLACEMENT TEST TOPIK II</span>
                    <a class="btn btn-outline-white text-dark collapsed" data-bs-toggle="collapse" role="button" href="#detailEntry" aria-expanded="false" aria-controls="detailEntry">
                        Lihat detail <span class="bi bi-chevron-down"></span>
                    </a>
                </h4>
                <div class="collapse" id="detailEntry" style="">
                    <div class="row" style="margin:0">
                        <div class="col-12">
                            <table class="table table-sm table-responsive table-hover my-2">
                                <tbody>
                                    <tr>
                                        <td class="text-secondary d-flex justify-content-between" style="min-width:200px">
                                            <strong>Deskripsi</strong>
                                            <span>:</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary d-flex justify-content-between" style="min-width:200px">
                                            <strong>Durasi</strong>
                                            <span>:</span>
                                        </td>
                                        <td>02:10:00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary d-flex justify-content-between" style="min-width:200px">
                                            <strong>Skor Minimum</strong>
                                            <span>:</span>
                                        </td>
                                        <td>75</td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary d-flex justify-content-between" style="min-width:200px">
                                            <strong>Status</strong>
                                            <span>:</span>
                                        </td>
                                        <td><span class="text-primary">Publish</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card rounded shadow">
            <div class="card-body">

                <form>
                    <section class="mb-2">
                        <div class="mb-4">


                        </div>

                        <div class="row gx-3 align-items-center">
                            <div class="col-auto">
                                <div class="mb-2 px-1 pe-3 border-end py-2"><strong>Total baris: 1</strong></div>
                            </div>

                            <div class="col-auto d-flex align-items-center">
                                <div class="mb-2 me-sm-2 text-nowrap"><label>Sort by: </label></div>
                                <select name="sort" class="form-select mb-2 me-sm-2">
                                    <option value="created_at">Tanggal submit</option>
                                    <option value="user_id">Peserta</option>
                                    <option value="duration">Durasi Pengerjaan</option>
                                    <option value="time_used">Waktu Terpakai</option>
                                    <option value="total_right">Jawaban Benar</option>
                                    <option value="total_wrong">Jawaban Salah</option>
                                    <option value="score">Skor</option>
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
                                <a href="https://course.taeyangkulture.com/ruangpanel/entry/quiz_student/?filter[group_id]=218" class="btn btn-outline-white">Reset</a>
                            </div>
                        </div>
                    </section>

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr style="background-color: #eee;">
                                    <th width="60px">No.</th>

                                    <th class="">
                                        Peserta </th>
                                    <th class="">
                                        Durasi Pengerjaan </th>
                                    <th class="">
                                        Waktu Terpakai </th>
                                    <th class="">
                                        Jawaban Benar </th>
                                    <th class="">
                                        Jawaban Salah </th>
                                    <th class="">
                                        Skor </th>

                                    <th class="sorted">
                                        <label>
                                            <span class="bi bi-caret-down text-white"></span>
                                            <span class="text-nowrap">created_at</span>
                                        </label>
                                    </th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td></td>

                                    <td>
                                        <select name="filter[user_id]" class="form-select form-select-sm form-filter-dropdown" placeholder="filter by user_id" id="filter-user_id">
                                            <option value="" selected="selected"></option>
                                            <option value="1">Mimin</option>
                                            <option value="2">Test User</option>
                                            <option value="3">Admin</option>
                                            <option value="4">Alambana Jumadi Saputra</option>
                                            <option value="5">Vanesa Pudjiastuti M.Ak</option>
                                            <option value="6">Martana Rajata</option>
                                            <option value="7">Wakiman Taufan Samosir M.Ak</option>
                                            <option value="8">Edison Waskita</option>
                                            <option value="9">Bahuwarna Firgantoro</option>
                                            <option value="10">Opung Gunawan S.Sos</option>
                                        </select>

                                    </td>
                                    <td><input type="text" class="form-control form-control-sm form-filter" id="filter-duration" name=" filter[duration]" value="" placeholder="filter by Durasi Pengerjaan"></td>
                                    <td><input type="text" class="form-control form-control-sm form-filter" id="filter-time_used" name=" filter[time_used]" value="" placeholder="filter by Waktu Terpakai"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="filter[total_right]" value="" placeholder="filter by Jawaban Benar"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="filter[total_wrong]" value="" placeholder="filter by Jawaban Salah"></td>
                                    <td><input type="text" class="form-control form-control-sm form-filter" id="filter-score" name=" filter[score]" value="" placeholder="filter by Skor"></td>

                                    <td></td>

                                    <input type="hidden" name="filter[group_id]" value="218">

                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary"><span class="bi bi-search"></span></button>
                                            <a href="https://course.taeyangkulture.com/ruangpanel/entry/quiz_student/                    ?filter[group_id]=218" class="btn btn-outline-white">
                                                <span class="bi bi-refresh"></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>1</td>


                                    <td>
                                        Rivo Dwi (smartfarming.telyu@gmail.com) </td>
                                    <td>
                                        <span class="">02:10:00</span>
                                    </td>
                                    <td>
                                        <span class="">00:01:42</span>
                                    </td>
                                    <td>
                                        2 </td>
                                    <td>
                                        90 </td>
                                    <td>
                                        <span class="">2.17391</span>
                                    </td>

                                    <td title="Tuesday, 21 Januaryid_ID">
                                        21-01-2025, 07:07 </td>

                                    <td class="text-end">
                                        <div class="btn-group mb-1">


                                            <a data-pjax="false" target="_blank" href="https://course.taeyangkulture.com/ruangpanel/entry/quiz_student/action/row/answer/2746" class="btn btn-sm btn-outline-white text-info answer" title="Lihat Jawaban">
                                                <span class="bi bi-search"></span> Lihat Jawaban </a>
                                        </div>

                                        <div class="btn-group mb-1">


                                            <a data-no-swup="" class="btn btn-sm btn-outline-white text-danger " onclick="return confirm('Yakin akan menghapus?')" href="https://course.taeyangkulture.com/ruangpanel/entry/quiz_student/delete/2746?filter[group_id]=218" title="Delete"><span class="bi bi-x-lg"></span> Hapus</a>
                                        </div>
                                    </td>
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