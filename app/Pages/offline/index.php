<?= $this->extend('template/offline') ?>

<!-- START Content Section -->
<?php $this->section('content') ?>

    <!-- Alpinejs Routers -->
    <div id="app" x-data="{loading:false}">
        <div class="page-content">
            <div id="offline">
                <div class="appHeader">
                    <div class="left">
                    </div>
                    <div class="pageTitle">Koneksi terputus</div>
                    <div class="right">
                    </div>
                </div>

                <!-- App Capsule -->
                <div id="appCapsule">

                    <div class="section mt-2">
                        <div class="page-content p-0 pb-5 text-center">
                            <img src="<?= $themeURL ?>assets/img/icon/offline.png" alt="offline-robot" class="w-100">

                            <a class="btn btn-sm btn-primary" href="<?= site_url(); ?>" x-on:click="loading = true">
                                <span class="spinner-border spinner-border-sm me-1" aria-hidden="true" x-show="loading"></span>
                                Muat Ulang
                            </a>
                        </div>
                    </div>
                </div>
                <!-- * App Capsule -->
            </div>
        </div>
    </div>

<?php $this->endSection() ?>
<!-- END Content Section -->
