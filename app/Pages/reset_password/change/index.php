<div id="member-reset-password-confirm" x-data="reset_password_confirm($router.params.token)">
<div class="bg-image" style="background-image: url('<?=$themeURL ?>assets/img/bg-green-min.jpg'); background-repeat: no-repeat; background-size: cover; width: 100%; background-position: center; background-color: #add7cb; height: 100%; position: fixed;"></div>

    <div class="appHeader">
        <div class="left">
        </div>
        <div class="pageTitle">Ganti Kata Sandi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5 mt-5 pb-2">
        <div class="login-form mt-1">
            <div class="section">
                <img :src="data.logo" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <p class="text-white">Masukkan kode reset yang telah kami kirimkan ke nomor WhatsApp Anda, lalu masukkan kata sandi yang baru untuk Anda masuk ke aplikasi.</p>
            </div>
            <div class="section mt-1 mb-5 px-0">
                <div>                    
                    <div class="py-3">
                        <div class="form-group px-3 boxed text-start">
                            <div class="text-start input-wrapper">
                                <label class="fw-bold text-white">Kode Reset</label>
                                <input type="text" maxlength="6" class="form-control" placeholder="_ _ _ _ _ _" autocomplete="new-password" x-model="data.otp" required>
                            </div>
                            <small class="text-danger" x-show="error" x-text="error"></small>
                        </div>
                    </div>
                    <div class="form-group boxed px-3">
                        <div class="text-start input-wrapper">
                            <label class="text-white fs-6" for="identity">Kata Sandi Baru</label>
                            <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="new-password" x-model="data.password" required>
                            <i x-on:click="showPwd = !showPwd" class="input-icon-append">
                                <ion-icon id="pw-icon" :name="showPwd ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group px-3 mt-3">
                        <button type="button" x-on:click="confirm" class="btn btn-primary btn-block btn-lg">Ganti Kata Sandi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</div>