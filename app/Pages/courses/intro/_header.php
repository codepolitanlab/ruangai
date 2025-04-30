<section 
    id="course-card-header" 
    class="mb-4 rounded-4 bg-white">
    <div class="position-relative py-3 mt-2 mt-md-3 rounded-top-4"
        style="background: url(https://image.web.id/images/cover-course-min.png); background-size: cover">
        <div class="pb-2 px-4" style="top: 10%;">
            <h2 class="text-white" x-text="data.course?.course_title || 'Belajar AI'"></h2>
            <h6 class="h6 text-white mb-0">Progress belajar</h6>
            <div class="d-flex align-items-center gap-2">
                <div class="progress w-100" style="height: 5px;background: #f5cebb">
                    <div class="progress-bar w-75 bg-secondary"></div>
                </div>
                <div class="text-white">70%</div>
            </div>
        </div>
    </div>

    <?= $this->include('courses/intro/_menu'); ?>
</section>