<div class="mb-3">
    <div class="row">
        <div class="col">
            <h2>
                Materi untuk: <?= $course['course_title'] ?>
                <a class="ms-2 btn btn-sm btn-white text-dark" title="Edit course settings" href="<?= site_url("/zpanel/course/edit/".$course['id']) ?>"><span class="bi bi-pencil"></span> Edit</a>
                <a class="btn btn-sm btn-white text-dark" target="_blank" title="Preview course" href="<?= site_url("/courses/intro/".$course['id']."/".$course['slug']."?preview=true") ?>"><span class="bi bi-external-link"></span> Preview</a>
            </h2>
        </div>
    </div>
</div>