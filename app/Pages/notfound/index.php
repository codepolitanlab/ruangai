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
                    <div class="pageTitle">404</div>
                    <div class="right">
                    </div>
                </div>

                <!-- App Capsule -->
                <div id="appCapsule">

                    <div class="section mt-2">
                        <div class="page-content pb-5 pt-5 text-center">
                            <h3>Halaman tidak Ditemukan</h3>

                            <a class="btn btn-sm btn-primary" href="<?= site_url(); ?>" x-on:click="loading = true">
                                <span class="spinner-border spinner-border-sm me-1" aria-hidden="true" x-show="loading"></span>
                                Kembali ke Beranda
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
