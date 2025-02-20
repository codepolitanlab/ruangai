<section id="latest-articles" class="pb-4 pt-4">
    <div class="d-flex px-3 mb-1 justify-content-between">
        <h4 class="m-0 me-auto text-light">Kabar Terbaru</h4>
        <a href="/feeds">
            <small class="fw-bold" style="font-size: 12px;color: #1776B0">
                Lihat Semua
            </small>
        </a>
    </div>
    <div x-show="data.loading" class="swiper swiper-article">
        <div class="swiper-wrapper py-2">
            <template x-for="data in Array(3)">
                <div class="swiper-slide">
                    <img
                    src="https://mobilekit.bragherstudio.com/view29/assets/img/sample/photo/wide0.jpg"
                    class="w-100 rounded-4"
                    alt="feed"
                    />
                </div>
            </template>
        </div>
    </div>

    <template x-if="data.posts">
        <div class="swiper swiper-article" x-init="initSwiperArticles">
            <div class="swiper-wrapper py-2">
                <template x-for="article in data.posts">
                    <div class="swiper-slide">
                        <a :href="article.youtube_url ? `/videos/${ article.id }` : `/feeds/${ article.id }`">
                            <div class="card card-hover rounded-4">
                            <div class="thumbnail-image thumbnail-image-rounded position-relative">
                                    <div class="icon-video" x-show="article.youtube_url">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#EEEEEE" d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                                    </div>
                                    <img :src="article.medias[0].url" :alt="article.title" class="card-img-top swiper-thumbnail-image rounded-4"/>
                                </div>
                                <div class="card-body py-3 px-2" style="min-height: 110px;">
                                    <div class="text-elipsis text-elipsis-3" style="line-height:1.1rem" x-text="article.title"></div>
                                    <small style="font-size: 12px" class="card-text text-muted" x-text="formatDate(article.published_at)"></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </template>
</section>