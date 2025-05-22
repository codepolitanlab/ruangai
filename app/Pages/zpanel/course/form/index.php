<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/zpanel/course">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/zpanel/course/lessons/1" class="btn btn-primary"><i class="bi bi-save"></i> Manage Lessons</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-save"></i> Save Courses</button>
            </div>
        </div>
    </div>

    <section class="section">
        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="course-tab" data-bs-toggle="tab" href="/zpanel/course/form" role="tab" aria-controls="course" aria-selected="true">Course</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="product-tab" href="/zpanel/course/product" role="tab" aria-controls="product" aria-selected="false" tabindex="-1">Product</a>
            </li>
        </ul> -->
        <div class="list-group list-group-horizontal-sm text-center w-25" role="tablist">
            <a href="/zpanel/course/form" class="list-group-item list-group-item-action border-0 rounded-0 active">Course</a>
            <a href="/zpanel/course/product" class="list-group-item list-group-item-action border-0 rounded-0">Product</a>
        </div>
        <div class="tab-content mb-5" id="myTabContent">
            <div class="tab-pane card fade show active" id="course" role="tabpanel" aria-labelledby="course-tab" style="border-top:0; border-radius: 0 10px">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-7">
                            <h4 class="mb-4">Course Properties</h4>

                            <div class="mb-3">
                                <label class="form-label">Judul Konten</label>
                                <small></small><br>
                                <input type="text" id="course_title" name="course_title" value="Ngonten Sakti dengan AI" placeholder="" class="form-control" data-caption="Judul Konten" required="" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <small></small><br>
                                <input type="text" id="slug" class="form-control " name="slug" value="ngonten-sakti-dengan-ai" data-referer="course_title" data-caption="Slug">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tingkat Kesukaran</label>
                                <small></small><br>

                                <!-- Start load_after -->

                                <select name="level" id="level" class="form-select select2-hidden-accessible" data-caption="Tingkat Kesukaran" tabindex="-1" aria-hidden="true">
                                    <option value="beginner" selected="selected">Pemula</option>
                                    <option value="intermediate">Menengah</option>
                                    <option value="advance">Mahir</option>
                                </select>

                                <script>
                                    $(function() {
                                        $('#loading_level').addClass('sr-only');
                                        $('#dropdown_level').removeClass('sr-only');
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

                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <input type="text" id="tags" data-role="tagsinput" value="JavaScript, React" class="form-control">
                                <script>
                                    $(document).ready(function() {
                                        $("#tags").tagsinput({
                                            trimValue: true, // Menghapus spasi berlebih
                                            allowDuplicates: false // Mencegah duplikasi tags
                                        });
                                    });
                                </script>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cover</label>
                                <small>700x350px (2:1)</small><br>
                                <div class="form-group mb-3">
                                    <div class="input-group mb-3">
                                        <input type="text" id="image_cover" name="cover" class="form-control" placeholder="Choose file .." value="//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png" data-caption="Cover">
                                        <div class="input-group-append">
                                            <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="/filemanager/dialog.php?type=1&amp;field_id=image_cover&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumbnail</label>
                                <small>500x500px (1:1)</small><br>
                                <div class="form-group mb-3">
                                    <div class="input-group mb-3">
                                        <input type="text" id="image_thumbnail" name="thumbnail" class="form-control" placeholder="Choose file .." value="//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png" data-caption="Thumbnail">
                                        <div class="input-group-append">
                                            <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="/filemanager/dialog.php?type=1&amp;field_id=image_thumbnail&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <small></small><br>
                                <textarea id="description" class="form-control" rows="5" name="description" placeholder="" data-caption="Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Long Description</label>
                                <textarea id="editor"></textarea>
                                <script>
                                    ClassicEditor
                                        .create(document.querySelector('#editor'))
                                        .then(editor => {
                                            editor.ui.view.editable.element.style.height = "300px";
                                        })
                                        .catch(error => {
                                            console.error(error);
                                        });
                                </script>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 bg-success text-light p-2">
                                <label class="form-label">Status</label>
                                <small></small><br>

                                <!-- Start load_after -->

                                <select name="status" id="status" class="form-select select2-hidden-accessible" data-caption="Status" tabindex="-1" aria-hidden="true">
                                    <option value="draft">Draft</option>
                                    <option value="publish" selected="selected">Publish</option>
                                    <option value="invisible">Invisible</option>
                                </select>

                                <script>
                                    $(function() {
                                        $('#loading_status').addClass('sr-only');
                                        $('#dropdown_status').removeClass('sr-only');
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
                            <div class="mb-3">
                                <label class="form-label">Authors</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Source Code</label>
                                <small>Bahan pendukung pembelajaran</small><br>
                                <input type="text" id="sourcecode_url" name="sourcecode_url" value="" placeholder="" class="form-control" data-caption="Source Code" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Preview URL</label>
                                <small>URL halaman demo (opsional)</small><br>
                                <input type="text" id="preview_url" name="preview_url" value="" placeholder="" class="form-control" data-caption="Preview URL" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course Order</label>
                                <small>For ordering course in loop page</small><br>
                                <div class="col-sm-6 pl-0 mb-0">
                                    <input id="course_order" type="number" name="course_order" value="0" class="form-control" data-caption="Course Order" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Time</label>
                                <small>dalam detik</small><br>
                                <input type="text" id="total_time" name="total_time" value="32091" placeholder="" class="form-control" data-caption="Total Time" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">Enable Quiz</label><br>
                                <small>Tampilkan lesson yang berisi quiz?</small><br>
                                <label class="align-middle pe-2">Tidak</label>
                                <label class="align-middle switch" id="enable_quiz">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="enable_quiz" value="0" data-caption="Enable Quiz">
                                </label>
                                <label class="align-middle ps-2">Ya</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#enable_quiz');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">Enable Checklist</label><br>
                                <small>Tampilkan tombol untuk menandai materi yang sudah dipelajari?</small><br>
                                <label class="align-middle pe-2">Tidak</label>
                                <label class="align-middle switch" id="enable_checklist">
                                    <input type="checkbox" checked="">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="enable_checklist" value="1" data-caption="Enable Checklist">
                                </label>
                                <label class="align-middle ps-2">Ya</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#enable_checklist');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">Kunci Urutan Lesson</label><br>
                                <small>Apakah siswa harus mempelajari materi secara berurutan?</small><br>
                                <label class="align-middle pe-2">Tidak</label>
                                <label class="align-middle switch" id="enable_finish">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="enable_finish" value="0" data-caption="Kunci Urutan Lesson">
                                </label>
                                <label class="align-middle ps-2">Ya</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#enable_finish');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->