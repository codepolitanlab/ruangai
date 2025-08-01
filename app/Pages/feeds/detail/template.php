<div
    id="feeds_detail"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/feeds/detail/data/${$params.id}`
    })">
    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>
        <div class="pageTitle">Detail Kabar</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="bg-success-2 rounded-bottom-4">
            <div class="section mt-0 p-0" x-show="data.post?.length > 0">
                <div class="border-top pb-3" style="max-width: 640px; margin: 0 auto;">
                    <template x-if="data.post[0].medias">
                    <div
                        class="swiper bg-dark feed-carousel"
                        x-init="new Swiper(`.feed-carousel`, {
                            pagination: {
                            el: `.swiper-pagination`,
                            type: `fraction`,
                            },
                            navigation: {
                                nextEl: `.swiper-button-next`,
                                prevEl: `.swiper-button-prev`,
                            },
                        })">
                        <div class="swiper-wrapper">
                            <template x-for="(media,mediaIndex) in data.post[0]?.medias">
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
                        <img :src="data.post[0]?.avatar ? data.post[0]?.avatar : `${base_url}mobilekit/assets/img/walisantri/avatar/user.png`" alt="image" class="imaged w32 rounded me-1">
                        <span x-text="data.post[0]?.author_name"></span>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <h3 class="card-title mb-1" x-text="data.post[0]?.title"></h3>
                        <div class="text-muted mb-3" x-text="$heroicHelper.formatDate(data.post[0]?.published_at)"></div>
                        <p class="card-text" x-html="$heroicHelper.nl2br(data.post[0]?.content)"></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->
</div>