<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Quizzes</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/zpanel/quiz">Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/zpanel/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a> -->
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card p-3 card-block">
            <form method="post" enctype="multipart/form-data" id="exam_form" class="entryForm">

                <div class="mb-5 pb-3 border-bottom">
                    <button type="submit" name="submitBtn" value="save" class="btn btn-success me-1"><span class="bi bi-save"></span> Save</button>
                    <button type="submit" name="submitBtn" value="save_and_exit" class="btn btn-outline-success me-1"><span class="bi bi-save"></span> Save &amp; Exit</button>
                    <a href="/zpanel/quiz" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span> Back to Entry</a>
                </div>

                <div class="row">


                    <div id="input-title" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Title <span class="text-danger">*</span>
                            </label>


                            <div class="d-block">
                                <input type="text" id="title" name="title" value="" placeholder="" class="form-control" data-caption="Title" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-slug" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Slug <span class="text-danger">*</span>
                            </label>


                            <div class="d-block">
                                <input type="text" id="slug" class="form-control slugify" name="slug" value="" data-referer="title" data-caption="Slug">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-description" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">Description </label>
                            <div class="d-block">
                                <textarea id="description" class="form-control" rows="5" name="description" placeholder="" data-caption="Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-type" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Tipe </label>


                            <div class="d-block">

                                <!-- Start load_after -->

                                <select name="type" id="type" class="form-select select2-hidden-accessible" data-caption="Tipe" tabindex="-1" aria-hidden="true">
                                    <option value="lesson">Lesson</option>
                                    <option value="exam">Exam</option>
                                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 730.164px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-type-container"><span class="select2-selection__rendered" id="select2-type-container" title="Lesson">Lesson</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>


                                <script>
                                    $(function() {
                                        $('#loading_type').addClass('sr-only');
                                        $('#dropdown_type').removeClass('sr-only');
                                        $('.form-select').select2();

                                    });
                                </script>

                                <!-- End !load_after -->

                                <script>
                                    $(function() {
                                        $('.form-select').select2();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-label" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Label </label>

                            <small> • Nama/alias untuk mengelompokkan</small>

                            <div class="d-block">
                                <input type="text" id="label" name="label" value="" placeholder="" class="form-control" data-caption="Label" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-kkm" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Minimum Lulus (%) </label>


                            <div class="d-block">
                                <div class="col-sm-6 pl-0 mb-0">
                                    <input id="kkm" type="number" name="kkm" value="" class="form-control" data-caption="Minimum Lulus (%)" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-duration" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Durasi </label>


                            <div class="d-block">
                                <input id="duration" type="hidden" name="duration" value="">
                                <div class="d-flex justify-content-start">
                                    <div class="input-group mb-2 me-2" style="max-width:150px">
                                        <input id="duration_h" type="number" class="form-control duration_duration" value="00" min="0" max="24">
                                        <div class="input-group-text px-1 px-md-2">jam</div>
                                    </div>
                                    <div class="input-group mb-2 me-2" style="max-width:150px">
                                        <input id="duration_m" type="number" class="form-control duration_duration" value="00" min="0" max="59">
                                        <div class="input-group-text px-1 px-md-2">menit</div>
                                    </div>
                                    <div class="input-group mb-2 me-2" style="max-width:150px">
                                        <input id="duration_s" type="number" class="form-control duration_duration" value="00" min="0" max="59">
                                        <div class="input-group-text px-1 px-md-2">detik</div>
                                    </div>
                                </div>


                                <script>
                                    $(function() {
                                        $('.duration_duration').on('change', function() {
                                            let h = $('#duration_h').val() ?? '0';
                                            let m = $('#duration_m').val() ?? '0';
                                            let s = $('#duration_s').val() ?? '0';
                                            h = (new Intl.NumberFormat('en-US', {
                                                minimumIntegerDigits: 2
                                            })).format(h);
                                            m = (new Intl.NumberFormat('en-US', {
                                                minimumIntegerDigits: 2
                                            })).format(m);
                                            s = (new Intl.NumberFormat('en-US', {
                                                minimumIntegerDigits: 2
                                            })).format(s);
                                            $('#duration').val(`${h}:${m}:${s}`);
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-cover" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Cover </label>


                            <div class="d-block">
                                <div class="form-group mb-3">
                                    <div class="input-group mb-3">
                                        <input type="text" id="image_cover" name="cover" class="form-control" placeholder="Choose file .." value="" data-caption="Cover">
                                        <div class="input-group-append">
                                            <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="/filemanager/dialog.php?type=1&amp;field_id=image_cover&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-random_question" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Acak Urutan Pertanyaan </label>


                            <div class="d-block">
                                <label class="align-middle pe-2">Tidak</label>
                                <label class="align-middle switch" id="random_question">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="random_question" value="0" data-caption="Acak Urutan Pertanyaan">
                                </label>
                                <label class="align-middle ps-2">Ya</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#random_question');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-random_answer" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Acak Urutan Opsi Jawaban </label>


                            <div class="d-block">
                                <label class="align-middle pe-2">Tidak</label>
                                <label class="align-middle switch" id="random_answer">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="random_answer" value="0" data-caption="Acak Urutan Opsi Jawaban">
                                </label>
                                <label class="align-middle ps-2">Ya</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#random_answer');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-accesscode" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Kode Akses </label>

                            <small> • Kosongkan untuk menonaktifkan</small>

                            <div class="d-block">
                                <input type="text" id="accesscode" name="accesscode" value="" placeholder="" class="form-control" data-caption="Kode Akses" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-status" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Status </label>


                            <div class="d-block">

                                <div class="form-check ">
                                    <input name="status" class="form-check-input" type="radio" id="status_draft" value="draft" checked="">
                                    <label class="form-check-label" for="status_draft">
                                        <span class="text-secondary">Draft</span> </label>
                                </div>


                                <div class="form-check ">
                                    <input name="status" class="form-check-input" type="radio" id="status_publish" value="publish">
                                    <label class="form-check-label" for="status_publish">
                                        <span class="text-primary">Publish</span> </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                </div>

                <hr class="my-4">

                <input type="hidden" name="edit_after_insert" value="1">

                <div class="">
                    <button type="submit" name="submitBtn" value="save" class="btn btn-success me-1"><span class="bi bi-save"></span> Save</button>
                    <button type="submit" name="submitBtn" value="save_and_exit" class="btn btn-outline-success me-1"><span class="bi bi-save"></span> Save &amp; Exit</button>
                    <a href="/zpanel/entry/exam/?" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span> Back to Entry</a>
                </div>

            </form>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->