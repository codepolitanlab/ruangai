<div 
    id="course_intro" 
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        getUrl: `/courses/intro/data/${$router.params.id}`
    })">
    <div id="app-header" class="appHeader main glassmorph border-0">
        <div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
        <div class="pageTitle"><span>Detail Kelas</span></div>
        <div class="right"><a class="headerButton" role="button" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas"><i class="bi bi-share-fill me-1"></i></a></div>
    </div>

    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh">
            <style>
                .accordion-body {
                    padding: 0 .25rem;
                }

                .list-group-item {
                    border: 0;
                }

                .accordion-body,
                .accordion-body .list-group-item {
                    background: #fff !important;
                }

                .hovered:hover {
                    background: #eee !important;
                }

                .cover {
                    object-fit: cover;
                    width: 100%;
                    height: 100%;
                }

                .progress,
                .progress-bar {
                    height: 22px;
                }

                .lessons a {
                    color: #009688;
                    font-weight: 400;
                    font-size: 1rem;
                }

                .author img {
                    width: 80px;
                }
            </style>
            <section class="my-2">
                <div class="position-relative">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205231.png" class="w-100 position-relative" alt="">
                    <div class="position-absolute ms-3" style="top: 18%;">
                        <h2 x-text="data.course?.course_title"></h2>
                        <div class="d-flex gap-4 mb-2">
                            <div><i class="bi bi-people"></i> <span x-text="data.course?.total_student"></span> Siswa</div>
                            <div><i class="bi bi-book"></i>  <span x-text="data.course?.total_module"></span> Modul Belajar</div>
                        </div>
                        <div class="progress mb-3" role="progressbar" style="height: 8px;">
                            <div class="progress-bar bg-secondary" style="width: 25%"></div>
                        </div>
                        <a href="" class="btn btn-sm btn-primary rounded-pill">Lanjutkan Belajar</a>
                    </div>
                </div>
            </section>
            <section>
                <div class="container px-4">
                    <div>
                        <h2>Deskripsi Singkat</h2>
                        <p x-text="data.course?.description"></p>
                    </div>
                    <div class="d-flex gap-3 mt-2 overflow-scroll py-3">
                        <a href="#" class="btn btn-lg btn-primary text-nowrap rounded-pill">Materi Belajar</a>
                        <a href="/courses/intro/inggris-beginner-book-1/live_session" class="btn btn-lg bg-grey text-nowrap rounded-pill text-white position-relative">
                            Live Session
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </a>
                        <a href="/courses/intro/inggris-beginner-book-1/student" class="btn btn-lg bg-grey text-nowrap rounded-pill text-white">Student</a>
                        <a href="/courses/intro/inggris-beginner-book-1/tanya_jawab" class="btn btn-lg bg-grey text-nowrap rounded-pill text-white">Tanya Jawab</a>
                    </div>
                </div>
            </section>
            <section>
                <div class="container px-4">
                    <div class="card rounded-20 p-3 mb-2" >
                        <h3 class="m-0">Pengenalan</h3>
                        <div class="card-body d-flex flex-column align-items-center gap-3 px-1">
                            <template x-for="lesson of data.course?.lessons">
                                <a x-bind:href="`/courses/lessons/${lesson.id}`" class="d-block w-100 card-hover">
                                    <div class="rounded-20 p-3 w-100 d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="m-0 mb-1" x-text="lesson.lesson_title"></h4>
                                            <h5 class="m-0 text-secondary" x-text="lesson.duration"></h5>
                                        </div>
                                        <div>
                                            <i class="bi bi-lock-fill h4 m-0 text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small"></div>
    </div>
    <?= $this->include('_bottommenu') ?>
</div>

