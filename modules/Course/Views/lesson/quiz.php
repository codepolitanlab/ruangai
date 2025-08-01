<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <section class="section">
        <?= $this->include('Course\Views\lesson\_header') ?>

        <div class="card card-block block-editor p-3">
            <div class="row">
                <?= $this->include('Course\Views\lesson\_sidebar') ?>

                <div class="col-md-9 px-4">
                    <h3 class="mt-2 mb-4">📄 Add Quiz</h3>

                    <?= form_open(urlScope() . '/course/' . $topic['course_id'] . '/topic/' . $topic['id'] . '/quiz'); ?>

                    <div class="tab-content pb-3 border-bottom" id="myTabContent">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="topic_id">Topic</label>
                                <input disabled="" type="text" id="topic_id" name="topic_id" class="form-control" placeholder="Quiz Title" value="<?= $topic['topic_title']; ?>">
                                <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
                                <input type="hidden" name="topic_id" value="<?= $topic['id']; ?>">
                                <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?? null; ?>">
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success shadow"><span class="bi bi-save"></span> Save Quiz</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <!-- Order -->
                            <input type="hidden" name="lesson_order" value="3">

                            <div class="col-6 slugify">
                                <label class="form-label" for="lesson_title">Quiz Title</label>
                                <input
                                    type="text"
                                    name="lesson_title"
                                    value="<?= set_value('lesson_title', $lesson['lesson_title'] ?? ''); ?>"
                                    id="lesson_title"
                                    class="form-control title"
                                    placeholder="Quiz Title"
                                    style="font-weight:bold"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="lesson_slug">Quiz Slug</label>
                                <input
                                    type="text"
                                    name="lesson_slug"
                                    value="<?= set_value('lesson_slug', $lesson['lesson_slug'] ?? ''); ?>"
                                    id="lesson_slug"
                                    class="form-control slug"
                                    placeholder="Quiz Slug"
                                    required>
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
                                    <label class="form-check-label" for="lesson_status">Publish Quiz?</label>
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
                                    <label class="form-check-label" for="lesson_free">Is Quiz Free?</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editor">Code Editor</label>
                                    <div id="editor" style="height: 300px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"><?= set_value('quiz', $lesson['quiz'] ?? ''); ?></div>
                                    <input type="hidden" name="quiz" id="yaml_quiz" value="<?= set_value('quiz', $lesson['quiz'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 pt-2">
                        <div class="col-6">
                            <?php if (isset($lesson['id'])): ?>
                                <a class="text-danger"
                                    onclick="return confirm('Anda yakin akan menghapus lesson ini?')"
                                    href="<?= site_url(urlScope() . '/course/' . $course['id'] . '/lesson/' . $lesson['id'] . '/delete') ?>">
                                    <span class="bi bi-trash"></span> Hapus Quiz
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-success shadow"><span class="bi bi-save"></span> Save Quiz</button>
                        </div>
                    </div>

                    </form>

                    <script>
                        $(function() {
                            // Inisialisasi Ace Editor
                            const editor = ace.edit("editor");
                            editor.setTheme("ace/theme/monokai");
                            editor.session.setMode("ace/mode/yaml");

                            // Nonaktifkan scroll di editor
                            editor.setOptions({
                                maxLines: Infinity,
                                autoScrollEditorIntoView: true,
                                highlightActiveLine: true,
                                showPrintMargin: false,
                            });

                            // Auto-resize berdasarkan isi
                            function updateEditor() {
                                const lineHeight = editor.renderer.lineHeight;
                                const lines = editor.session.getLength();
                                const newHeight = lineHeight * lines + 20; // 20 = padding tambahan
                                const editorDiv = document.getElementById('editor');
                                editorDiv.style.height = newHeight + "px";
                                editor.resize();

                                document.getElementById("yaml_quiz").value = editor.getValue();
                            }

                            // Jalankan saat ada perubahan
                            editor.session.on('change', updateEditor);


                            // Set autocomplete.
                            $('.autocomplete').select2();

                            $("#lesson_title").keyup(function() {
                                let title = $(this).val();
                                $("#lesson_slug").val(convertToSlug(title));
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