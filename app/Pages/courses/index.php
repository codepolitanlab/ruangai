<div id="course_detail" x-data="course_detail()">
    <div id="app-header" class="appHeader main">
        <div class="left"></div>
        <div class="pageTitle"><img src="https://madrasahdigital.id//uploads/madrasahdigital/sources/logo-md-landscape-min.png" alt="Madrasah Digital" style="height:38px;"></div>

    </div>

    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh;">
            <style>
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
            <section x-data="courses()" x-init="initialize()">
                <section class="page-banner pt-3">
                    <div class="container p-4">
                        <div class="row align-items-center mb-5 text-white">
                            <div class="col-9">
                                <h2 class="text-white fw-bold m-0 text-uppercase">Kelas Online</h2>
                                <p class="m-0">Kelas online belajar mandiri dan terarah</p>
                            </div>
                            <div class="col-3 text-end"><img src="https://madrasahdigital.id/views/madrasahdigital/assets/img/kelas/icon/kelas.png" class="w-75" alt=""></div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="container py-4">
                        <div class="d-flex mt-4 mb-2">
                            <h5 class="m-0 me-auto">Kelas Populer</h5>
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
                        <div class="swiper swiper-course swiper-initialized swiper-horizontal swiper-backface-hidden">
                            <div class="swiper-wrapper py-2" id="swiper-wrapper-222821eba3ab5feb" aria-live="off">
                                <template x-for="course in data.courses">
                                    <div class="swiper-slide"><a :href="`https://madrasahdigital.id/courses/intro/${ course.slug }`">
                                            <div class="card card-hover rounded-4">
                                                <div class="position-relative">
                                                    <img src="course.cover" class="card-img-top rounded-top-4 position-relative" alt="Cover">
                                                    <small style="font-size:12px" class="badge bg-primary rounded-0 position-absolute bottom-0 end-0" x-text="course.level"></small>
                                                </div>
                                                <div class="card-body py-2 px-2 d-flex flex-column"><small style="font-size:12px;line-height:18px;" class="card-text my-2" x-text="course.author"></small>
                                                    <div class="mb-2 text-truncate-2"></div>
                                                    <div class="d-flex flex-column flex-lg-row text-secondary gap-1 mb-auto">
                                                        <div class="course-attr d-flex gap-1 me-2 align-items-top"><i class="bi bi-clock"></i><small></small></div>
                                                        <div class="course-attr d-flex gap-1 align-items-top"><i class="bi bi-file-play"></i><small></small></div>
                                                    </div>
                                                    <div><button class="btn btn-outline-primary btn-sm rounded-pill rounded-pill mb-2 mt-3"><del class="me-2 text-muted" x-show="parseInt(course.strike_price)>0" x-text="priceCourse(course.strike_price)"></del><span x-text="priceCourse(course.price)"></span></button></div>
                                                </div>
                                            </div>
                                        </a></div>
                                </template>
                                <div class="swiper-slide swiper-slide-active" style="width: 225.312px; margin-right: 10px;" role="group" aria-label="1 / 1">
                                    <a href="/courses/intro/inggris-beginner-book-1">
                                        <div class="card card-hover rounded-4">
                                            <div class="position-relative">
                                                <img src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png" class="card-img-top rounded-top-4 position-relative" alt="Cover" src="https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png">
                                                <small style="font-size:12px" class="badge bg-primary rounded-0 position-absolute bottom-0 end-0">beginner</small>
                                            </div>
                                            <div class="card-body py-2 px-2 d-flex flex-column"><small style="font-size:12px;line-height:18px;" class="card-text my-2" x-text="course.author"></small>
                                                <div class="mb-2 text-truncate-2">Ngonten Sakti dengan AI</div>
                                                <div class="d-flex flex-column flex-lg-row text-secondary gap-1 mb-auto">
                                                    <div class="course-attr d-flex gap-1 me-2 align-items-top"><i class="bi bi-clock"></i><small>8 jam 54 Menit</small></div>
                                                    <div class="course-attr d-flex gap-1 align-items-top"><i class="bi bi-file-play"></i><small>50 Modul</small></div>
                                                </div>
                                                <div><button class="btn btn-outline-primary btn-sm rounded-pill rounded-pill mb-2 mt-3"><del class="me-2 text-muted">Rp&nbsp;500.000</del><span>Rp&nbsp;225.000</span></button></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
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