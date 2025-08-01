<div id="feeds_detail" x-data>
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
            <div class="section mt-0 p-0">
                <div class="border-top pb-3" style="max-width: 640px; margin: 0 auto;">
                    <div class="swiper bg-dark feed-carousel">
                        <div class="swiper-wrapper">
                            <?php foreach ($post[0]['medias'] as $media): ?>
                            <div class="swiper-slide">
                                <img src="<?= $media['url'] ?>" class="vw-100" alt="image">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination shadow-sm"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <div class="card-header px-3 pt-2 pb-1">
                        <img src="<?= $post[0]['avatar'] ?: base_url('mobilekit/assets/img/walisantri/avatar/user.png'); ?>" alt="image" class="imaged w32 rounded me-1">
                        <span><?= $post[0]['author_name'] ?></span>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <h3 class="card-title mb-1"><?= $post[0]['title'] ?></h3>
                        <div class="text-muted mb-3"><?= date('d M Y', strtotime($post[0]['published_at'])) ?></div>
                        <p class="card-text"><?= nl2br($post[0]['content']) ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->
</div>