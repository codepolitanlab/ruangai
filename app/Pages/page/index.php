<div id="page" x-data="page($router.params.slug)">
    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle" x-text="title"></div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2">
            <div class="page-content p-0 pb-5" x-html="page.content"></div>
        </div>
    </div>
    <!-- * App Capsule -->
</div>