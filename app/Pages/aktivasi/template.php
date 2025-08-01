<div id="aktivasi" x-data="aktivasi()">

    <div class="bg-image" style="background-image: url('<?= $themeURL ?>assets/img/masagi/bg-min.png'); background-repeat: no-repeat; background-size: cover; width: 100%; background-position: center; background-color: #add7cb; height: 100%; position: fixed;"></div>

    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>
        <div class="pageTitle">Aktivasi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pb-2" style="padding-top: 60px">
        <div class="section text-center mt-3">
            <img src="<?= base_url('mobilekit/assets/img/masagi/logo-masagi-min.png') ?>" alt="image" style="width:200px">
        </div>

        <div class="login-form mt-2 mx-auto pt-1 p-2 rounded glassmorph" style="background: #fffa">
            <p class="m-0 mb-3">Untuk memulai aktivasi silakan masukkan kode aktivasi dan NPA Anda. Kode aktivasi dapat Anda minta ke Pimpinan Cabang Anda.</p>

            <div class="form-group boxed animated">
                <div class="input-wrapper">
                    <label class="form-label" for="token">Kode Aktivasi</label>
                    <input type="text" x-model="data.token" id="token" class="form-control" value="" placeholder="Kode aktivasi" required="" autocomplete="new-password">
                </div>
            </div>
            <div class="form-group boxed animated">
                <div class="input-wrapper">
                    <label class="form-label" for="username">NPA</label>
                    <input type="text" x-model="data.npa" id="username" class="form-control" value="" placeholder="Nomor Pokok Anggota" required="" autocomplete="off">
                </div>
            </div>
            <!-- <div class="form-group boxed mt-1">
                <div class="input-wrapper">
                    <div class="g-recaptcha d-flex justify-content-center" data-sitekey="6LdRI6IpAAAAAD4V9Nm2u9SB7ml_OV4ceZB12EOB" data-action="LOGIN"></div>
                </div>
            </div> -->
            <div class="mt-3 mb-2">
                <button
                    type="button"
                    id="btnSubmit"
                    class="btn btn-primary fs-6 rounded-5 btn-block"
                    @click="checkActivationToken"
                    :disabled="data.token.trim() == '' || data.npa.trim() == '' ? true : false">
                    <span id="submitSpinner" class="d-none spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    <span
                        id="submitText"
                        class="text-uppercase">
                        Lanjutkan Aktivasi
                    </span>
                </button>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

</div>

<?= $this->include('aktivasi/script') ?>