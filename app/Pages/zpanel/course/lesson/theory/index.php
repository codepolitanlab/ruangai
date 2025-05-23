<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <section class="section">
        <?= $this->include('zpanel/course/lesson/_header') ?>
        
        <div class="card card-block block-editor p-3">
            <div class="row">
                <?= $this->include('zpanel/course/lesson/_sidebar') ?>

                <div class="col-md-9 px-4">
                    <h3 class="mt-2 mb-4">📄 Add Material</h3>

                    <style>
                        .editor-toolbar.fullscreen,
                        .CodeMirror-fullscreen,
                        .editor-preview-side {
                            z-index: 20000 !important;
                        }

                        .CodeMirror,
                        .CodeMirror-scroll {
                            max-height: 350px;
                        }

                        .CodeMirror-fullscreen,
                        .CodeMirror-fullscreen .CodeMirror-scroll {
                            max-height: none;
                        }
                    </style>

                    <form action="/zpanel/course/save_theory/1/1/" method="post">

                        <div class="tab-content pb-3 border-bottom" id="myTabContent">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="topic_id">Topic</label>
                                    <input disabled="" type="text" id="topic_id" name="topic_id" class="form-control" placeholder="Lesson Title" value="Pengenalan">
                                    <input type="hidden" name="topic_id" value="1">
                                    <input type="hidden" name="topic_slug" value="Pengenalan">
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success shadow"><span class="fa fa-save"></span> Save Lesson</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Order -->
                                <input type="hidden" name="lesson_order" value="3">

                                <div class="col-6 slugify">
                                    <label class="form-label" for="lesson_title">Lesson Title</label>
                                    <input type="text" name="lesson_title" value="" id="lesson_title" class="form-control title" placeholder="Lesson Title" style="font-weight:bold">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="lesson_slug">Lesson Slug</label>
                                    <input type="text" name="lesson_slug" value="" id="lesson_slug" class="form-control slug" placeholder="Lesson Slug">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Video Type</label>
                                        <select name="video_type" id="video_type" class="form-control">
                                            <option value="youtube" selected="">Youtube</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Video ID</label>
                                        <input type="text" id="video" name="video" class="form-control" placeholder="i.e: dQw4w9WgXcQ for Youtube" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Video Duration</label>
                                        <input type="text" id="duration" name="duration" class="form-control" placeholder="mm:ss" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4">
                                    <div>
                                        <label class="form-label" for="video">Thumbnail Image</label>
                                        <div class="input-group">
                                            <div class="mb-3 mb-0">
                                                <div class="input-group mb-0">
                                                    <input type="text" id="thumbnail" name="thumbnail" class="form-control" placeholder="Choose file .." value="" data-caption="Thumbnail image">
                                                    <div class="input-group-append">
                                                        <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="/filemanager/dialog.php?type=1&amp;field_id=thumbnail&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2" class="input-group-text btn-file-manager">Choose</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Embed Quiz?
                                            <span class="fa fa-question-circle" title="You can embed one of your quiz at the bottom of this lesson."></span>
                                        </label>
                                        <select class="form-control autocomplete" name="quiz_id">
                                            <option value="">Select ..</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mt-3 justify-content-start">
                                <div class="pe-5">
                                    <label class="form-label" for="lesson_slug">Is Lesson Free?</label><br>
                                    <label class="align-middle pe-2">No</label>
                                    <label class="align-middle switch" id="free">
                                        <input type="checkbox">
                                        <span class="slider round d-inline-block"></span>
                                        <input type="hidden" name="free" value="0" data-caption="Free">
                                    </label>
                                    <label class="align-middle ps-2">Yes</label>

                                    <script>
                                        $(function() {
                                            let swParent = $('#free');
                                            swParent.children('input[type=checkbox]').on('change', function() {
                                                let checked = $(this).prop('checked');
                                                swParent.children('input[type=hidden]').val(Number(checked));
                                            })
                                        })
                                    </script>
                                </div>
                                <div class="pe-0">
                                    <label class="form-label" for="lesson_slug">Publish Lesson?</label><br>
                                    <label class="align-middle pe-2">No</label>
                                    <label class="align-middle switch" id="status">
                                        <input type="checkbox" checked="">
                                        <span class="slider round d-inline-block"></span>
                                        <input type="hidden" name="status" value="1" data-caption="Status">
                                    </label>
                                    <label class="align-middle ps-2">Yes</label>

                                    <script>
                                        $(function() {
                                            let swParent = $('#status');
                                            swParent.children('input[type=checkbox]').on('change', function() {
                                                let checked = $(this).prop('checked');
                                                swParent.children('input[type=hidden]').val(Number(checked));
                                            })
                                        })
                                    </script>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="editor">Text Content</label>
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
                            </div>
                        </div>

                        <div class="row mt-3 pt-2">
                            <div class="col-6">
                                <a class="text-danger" onclick="return confirm('Anda yakin akan menghapus lesson ini?')" href="/zpanel/course/delete_lesson/1/1/"><span class="fa fa-trash"></span> Hapus Lesson</a>
                            </div>
                            <div class="col-6 text-end">
                                <button type="submit" class="btn btn-success shadow"><span class="fa fa-save"></span> Save Lesson</button>
                            </div>
                        </div>

                    </form>

                    <script>
                        $(function() {
                            var editor = new SimpleMDE({
                                element: document.getElementById("simplemde-editor"),
                                autofocus: true,
                                spellChecker: false
                            });

                            // Set autocomplete.
                            $('.autocomplete').select2();

                            // Render simplemde content after tab click
                            $('#profile-tab').on('shown.bs.tab', function() {
                                editor.codemirror.refresh();
                            });

                            $("#lesson_title").keyup(function() {
                                let title = $(this).val();
                                $("#lesson_slug").val(convertToSlug(title));
                            });

                            $('#btnGetDuration').on('click', function() {
                                let vidKey = $('#video').val();
                                if (!vidKey) {
                                    alert('Video key is empty.');
                                    return;
                                }
                                $.get("/zpanel/course/getYoutubeDuration/" + vidKey + "/1", function(data) {
                                    if (typeof data == 'string') $('#duration').val(data);
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->