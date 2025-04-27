<?= $this->include('_appHeader'); ?>

<!-- <div id="app-header" class="appHeader main border-0">
    <div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
    <div class="pageTitle"><span>Detail Kelas</span></div>
    <div class="right"><a class="headerButton" role="button" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas"><i class="bi bi-share-fill me-1"></i></a></div>
</div> -->

<section>
    <div class="position-relative" style="background:#c9e5f0">
        <img src="https://image.web.id/images/cover-course.png" class="w-100 position-relative" alt="">
        <div class="position-absolute bottom-0 pb-2 px-4">
            <h2 class="text-white" x-text="data.course?.course_title || 'Belajar AI'"></h2>
            <div class="text-white d-flex gap-4 mb-2">
                <div><i class="bi bi-people"></i> <span x-text="data.course?.total_student"></span> Siswa</div>
                <div><i class="bi bi-book"></i> <span x-text="data.course?.total_module"></span> Modul Belajar</div>
            </div>
        </div>
    </div>
</section>