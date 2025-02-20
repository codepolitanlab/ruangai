<div id="feeds_detail" x-data="feeds_detail($router.params.id)">
    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Detail Kabar</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="bg-success-2 rounded-bottom-4">
            <div class="section mt-0 p-0" x-show="feed.length > 0">
                <div class="border-top pb-3" style="max-width: 640px; margin: 0 auto;">
                    <template x-if="feed[0].medias">
                    <div class="swiper bg-dark feed-carousel" x-init="initFeedSwiper()">
                        <div class="swiper-wrapper">
                            <template x-for="(media,mediaIndex) in feed[0].medias">
                            <div class="swiper-slide">
                                <img :src="media.url" class="vw-100" alt="image">
                            </div>
                            </template>
                        </div>
                        <div class="swiper-pagination shadow-sm"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    </template>
                    <div class="card-header px-3 pt-2 pb-1">
                        <img :src="feed[0]?.avatar ? feed[0]?.avatar : `${base_url}mobilekit/assets/img/walisantri/avatar/user.png`" alt="image" class="imaged w32 rounded me-1">
                        <span x-text="feed[0]?.author_name"></span>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <h3 class="card-title mb-1" x-text="feed[0]?.title"></h3>
                        <div class="text-muted mb-3" x-text="formatDate(feed[0]?.published_at)"></div>
                        <p class="card-text" x-html="nl2br(feed[0]?.content)"></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->
</div>