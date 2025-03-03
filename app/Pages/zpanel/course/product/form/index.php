<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/zpanel/course">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product</li>
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
            <form method="post" enctype="multipart/form-data" id="course_product_form" class="entryForm">

                <div class="mb-5 pb-3 border-bottom">
                    <button type="submit" name="submitBtn" value="save" class="btn btn-success me-1"><span class="fa fa-save"></span> Save</button>
                    <button type="submit" name="submitBtn" value="save_and_exit" class="btn btn-outline-success me-1"><span class="fa fa-save"></span> Save &amp; Exit</button>
                    <a href="/zpanel/course/product" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span> Back to Entry</a>
                </div>

                <div class="row">


                    <div id="input-course_id" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Course </label>


                            <div class="d-block">

                                <!-- Start load_after -->

                                <select name="course_id" id="course_id" class="form-select select2-hidden-accessible" data-caption="Course" disabled="" tabindex="-1" aria-hidden="true">
                                    <option value="">-pilih opsi-</option>
                                    <option value="1" selected="selected">Ngonten Sakti dengan AI</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" style="width: 730.164px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-labelledby="select2-course_id-container"><span class="select2-selection__rendered" id="select2-course_id-container" title="Ngonten Sakti dengan AI">Ngonten Sakti dengan AI</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>

                                <input type="hidden" name="course_id" value="1">

                                <script>
                                    $(function() {
                                        $('#loading_course_id').addClass('sr-only');
                                        $('#dropdown_course_id').removeClass('sr-only');
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


                    <div id="input-title" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Nama Produk <span class="text-danger">*</span>
                            </label>


                            <div class="d-block">
                                <input type="text" id="title" name="title" value="" placeholder="" class="form-control" data-caption="Nama Produk" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-description" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Deskripsi </label>


                            <div class="d-block">
                                <input type="text" id="description" name="description" value="" placeholder="" class="form-control" data-caption="Deskripsi" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-default_price" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Harga Default? </label>


                            <div class="d-block">
                                <label class="align-middle pe-2">No</label>
                                <label class="align-middle switch" id="default_price">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="default_price" value="0" data-caption="Harga Default?">
                                </label>
                                <label class="align-middle ps-2">Yes</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#default_price');
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


                    <div id="input-duration" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Durasi </label>


                            <div class="d-block">

                                <!-- Start load_after -->

                                <select name="duration" id="duration" class="form-select select2-hidden-accessible" data-caption="Durasi" tabindex="-1" aria-hidden="true">
                                    <option value="99999" selected="selected">Selamanya</option>
                                    <option value="31">1 Bulan</option>
                                    <option value="62">2 Bulan</option>
                                    <option value="93">3 Bulan</option>
                                    <option value="124">4 Bulan</option>
                                    <option value="155">5 Bulan</option>
                                    <option value="186">6 Bulan</option>
                                    <option value="366">1 Tahun</option>
                                    <option value="731">2 Tahun</option>
                                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 730.164px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-duration-container"><span class="select2-selection__rendered" id="select2-duration-container" title="Selamanya">Selamanya</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>


                                <script>
                                    $(function() {
                                        $('#loading_duration').addClass('sr-only');
                                        $('#dropdown_duration').removeClass('sr-only');
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


                    <div id="input-price" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Harga <span class="text-danger">*</span>
                            </label>


                            <div class="d-block">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input id="price" type="number" name="price" value="0" class="form-control" data-caption="Harga">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <small class="form-text"></small>
                    </div>


                    <div id="input-strike_price" class="col-xl-8 col-lg-9 col-md-8 ">
                        <div class="mb-3">
                            <label class="form-label text-nowrap">
                                Harga Coret </label>


                            <div class="d-block">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input id="strike_price" type="number" name="strike_price" value="0" class="form-control" data-caption="Harga Coret">
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
                    <button type="submit" name="submitBtn" value="save" class="btn btn-success me-1"><span class="fa fa-save"></span> Save</button>
                    <button type="submit" name="submitBtn" value="save_and_exit" class="btn btn-outline-success me-1"><span class="fa fa-save"></span> Save &amp; Exit</button>
                    <a href="/zpanel/course/product?filter[course_id]=1" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span> Back to Entry</a>
                </div>

            </form>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->