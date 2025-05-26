<?php $this->extend('layouts/admin') ?>

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

                    <?= form_open('/zpanel/course/lesson/theory'); ?>

                    <div class="tab-content pb-3 border-bottom" id="myTabContent">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="topic_id">Topic</label>
                                <input disabled="" type="text" id="topic_id" name="topic_id" class="form-control" placeholder="Material Title" value="<?= $topic['topic_title']; ?>">
                                <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
                                <input type="hidden" name="topic_id" value="<?= $topic['id']; ?>">
                                <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?? null; ?>">
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow"><span class="bi bi-save"></span> Save Material</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <!-- Order -->
                            <input type="hidden" name="lesson_order" value="3">

                            <div class="col-6 slugify">
                                <label class="form-label" for="lesson_title">Material Title</label>
                                <input
                                    type="text"
                                    name="lesson_title"
                                    value="<?= set_value('lesson_title', $lesson['lesson_title'] ?? ''); ?>"
                                    id="lesson_title"
                                    class="form-control title"
                                    placeholder="Material Title"
                                    style="font-weight:bold"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="lesson_slug">Material Slug</label>
                                <input
                                    type="text"
                                    name="lesson_slug"
                                    value="<?= set_value('lesson_slug', $lesson['lesson_slug'] ?? ''); ?>"
                                    id="lesson_slug"
                                    class="form-control slug"
                                    placeholder="Material Slug"
                                    required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="video_diupload">Video Diupload</label>
                                    <input type="text" id="video_diupload" name="video_diupload" class="form-control" value="<?= $lesson['video_diupload'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="video_bunny">Video Bunny</label>
                                    <input type="text" id="video_bunny" name="video_bunny" class="form-control" value="<?= $lesson['video_bunny'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="duration">Video Duration</label>
                                    <input type="text" id="duration" name="duration" class="form-control" placeholder="mm:ss" value="<?= $lesson['duration'] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mt-3 justify-content-start">
                            <div class="pe-5">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        value="1" 
                                        name="status" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="lesson_status" 
                                        <?= ($lesson['status'] ?? null) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="lesson_status">Publish Material?</label>
                                </div>
                            </div>
                            <div class="pe-5">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        value="1" 
                                        name="free" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="lesson_free" 
                                        <?= ($lesson['free'] ?? null) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="lesson_free">Is Material Free?</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="editor">Text Content</label>
                                    <textarea id="editor" name="text"><?= $lesson['text'] ?? ''; ?></textarea>
                                    <script>
                                        let editorInstance;
                                        ClassicEditor
                                            .create(document.querySelector('#editor'))
                                            .then(editor => {
                                                editorInstance = editor;
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
                            <?php if (isset($lesson['id'])): ?>
                                <a class="text-danger"
                                    onclick="return confirm('Anda yakin akan menghapus lesson ini?')"
                                    href="<?= site_url('/zpanel/course/lesson/deleteLesson/' . $course['id'] . '/' . $lesson['id']) ?>">
                                    <span class="bi bi-trash"></span> Hapus Material
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-success shadow"><span class="bi bi-save"></span> Save Material</button>
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