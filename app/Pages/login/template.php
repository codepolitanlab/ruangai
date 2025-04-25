<div id="member-login" x-data="login()">
    <div class="bg-image" style="background-image: url('<?=$themeURL ?>assets/img/masagi/bg-min.png'); background-repeat: no-repeat; background-size: cover; width: 100%; background-position: center; background-color: #add7cb; height: 100%; position: fixed;"></div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5 pb-0">
        <div class="section text-center">
            <img src="<?= base_url('mobilekit/assets/img/masagi/logo-masagi-min.png') ?>" alt="image" style="width:200px">
        </div>

        <div class="login-form mt-2 mx-auto pt-1 p-2 rounded" style="background: #fffa">

            <div>
                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="fs-6" for="identity">NPA</label>
                        <input type="text" class="form-control fs-6" id="identity" x-model="data.username">
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="text-start input-wrapper">
                        <label class="fs-6" for="identity">Kata Sandi</label>
                        <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="off" x-model="data.password">
                        <span x-on:click="showPwd = !showPwd" class="input-icon-append">
                            <i :class="showPwd ? 'bi bi-eye' : 'bi bi-eye-slash'"></i>
                        </span>
                    </div>
                </div>

                <div class="text-start mt-2">
                    <button type="button" x-on:click="login" class="btn btn-primary btn-block rounded-5 fs-6 mb-2" :disabled="buttonSubmitting">
                        <span class="spinner-border spinner-border-sm me-1" x-show="buttonSubmitting" aria-hidden="true"></span>
                        MASUK
                    </button>
                    <div class="d-flex justify-content-center mb-2">
                        <div class="text-center">
                            <a href="/reset_password" class="fs-6 text-dark">Lupa Kata Sandi?</a>
                        </div>
                    </div>
                    <hr>
                    <a href="/aktivasi" class="btn btn-outline-secondary rounded-5 bg-white fs-6 btn-block mb-2">AKTIVASI</a>
                    
                </div>
            </div>
        
        </div>
        
        <div class="appFooter mt-3 pt-5 border-0" style="background:transparent">
            <div class="d-flex justify-content-center"><img src="mobilekit/assets/img/logo-pemuda-min.png" class="logo-pemuda-footer me-2 w-10 mb-3"></div>
            <div class="footer-title">Masagi App © 2024 by Pemuda Persis Bandung Barat</div>
            <div class=""><i class="bi bi-building"></i> Gedung Pusat Dakwah Persatuan Islam (PUSDAPI) Mandalasari, Kec. Cipatat, Kabupaten Bandung Barat, Jawa Barat 40554<br>Kontak: 08986818780</div>
            <div class="mt-2">
                <a href="https://www.instagram.com/pemudapersisbandungbarat" class="btn btn-icon btn-sm btn-instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://api.whatsapp.com/send?phone=628986818780" class="btn btn-icon btn-sm btn-whatsapp" target="_blank"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <div id="toast-login-error" 
        class="toast-box toast-bottom bg-danger" 
        :class="errorMessage ? 'show' : ''">
        <div class="in">
            <div class="text" x-text="errorMessage"></div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light" x-on:click="errorMessage = false">OK</button>
    </div>
</div>

<?= $this->include('login/script') ?>