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
                    <h3 class="mt-2 mb-4">🧩 Add Quiz</h3>

                    <style>
                        .tab-content {
                            border-bottom: 3px solid #ccc !important;
                        }

                        #accordionQuestion .card {
                            margin-bottom: 5px;
                            border-radius: 5px;
                            border-bottom: 1px solid #ccc;
                        }

                        #accordionQuestion .card .card-header {
                            background-color: #eee;
                        }

                        #accordionQuestion .card .card-header .btn-link {
                            color: #444;
                            font-weight: 600;
                        }

                        .btn.text-muted {
                            color: #aaa !important;
                        }

                        .ck-editor__editable_inline {
                            min-height: 100px !important;
                        }
                    </style>

                    <!-- FORM QUIZ GROUP -->
                    <form action="/zpanel/course/save_quiz/1/1/" method="post">
                        <div class="tab-content pb-5" id="myTabContent">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="topic_id">Topic</label>
                                    <input disabled="" type="text" id="topic_id" name="topic_id" class="form-control" placeholder="Lesson Title" value="Pengenalan">
                                    <input type="hidden" name="topic_id" value="1">
                                    <input type="hidden" name="quiz_id" value="">
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
                                    <label class="form-label" for="lesson_title">Quiz Title</label>
                                    <input type="text" name="lesson_title" value="" id="lesson_title" class="form-control title" placeholder="Quiz Title" style="font-weight:bold">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="lesson_slug">Quiz Slug</label>
                                    <input type="text" name="lesson_slug" value="" id="lesson_slug" class="form-control slug" placeholder="Quiz Slug">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4">
                                    <div class="mb-3">
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
                                        <label class="form-label" for="video">Minimum Score</label>
                                        <input type="number" name="kkm" id="kkm" class="form-control" value="100">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Duration</label>
                                        <small>(HH:MM:SS)</small>
                                        <input type="text" name="duration" id="duration" class="form-control" value="00:00:00">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 d-flex justify-content-start">
                                    <div class="pe-5">
                                        <label class="form-label" for="lesson_slug">Is Quiz Free?</label><br>
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
                                        <label class="form-label" for="lesson_slug">Publish Quiz?</label><br>
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
                            </div>
                        </div>
                    </form>
                    <!-- END FORM QUIZ GROUP -->

                    <!-- QUESTION MANAGEMENT -->
                    <!-- END QUESTION MANAGEMENT -->

                    <script>
                        $(function() {
                            if (location.hash != null && location.hash != "") {
                                $('.collapse').removeClass('in');
                                $(location.hash + '.collapse').collapse('show');
                                $('.main-wrapper').scrollTop(0);
                                setTimeout(() => {
                                    $('.main-wrapper').animate({
                                        'scrollTop': $(location.hash).offset().top - 60
                                    }, 400);
                                }, 400);
                            }

                            $(document).on('click', '.remove_option', function() {
                                var questionID = $(this).data('question');
                                var optionID = $(this).data('option');
                                if (confirm('Hapus opsi ini?')) {
                                    $('#option_group_' + optionID).remove();
                                }
                            })

                            $('.btn-add-option').on('click', function() {
                                var randID = Math.random().toString(36).substr(2, 9);
                                var questionID = $(this).data('question');
                                optionTemplate = `
        <div class="mb-3" id="option_group_${randID}">
          <div class="d-flex justify-content-start">
            <div>
              <button type="button" class="remove_option btn btn-secondary btn-sm" data-question="" data-option="${randID}"><span class="fa fa-times text-danger"></span></button>
            </div>
            <div class="col-6">
              <input type="text" name="question_options[${randID}]" class="form-control" value="" required focus>
            </div>
            <div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="is_right" value="${randID}" id="check_right_${randID}">
                <label class="form-label" class=" custom-control-label" for="check_right_${randID}">
                  This is right option
                </label>
              </div>
            </div>
          </div>
        </div>`;
                                $('#qs_' + questionID).find('.question_options').append(optionTemplate);
                            })
                        })
                    </script>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->