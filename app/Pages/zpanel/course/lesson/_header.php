<div class="mb-3">
    <div class="row">
        <div class="col">
            <h2 class="d-flex">
                <div>
                    <a href="<?= site_url("/zpanel/course") ?>"><i class="bi bi-house"></i></a>
                    &middot;
                    <?= $course['course_title'] ?>
                </div>

                <div class="ms-auto">
                    <a class="ms-2 btn btn-sm btn-outline-secondary"
                        title="Edit course settings"
                        href="<?= site_url("/zpanel/course/edit/" . $course['id']) ?>">
                        <span class="bi bi-pencil"></span> Edit Course
                    </a>
                    <a class="btn btn-sm btn-outline-secondary"
                        target="_blank"
                        title="Preview course"
                        href="<?= site_url("/courses/intro/" . $course['id'] . "/" . $course['slug'] . "?preview=true") ?>">
                        <i class="bi bi-box-arrow-up-right"></i> Preview
                    </a>
                    <a class="btn btn-sm btn-secondary"
                    title="Add topic"
                    href="<?= site_url("/zpanel/course/lesson/topic/" . $course['id']) ?>">
                    <span class="bi bi-tag"></span> Create Topic
                </a>
            </div>
            </h2>
        </div>
    </div>
</div>