<div id="tanyaJawab" x-data="tanyaJawab()">

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
                            <a href="/courses" class="btn bg-grey w-100 p-3 rounded-pill">
                                <h3 class="m-0">Kelas Online</h3>
                            </a>
                            <a href="/courses/tanya_jawab" class="btn btn-primary w-100 p-3 rounded-pill text-white">
                                <h3 class="m-0">Tanya Jawab</h3>
                            </a>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="container py-4">
                        <template x-for="article in Array(3)">
                            <div class="card bg-grey rounded-20 p-3 mb-2" style="border: 4px solid rgba(0, 0, 0, 0.9);">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex gap-3 align-items-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/8792/8792047.png" class="rounded-circle" style="width: 50px;height: 50px" alt="">
                                        <div>
                                            <h5 class="m-0 mb-1">Badar Abdi Mulya</h5>
                                            <h6 class="m-0">UI & UX Designer - 04 Maret</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="d-flex btn-primary align-items-center justify-content-center h5 m-0 rounded" style="width: 50px;height: 40px">1</div>
                                        <div class="h6 m-0 text-white">Jawaban</div>
                                    </div>
                                </div>
                                <div class="card-body d-flex align-items-center gap-3 px-1">
                                    <a href="/courses/tanya_jawab/detail/1">
                                        <div class="bg-dark rounded-20 p-3 w-100">
                                            <h5>Tidak dapat menemukan URL Laravel</h5>
                                            <div class="bg-grey p-2 rounded-20 text-muted">
                                                Ditanyakan di kelas <a href="" class="text-pink">Pengembangan Web Fullstack dengan Laravel 11</a>, Topik <a class="text-pink" href="">Setup kebutuhan untuk install project Laravel</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </section>
            </section>
        </div>
    </div>
</div>