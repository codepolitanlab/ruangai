<div id="template-container" class="bg-dark" x-data="home()">

    <style>

    </style>

    <div class="appHeader bg-dark">
        <div class="left ps-2">
        </div>
        <div class="pageTitle ">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/RuangAI.png?updatedAt=1741075465937" alt="">
        </div>
        <!-- <div class="right">
            <a href="#" class="headerButton toggle-searchbox text-white">
                <ion-icon name="notifications"></ion-icon>
            </a>
        </div> -->
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205392.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205392.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205392.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


        <section class="wrapper">
            <section>
                <div class="container py-4 px-0">
                    <div class="d-flex justify-content-between align-items-center px-4 mb-2">
                        <h6 class="m-0 me-auto">Video Terbaru</h6>
                        <a href="https://madrasahdigital.id/pustaka"><small class="text-success fw-bold" style="font-size:10px;">LIHAT SEMUA</small></a>
                    </div>
                    <div x-show="data.loading" class="swiper swiper-video swiper-initialized swiper-horizontal swiper-backface-hidden" style="display: none;">
                        <div class="swiper-wrapper py-2" style="transition-duration: 300ms; transform: translate3d(-306.545px, 0px, 0px);" id="swiper-wrapper-dbc0aae33c12a151" aria-live="off">
                            <template x-for="data in Array(3)">
                                <div class="swiper-slide">
                                    <img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed">
                                </div>
                            </template>
                            <div class="swiper-slide swiper-slide-prev" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="1 / 3"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed"></div>
                            <div class="swiper-slide swiper-slide-active" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="2 / 3"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed"></div>
                            <div class="swiper-slide swiper-slide-next" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="3 / 3"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed"></div>
                        </div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                    <div class="swiper swiper-video swiper-initialized swiper-horizontal swiper-backface-hidden" x-init="initVideoSwiper">
                        <div class="swiper-wrapper py-2" id="swiper-wrapper-f8ee689c3789bef1" aria-live="off" style="transition-duration: 0ms; transform: translate3d(-338.182px, 0px, 0px); transition-delay: 0ms;">
                            <template x-for="video in data.videos">
                                <div class="swiper-slide card-hover">
                                    <a :href="`https://madrasahdigital.id/pustaka/${ video.id }/${ video.slug }`">
                                        <img :src="video.featured_image" class="w-100" alt="feed">
                                    </a>
                                </div>
                            </template>
                            <div class="swiper-slide card-hover swiper-slide-prev" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="1 / 4">
                                <a href="https://madrasahdigital.id/pustaka/11/desain-bangunan-pesantren-it-dan-tahfidz-madrasah-digital">
                                    <img class="w-100 rounded-thumbnail" alt="feed" src="https://madrasahdigital.id//uploads/madrasahdigital/sources/desain-bangunan-pesantren.jpg">
                                </a>
                            </div>
                            <div class="swiper-slide card-hover swiper-slide-active" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="2 / 4">
                                <a href="https://madrasahdigital.id/pustaka/10/laporan-pengurugan-tanah-pesantren-madrasah-digital">
                                    <img class="w-100 rounded-thumbnail" alt="feed" src="https://madrasahdigital.id//uploads/madrasahdigital/sources/pengurugan-tanah-pesantren.jpg">
                                </a>
                            </div>
                            <div class="swiper-slide card-hover swiper-slide-next" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="3 / 4">
                                <a href="https://madrasahdigital.id/pustaka/9/laporan-pembangunan-jalan-dan-jembatan-pesantren-madrasah-digital">
                                    <img class="w-100 rounded-thumbnail" alt="feed" src="https://madrasahdigital.id//uploads/madrasahdigital/sources/jalan-pesantren.jpg">
                                </a>
                            </div>
                            <div class="swiper-slide card-hover" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="4 / 4">
                                <a href="https://madrasahdigital.id/pustaka/8/jurnal-pembangunan-pesantren">
                                    <img class="w-100 rounded-thumbnail" alt="feed" src="https://madrasahdigital.id//uploads/madrasahdigital/sources/pesantren-it-dan-tahfidz.jpg">
                                </a>
                            </div>
                        </div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            </section>
            <section>
                <div class="container py-4 px-0">
                    <div class="d-flex justify-content-between align-items-center px-4 mb-2">
                        <h6 class="m-0 me-auto">Artikel Terbaru</h6>
                        <a href="https://madrasahdigital.id/pustaka"><small class="text-success fw-bold" style="font-size:10px;">LIHAT SEMUA</small></a>
                    </div>
                    <div x-show="data.loading" class="swiper" style="display: none;">
                        <div class="swiper-wrapper py-2">
                            <template x-for="data in Array(3)">
                                <div class="swiper-slide">
                                    <img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed">
                                </div>
                            </template>
                            <div class="swiper-slide"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed"></div>
                            <div class="swiper-slide"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed"></div>
                            <div class="swiper-slide"><img src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg" class="w-100 rounded-4" alt="feed"></div>
                        </div>
                    </div>
                    <div class="swiper swiper-article swiper-initialized swiper-horizontal swiper-backface-hidden" x-init="initArticleSwiper">
                        <div class="swiper-wrapper py-2" id="swiper-wrapper-bb7435cb1099d13e5" aria-live="polite" style="transition-duration: 0ms; transform: translate3d(20px, 0px, 0px); transition-delay: 0ms;">
                            <template x-for="article in data.articles">
                                <div class="swiper-slide">
                                    <a :href="`https://madrasahdigital.id/pustaka/${ article.id }/${ article.slug }`">
                                        <div class="card card-hover rounded-4">
                                            <img :src="article.featured_image" class="card-img-top rounded-top-4" alt="...">
                                            <div class="card-body py-3 px-2">
                                                <div class="mb-2 text-truncate-2" x-text="article.title"></div><small style="font-size:12px" class="card-text" x-text="article.custom_author ?? article.author_name"></small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </template>
                            <div class="swiper-slide swiper-slide-active" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="1 / 3">
                                <a :href="`https://madrasahdigital.id/pustaka/${ article.id }/${ article.slug }`" href="https://madrasahdigital.id/pustaka/7/daftar-lengkap-sumber-cuan-content-creator">
                                    <div class="card card-hover rounded-4">
                                        <img class="card-img-top rounded-top-4" alt="..." src="https://ik.imagekit.io/56xwze9cy/ruangai/Mask%20group.png?updatedAt=1741074377480">
                                        <div class="card-body py-3 px-2">
                                            <div class="mb-2 text-truncate-2 text-white">Sumber Cuan Para Content Creator</div><small style="font-size:12px" class="card-text" x-text="article.custom_author ?? article.author_name"></small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide swiper-slide-next" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="2 / 3">
                                <a :href="`https://madrasahdigital.id/pustaka/${ article.id }/${ article.slug }`" href="https://madrasahdigital.id/pustaka/2/wawasan-digital">
                                    <div class="card card-hover rounded-4">
                                        <img class="card-img-top rounded-top-4" alt="..." src="https://ik.imagekit.io/56xwze9cy/ruangai/Mask%20group.png?updatedAt=1741074377480">
                                        <div class="card-body py-3 px-2">
                                            <div class="mb-2 text-truncate-2 text-white">Apa yang Dimaksud dengan Digital-Savvy?</div><small style="font-size:12px" class="card-text" x-text="article.custom_author ?? article.author_name"></small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide" style="width: 338.182px; margin-right: 20px;" role="group" aria-label="3 / 3">
                                <a :href="`https://madrasahdigital.id/pustaka/${ article.id }/${ article.slug }`" href="https://madrasahdigital.id/pustaka/1/tokoh-muslim-dunia">
                                    <div class="card card-hover rounded-4">
                                        <img class="card-img-top rounded-top-4" alt="..." src="https://ik.imagekit.io/56xwze9cy/ruangai/Mask%20group.png?updatedAt=1741074377480">
                                        <div class="card-body py-3 px-2">
                                            <div class="mb-2 text-truncate-2 text-white">Ismail Al-Jazari Ilmuwan Muslim Bapak Robotika Dunia</div><small style="font-size:12px" class="card-text" x-text="article.custom_author ?? article.author_name"></small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            </section>
        </section>


        <div class="appFooter pt-5 border-0">
            <div class="d-flex justify-content-center">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/RuangAI.png?updatedAt=1741075465937" class="logo-pemuda-footer mb-1">
            </div>
            <div class="text-white footer-title h6">© RuangAI 2025</div>
            <div class="mt-2">
                <a href="https://www.instagram.com/pemudapersisbandungbarat" class="btn btn-icon btn-sm btn-instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://api.whatsapp.com/send?phone=628986818780" class="btn btn-icon btn-sm btn-youtube" target="_blank"><i class="bi bi-youtube"></i></a>
                <a href="https://api.whatsapp.com/send?phone=628986818780" class="btn btn-icon btn-sm btn-twitter" target="_blank"><i class="bi bi-twitter"></i></a>
                <a href="https://api.whatsapp.com/send?phone=628986818780" class="btn btn-icon btn-sm btn-whatsapp" target="_blank"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>

    </div>

    <!-- * App Capsule -->
</div>