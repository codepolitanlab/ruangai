<div 
    id="courses" 
    x-data="$heroic({
        title: `<?= $page_title ?>`,
    })">

    <div id="appCapsule">
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
                        <div class="position-relative">
                            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%205231%20(1).png" class="w-100 position-relative" alt="">
                            <div class="position-absolute start-0 m-2" style="top: 50px;">
                                <h5 class="text-white mb-1">RuangAI</h5>
                                <div class="text-white">Belajar mandiri secara <br> online dan terarah</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                            <a href="#" class="btn btn-sm btn-primary w-100 p-3 rounded-pill">
                                <div class="m-0 h6 text-white">Kelas Online</div>
                            </a>
                            <a href="/courses/tanya_jawab" class="btn btn-ultra-light-primary w-100 p-3 rounded-pill">
                                <div class="m-0 h6 text-primary">Tanya Jawab</div>
                            </a>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="container p-3 p-lg-4">
                        <div class="d-flex mb-2">
                            <h4 class="m-0 me-auto">Lanjutkan Belajar</h4>
                        </div>
                        <a href="/courses/lessons/1">
                            <div class="card card-hover rounded-20">
                                <div class="card-body d-flex align-items-center gap-3 p-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-20 bg-ultra-light" style="width: 100px;height: 100px">
                                        <i class="bi bi-journal-bookmark-fill display-3 text-pink"></i>
                                    </div>
                                    <div>
                                        <h4 class="m-0">Lesson 02 - Pengenalan</h4>
                                        <h6 class="mb-1">Potensi Dan Tantangan AI</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-play h3 m-0"></i>
                                            <div style="width: 100%;height: 3px;background-color: #D9D9D9"></div>
                                            <div>100%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex mt-4 mb-2">
                            <h4 class="m-0 me-auto">Materi Belajar</h4>
                        </div>

                        <div class="row">

                            <!-- if data not found -->

                            <?php if(count($courses) == 0):?>
                            <div class="col-12">
                                <div class="card card-hover rounded-4">
                                    <div class="card-body py-4 px-2 d-flex flex-column">
                                        <h6 class="mb-0 text-truncate text-center">Belum Ada Materi Belajar</h6>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php foreach($courses as $course): ?>
                            <div class="col-6 mb-2">
                                <a href="/courses/intro/<?= $course['id'] ?>/<?= $course['slug'] ?>">
                                    <div class="card card-hover rounded-4">
                                        <div class="position-relative">
                                            <img src="<?= $course['thumbnail'] ?>" class="card-img-top rounded-top-4 position-relative" alt="Cover">
                                            <small style="font-size:12px" class="badge bg-secondary rounded-0 position-absolute top-0 start-0 m-2 px-3 rounded-pill"><?= $course['level'] ?></small>
                                        </div>
                                        <div class="card-body py-4 px-2 d-flex flex-column">
                                            <h5 class="mb-2 text-truncate"><?= $course['course_title'] ?></h5>
                                            <div class="d-flex flex-column flex-lg-row text-secondary gap-1 mb-auto">
                                                <div class="course-attr d-flex gap-1 me-2 align-items-top"><i class="bi bi-people-fill"></i><small><?= $course['total_student'] ?> Siswa</small></div>
                                                <div class="course-attr d-flex gap-1 align-items-top"><i class="bi bi-journal-bookmark-fill"></i><small><?= $course['total_module'] ?> Modul Belajar</small></div>
                                            </div>
                                        </div>
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