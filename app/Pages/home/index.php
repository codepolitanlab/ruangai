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
        <!-- Banner -->
        <div class="swiper swiper-banner" x-init="initBannerSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205391.png" class="d-block w-100" alt="...">
                </div>
                <div class="swiper-slide">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205391.png" class="d-block w-100" alt="...">
                </div>
                <div class="swiper-slide">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205391.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>


        <section class="wrapper">
            <section>
                <div class="container py-4 px-0">
                    <div class="d-flex justify-content-between align-items-center px-3 mb-2">
                        <h3 class="m-0 me-auto">Video Terbaru</h3>
                        <a href="https://madrasahdigital.id/pustaka"><small class="text-success fw-bold" style="font-size:10px;">LIHAT SEMUA</small></a>
                    </div>
                    <div class="swiper swiper-video" x-init="initVideoSwiper">
                        <div class="swiper-wrapper py-2">
                            <template x-for="video in data.videos">
                                <div class="swiper-slide card-hover">
                                    <a :href="`https://madrasahdigital.id/pustaka/${ video.id }/${ video.slug }`">
                                        <img :src="video.featured_image" class="w-100 rounded-thumbnail" alt="feed">
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="container py-4 px-0">
                        <div class="d-flex justify-content-between align-items-center px-3 mb-2">
                            <h3 class="m-0 me-auto">Artikel Terbaru</h3>
                            <a href="https://madrasahdigital.id/pustaka"><small class="text-success fw-bold" style="font-size:10px;">LIHAT SEMUA</small></a>
                        </div>
                        <div class="swiper swiper-article" x-init="initArticleSwiper">
                            <div class="swiper-wrapper py-2">
                                <template x-for="article in data.articles">
                                    <div class="swiper-slide">
                                        <a :href="`https://madrasahdigital.id/pustaka/${ article.id }/${ article.slug }`">
                                            <div class="card card-hover bg-grey rounded-4">
                                                <img :src="article.featured_image" class="card-img-top rounded-top-4" alt="...">
                                                <div class="card-body text-white py-3 px-3">
                                                    <div class="text-truncate-2" x-text="article.title"></div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </template>
                            </div>
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