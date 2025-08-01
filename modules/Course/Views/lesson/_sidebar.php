<div class="col-md-3">
    <div class="sidebar-lesson" style="margin: 0 -15px; padding: 15px;">
        <ul class="lesson-list list-unstyled">
            <?php if ($topics ?? null) : ?>
                <?php foreach ($topics as $topic) : ?>
                    <li class="p-2 mb-3 border shadow">
                        <h6 class="topic-title publish">
                            <?php if ($topic['free']): ?>
                                <span class="bi bi-unlock text-danger"></span>
                            <?php endif; ?>
                            <a href="<?= site_url(urlScope() . '/course/' . $topic['course_id'] . '/topic/' . $topic['id']) ?>"><?= $topic['topic_title'] ?></a>
                        </h6>

                        <div class="mb-2">
                            <a class="btn btn-sm btn-outline-info" href="<?= site_url(urlScope() . '/course/' . $topic['course_id'] . '/topic/' . $topic['id'] . '/theory') ?>" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Material</a>
                            <a class="btn btn-sm btn-outline-info" href="<?= site_url(urlScope() . '/course/' . $topic['course_id'] . '/topic/' . $topic['id'] . '/quiz') ?>" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                        </div>

                        <div class="text-end pl-0 movable-topic">
                            <div class="">
                                <a href="<?= site_url(urlScope() . '/course/' . $topic['course_id'] . '/topic/' . $topic['id'] . '/moveUp') ?>" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                <a href="<?= site_url(urlScope() . '/course/' . $topic['course_id'] . '/topic/' . $topic['id'] . '/moveDown') ?>" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                            </div>
                        </div>

                        <ul class="submenu-lesson-list list-unstyled">
                            <?php if ($topic['lessons'] ?? null) : ?>
                                <?php foreach ($topic['lessons'] as $lesson) : ?>
                                    <li id="lesson-1" class="border publish shadow-sm <?= $lesson['status'] ? '' : 'bg-secondary bg-opacity-10 opacity-50' ?>">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a
                                                    href="<?= site_url(urlScope() . '/course/' . $lesson['course_id'] . '/topic/' . $lesson['topic_id'] . '/' . $lesson['type'] . '/' . $lesson['id']) ?>"
                                                    data-title="<?= $lesson['lesson_title'] ?>">
                                                    <span class="badge bg-info"><?= $lesson['lesson_order'] ?></span>
                                                    <span class="bi text-primary <?= $lesson['type'] === 'quiz' ? 'bi-question-circle' : 'bi-file-earmark-text' ?>"></span>
                                                    <?php if (! $lesson['free']) {
                                                        echo '<span class="bi bi-unlock text-danger"></span>';
                                                    } ?>
                                                    <br>
                                                    <?= $lesson['lesson_title'] ?>
                                                </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/<?= urlScope() ?>/course/moveup_lesson/1/1/1"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/<?= urlScope() ?>/course/movedown_lesson/1/1/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p><em class="text-muted small">Belum ada materi</em></p>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>