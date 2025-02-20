<div id="template-container" x-data="home()">
    <div class="appHeader bg-brand">
        <div class="left ps-2">
        </div>
        <div class="pageTitle" x-show="data.logo">
            <img :src="data.logo ? data.logo : `<?= $themeURL ?>assets/img/logo.png`" alt="" style="height: 36px">
        </div>
        <div class="right">
            <!-- <a href="#" class="headerButton toggle-searchbox text-white">
                <ion-icon name="notifications"></ion-icon>
            </a> -->
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="bg-success-2 rounded-bottom-4">
            <img class="d-none d-md-block" :src="Alpine.store('masagi').settings.home_banner_lg" alt="home_banner_large" style="width:100%">
            <img class="d-block d-md-none" :src="Alpine.store('masagi').settings.home_banner_sm" alt="home_banner_mobile" style="width:100%">
        </div>
        <div class="header-large-title my-3" style="position: absolute;top: 55px;">
            <div class="d-flex align-items-center justify-content-start gap-3">
                <div class="use">
                    <div>Ahlan wa sahlan,</div>
                    <div class="h5 m-0" x-text="Alpine.store('masagi').user.name"></div>
                </div>
            </div>
        </div>

        <div class="bg-brand backlayer" style="height:180px"></div>

        <?= $this->include('home/_articles') ?>

        <div class="appFooter pt-5 bg-brand">
            <div class="d-flex justify-content-center"><img src="mobilekit/assets/img/logo-pemuda-min.png" class="logo-pemuda-footer me-2 w-10 mb-3"></div>
            <div class="text-white footer-title">Masagi App © 2024 by Pemuda Persis Bandung Barat</div>
            <div class="text-light"><i class="bi bi-building"></i> Gedung Pusat Dakwah Persatuan Islam (PUSDAPI) Mandalasari, Kec. Cipatat, Kabupaten Bandung Barat, Jawa Barat 40554<br>Kontak: 08986818780</div>
            <div class="mt-2">
                <a href="https://www.instagram.com/pemudapersisbandungbarat" class="btn btn-icon btn-sm btn-instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://api.whatsapp.com/send?phone=628986818780" class="btn btn-icon btn-sm btn-whatsapp" target="_blank"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->
</div>