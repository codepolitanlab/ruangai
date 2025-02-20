<div id="kajian" x-data="kajian()">
    <div class="appHeader bg-brand">
        <div class="left ps-2">
        </div>
        <div class="pageTitle text-white">Kajian</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="bg-success-2 rounded-bottom-4 pb-5" style="height: 150px; margin-bottom: 100px">

            <div class="section mt-0 p-0" style="max-width:470px;margin:auto">
                <template x-for="(article,articleIndex) in videos">
                    <div>
                        <a href="javascript:void()" x-on:click="showDetail(articleIndex)">
                            <div class="thumbnail-image position-relative">
                                <div class="icon-video" x-show="article.youtube_url">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#EEEEEE" d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                                </div>
                                <img :src="article.medias[0].url" :alt="article.title" class="w-100 scroll-thumbnail-video"/>
                            </div>
                        </a>
                        <div class="d-flex px-2 pt-2 pb-4 bg-white">
                            <div>
                                <img :src="article.avatar ? article.avatar : `${base_url}mobilekit/assets/img/walisantri/avatar/user.png`" alt="image" class="imaged w48 rounded me-2">
                            </div>
                            <div>
                                <a href="javascript:void()" x-on:click="showDetail(articleIndex)">
                                    <h5 class="card-title fs-6 text-dark" x-text="article.title"></h5>
                                </a>
                                <span x-text="article.author_name"></span> &bull;
                                <small class="text-muted" x-text="formatDate(article.published_at)"></small>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="text-center">
                    <button type="button" class="btn btn-outline-secondary my-3" x-show="!empty" x-on:click="loadMore">Muat lainnya</button>
                    <p class="my-3 py-3" x-show="empty">Tidak ada post lain.</p>
                </div>

            </div>
            <hr class="pb-5">
        </div>

    </div>
    <!-- * App Capsule -->
</div>