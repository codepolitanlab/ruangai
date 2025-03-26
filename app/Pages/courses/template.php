<div 
    id="courses" 
    x-data="$heroic({
        title: `<?= $page_title ?>`,
    })">

    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh;">
            <style>
                #appCapsule {
                    padding-top: 0;
                }

                .swiper-slide {
                    height: auto !important;
                }

                .card {
                    height: 100%;
                }

                .page-banner {
                    background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('https://madrasahdigital.id//uploads/madrasahdigital/sources/BG-MD-GD.png');
                    background-size: cover;
                    background-position: top;
                }

                .course-attr {
                    line-height: 18px;
                }
            </style>
            <section>

                <section>
                    <div class="p-2">
                        <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205394.png" class="w-100" alt="">
                        <div class="d-flex gap-3 mt-3">
                            <button class="btn btn-primary w-100 p-3 rounded-pill">
                                <h5 class="m-0">Kelas Online</h5>
                            </button>
                            <a href="/courses/tanya_jawab" class="btn bg-grey w-100 p-3 rounded-pill text-white">
                                <h5 class="m-0">Tanya Jawab</h5>
                            </a>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="container py-4">
                        <div class="d-flex mt-4 mb-2">
                            <h3 class="m-0 me-auto">Lanjutkan Belajar</h3>
                        </div>
                        <a href="/courses/lessons/1">
                            <div class="card rounded-20">
                                <div class="card-body d-flex align-items-center gap-3 p-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-20" style="width: 100px;height: 100px">
                                        <i class="bi bi-journal-bookmark-fill display-3 text-pink"></i>
                                    </div>
                                    <div>
                                        <h4 class="m-0">Lesson 02 - Pengenalan</h4>
                                        <div class="text-muted mb-1">Potensi Dan Tantangan AI</div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-play h3 m-0"></i>
                                            <div style="width: 200px;height: 3px;background-color: #D9D9D9"></div>
                                            <div>100%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex mt-4 mb-2">
                            <h3 class="m-0 me-auto">Materi Belajar</h3>
                        </div>

                        <div class="row">

                            <?php foreach($courses as $course): ?>
                            <div class="col-6 mb-2">
                                <a href="/courses/intro/<?= $course['id'] ?>/<?= $course['slug'] ?>">
                                    <div class="card card-hover rounded-4">
                                        <div class="position-relative">
                                            <img src="<?= $course['thumbnail'] ?>" class="card-img-top rounded-top-4 position-relative" alt="Cover">
                                            <small style="font-size:12px" class="badge bg-secondary rounded-0 position-absolute top-0 start-0 m-2 px-3 rounded-pill"><?= $course['level'] ?></small>
                                        </div>
                                        <div class="card-body py-4 px-2 d-flex flex-column">
                                            <div class="mb-2 text-truncate-2"><?= $course['course_title'] ?></div>
                                            <div class="d-flex flex-column flex-lg-row text-secondary gap-1 mb-auto">
                                                <div class="course-attr d-flex gap-1 me-2 align-items-top"><i class="bi bi-people-fill"></i><small><?= $course['total_student'] ?> Siswa</small></div>
                                                <div class="course-attr d-flex gap-1 align-items-top"><i class="bi bi-journal-bookmark-fill"></i><small><?= $course['total_module'] ?> Modul Belajar</small></div>
                                            </div>
                                        </div>
                                        <!-- <div class="card-footer bg-grey text-center">
                                            <div class="row align-items-center">
                                                <div class="col-9 px-0">
                                                    <div class="progress bg-dark" role="progressbar" style="height: 10px;">
                                                        <div class="progress-bar bg-white" style="width: 25%;height:10px"></div>
                                                    </div>
                                                </div>
                                                <div class="col-3 px-0">
                                                    <div>50%</div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </section>

            </section>
        </div>
    </div>
    <?= $this->include('_bottommenu') ?>
</div>