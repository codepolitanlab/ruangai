<div id="intro" x-data="intro()">

<style>
.swiper-pagination-bullet{ width: 30px !important; height: 5px !important; border-radius: 0 !important}
.swiper-intro{ height: 80vh}
.swiper-intro .swiper-pagination{ position: fixed; bottom: 90px}
.img-banner{ width: 100%}
@media only screen and (min-width: 992px){ .img-banner{ width: 75%;}}
</style>

    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh">
            <section>
                <div class="container">
                    <div class="swiper swiper-intro">
                        <div class="swiper-wrapper py-4 text-center">
                            <div class="swiper-slide">
                                <img src="<?= $themeURL ?>assets/img/walisantri/slide-1-min.png" alt="Slide 1" class="img-banner">
                                <h3>Selamat Datang</h3>
                                <p class="mx-5">Pantau kehadiran putra putri Anda beserta aktivitas mereka di pesantren secara realtime</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="<?=base_url()?>mobilekit/assets/img/walisantri/slide-2-min.png" alt="Slide 2" class="img-banner">
                                <h3>Selamat Datang</h3>
                                <p class="mx-5">Pembayaran biaya bulanan pesantren lebih mudah secara online melalui aplikasi</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="<?=base_url()?>mobilekit/assets/img/walisantri/slide-3-min.png" alt="Slide 3" class="img-banner">
                                <h3>Selamat Datang</h3>
                                <p class="mx-5">Unduh rekap nilai dan rapor digital santri melalui aplikasi</p>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div class="form-button-group" style="background-color:transparent;">
                        <button type="button" x-on:click="gotoLogin" class="btn btn-outline-primary bg-white btn-block btn-lg">MULAI</button>
                    </div>
                </div>
            </section>
        </div>
    </div>

</div>