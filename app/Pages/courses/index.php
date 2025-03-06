<div id="courses" x-data="courses()">

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
                                <h3 class="m-0">Kelas Online</h3>
                            </button>
                            <a href="/courses/tanya_jawab" class="btn bg-grey w-100 p-3 rounded-pill text-white">
                                <h3 class="m-0">Tanya Jawab</h3>
                            </a>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="container py-4">
                        <div class="d-flex mt-4 mb-2">
                            <h3 class="m-0 me-auto">Lanjutkan Belajar</h3>
                        </div>
                        <div class="card bg-grey rounded-20" style="border: 4px solid rgba(0, 0, 0, 0.9);">
                            <div class="card-body d-flex align-items-center gap-3 p-2">
                                <div class="bg-dark d-flex align-items-center justify-content-center rounded-20" style="width: 100px;height: 100px">
                                    <i class="bi bi-journal-bookmark-fill display-3 text-pink"></i>
                                </div>
                                <div>
                                    <h4 class="m-0">Lesson 02 - Pengenalan</h4>
                                    <div class="text-muted mb-1">Potensi Dan Tantangan AI</div>
                                    <div class="d-flex align-items-center gap-2 text-white">
                                        <i class="bi bi-play h3 m-0"></i>
                                        <div style="width: 200px;height: 3px;background-color: #fff;"></div>
                                        <div>100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-4 mb-2">
                            <h3 class="m-0 me-auto">Materi Belajar</h3>
                        </div>
                        <div x-show="data.loading" class="swiper swiper-course swiper-initialized swiper-horizontal swiper-backface-hidden" style="display: none;">
                            <div class="swiper-wrapper py-2" id="swiper-wrapper-f4c6b56f56c8628b" aria-live="off"><template x-for="data in Array(3)">
                                    <div class="swiper-slide">
                                        <div class="card rounded-4"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="card-img-top rounded-top-4" alt="Cover">
                                            <div class="card-body py-2 px-2 placeholder-glow">
                                                <div class="mb-2"><span class="placeholder col-6 me-3"></span><span class="placeholder col-5 rounded-pill"></span></div>
                                                <div class="mb-2"><span class="placeholder col-8"></span></div>
                                                <div class="mb-3"><span class="placeholder col-5 me-3"></span><span class="placeholder col-5"></span></div>
                                                <div><span class="placeholder col-4 rounded-pill"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="swiper-slide swiper-slide-active" style="width: 225.312px; margin-right: 10px;" role="group" aria-label="1 / 3">
                                    <div class="card rounded-4"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="card-img-top rounded-top-4" alt="Cover">
                                        <div class="card-body py-2 px-2 placeholder-glow">
                                            <div class="mb-2"><span class="placeholder col-6 me-3"></span><span class="placeholder col-5 rounded-pill"></span></div>
                                            <div class="mb-2"><span class="placeholder col-8"></span></div>
                                            <div class="mb-3"><span class="placeholder col-5 me-3"></span><span class="placeholder col-5"></span></div>
                                            <div><span class="placeholder col-4 rounded-pill"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide swiper-slide-next" style="width: 225.312px; margin-right: 10px;" role="group" aria-label="2 / 3">
                                    <div class="card rounded-4"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="card-img-top rounded-top-4" alt="Cover">
                                        <div class="card-body py-2 px-2 placeholder-glow">
                                            <div class="mb-2"><span class="placeholder col-6 me-3"></span><span class="placeholder col-5 rounded-pill"></span></div>
                                            <div class="mb-2"><span class="placeholder col-8"></span></div>
                                            <div class="mb-3"><span class="placeholder col-5 me-3"></span><span class="placeholder col-5"></span></div>
                                            <div><span class="placeholder col-4 rounded-pill"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide" style="width: 225.312px; margin-right: 10px;" role="group" aria-label="3 / 3">
                                    <div class="card rounded-4"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="card-img-top rounded-top-4" alt="Cover">
                                        <div class="card-body py-2 px-2 placeholder-glow">
                                            <div class="mb-2"><span class="placeholder col-6 me-3"></span><span class="placeholder col-5 rounded-pill"></span></div>
                                            <div class="mb-2"><span class="placeholder col-8"></span></div>
                                            <div class="mb-3"><span class="placeholder col-5 me-3"></span><span class="placeholder col-5"></span></div>
                                            <div><span class="placeholder col-4 rounded-pill"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="/courses/intro/inggris-beginner-book-1">
                                    <div class="card card-hover rounded-4">
                                        <div class="position-relative">
                                            <img src="https://media.istockphoto.com/id/2179714888/id/foto/tangan-digital-dalam-seni-konsep-koneksi-jaringan-futuristik.jpg?s=612x612&w=0&k=20&c=nIGL-f-lPT3cmcqI58ENrUmrAMQH1ahQyct1FvqZIzY=" class="card-img-top rounded-top-4 position-relative" alt="Cover" src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png">
                                            <small style="font-size:12px" class="badge bg-secondary rounded-0 position-absolute top-0 start-0 m-2 px-3 rounded-pill">Batch 1</small>
                                        </div>
                                        <div class="card-body py-4 px-2 d-flex flex-column bg-dark">
                                            <small style="font-size:12px;line-height:18px;" class="card-text" x-text="course.author"></small>
                                            <div class="mb-2 text-truncate-2 text-white">Ngonten Sakti dengan AI</div>
                                            <div class="d-flex flex-column flex-lg-row text-secondary gap-1 mb-auto">
                                                <div class="course-attr d-flex gap-1 me-2 align-items-top"><i class="bi bi-people-fill"></i><small>120 Siswa</small></div>
                                                <div class="course-attr d-flex gap-1 align-items-top"><i class="bi bi-journal-bookmark-fill"></i><small>50 Modul Belajar</small></div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-grey text-center">
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
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/courses/intro/inggris-beginner-book-1">
                                    <div class="card card-hover rounded-4">
                                        <div class="position-relative">
                                            <img src="https://media.istockphoto.com/id/2179714888/id/foto/tangan-digital-dalam-seni-konsep-koneksi-jaringan-futuristik.jpg?s=612x612&w=0&k=20&c=nIGL-f-lPT3cmcqI58ENrUmrAMQH1ahQyct1FvqZIzY=" class="card-img-top rounded-top-4 position-relative" style="filter: grayscale(100%);" alt="Cover">
                                            <small style="font-size:12px" class="badge bg-secondary rounded-0 position-absolute top-0 start-0 m-2 px-3 rounded-pill">Batch 2</small>
                                        </div>
                                        <div class="card-body py-4 px-2 d-flex flex-column bg-dark">
                                            <small style="font-size:12px;line-height:18px;" class="card-text" x-text="course.author"></small>
                                            <div class="mb-2 text-truncate-2 text-white">Explore AI</div>
                                            <div class="d-flex flex-column flex-lg-row text-secondary gap-1 mb-auto">
                                                <div class="course-attr d-flex gap-1 me-2 align-items-top"><i class="bi bi-people-fill"></i><small>120 Siswa</small></div>
                                                <div class="course-attr d-flex gap-1 align-items-top"><i class="bi bi-journal-bookmark-fill"></i><small>50 Modul Belajar</small></div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-grey text-center">
                                            <h5 class="m-0">Locked <i class="bi bi-lock-fill"></i></h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0"><button type="button" class="btn ms-auto" data-bs-dismiss="modal" aria-label="Close">X</button></div>
                            <div class="modal-body">
                                <div class="input-group"><input type="text" class="form-control bg-transparent border border-end-0 searching" placeholder="Tulis Judul"><span class="input-group-text  border border-start-0 px-2 rounded-end-3" id="basic-addon1"><i class="bi bi-search"></i></span></div><template x-for="course in data.courses">
                                    <div class="row rounded-4 my-3">
                                        <div class="col-3 ps-0"><img src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png" class="w-100 rounded-4 h-100" alt="..."></div>
                                        <div class="col-9"><small style="font-size:12px" class="card-text text-secondary">Yudha Pangesti</small>
                                            <div class="mb-2"></div>
                                            <div class="d-flex align-items-center text-secondary gap-3">
                                                <div class="d-flex gap-2 align-items-center"><i class="bi bi-clock"></i><small></small></div>
                                                <div class="d-flex gap-2 align-items-center"><i class="bi bi-clock"></i><small></small></div>
                                            </div><button class="btn btn-outline-primary btn-sm rounded-pill rounded-pill mb-2 mt-3"><del class="me-2 text-muted" x-show="parseInt(course.strike_price)>0" x-text="priceCourse(course.strike_price)"></del><span x-text="priceCourse(course.price)"></span></button>
                                        </div>
                                    </div>
                                </template>
                                <div class="row rounded-4 my-3">
                                    <div class="col-3 ps-0"><img src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png" class="w-100 rounded-4 h-100" alt="..." src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png"></div>
                                    <div class="col-9"><small style="font-size:12px" class="card-text text-secondary">Yudha Pangesti</small>
                                        <div class="mb-2">Ngonten Sakti dengan AI</div>
                                        <div class="d-flex align-items-center text-secondary gap-3">
                                            <div class="d-flex gap-2 align-items-center"><i class="bi bi-clock"></i><small>8 jam 54 Menit</small></div>
                                            <div class="d-flex gap-2 align-items-center"><i class="bi bi-clock"></i><small>50 Modul</small></div>
                                        </div><button class="btn btn-outline-primary btn-sm rounded-pill rounded-pill mb-2 mt-3"><del class="me-2 text-muted" x-show="parseInt(course.strike_price)>0" x-text="priceCourse(course.strike_price)">Rp&nbsp;500.000</del><span x-text="priceCourse(course.price)">Rp&nbsp;225.000</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>