<div id="member-reset-password-confirm" x-data="reset_password_confirm($params.token)">

    <div class="bg-image" style="background-image: url('<?= $themeURL ?>assets/img/masagi/bg-min.png'); background-repeat: no-repeat; background-size: cover; width: 100%; background-position: center; background-color: #add7cb; height: 100%; position: fixed;"></div>

    <div class="appHeader">
        <div class="left">
        </div>
        <div class="pageTitle">Ganti Kata Sandi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5 pb-2">
        <div class="login-form mt-1">
            <div class="section">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
            </div>
            <div class="login-form mt-2 mx-auto pt-1 p-2 rounded glassmorph" style="background: #fffa">
                <p>Masukkan kode reset yang telah kami kirimkan ke alamat email Kamu, lalu masukkan kata sandi yang baru untuk masuk ke aplikasi.</p>

                <div>
                    <div class="py-3">
                        <div class="form-group px-3 boxed text-start">
                            <div class="text-start input-wrapper">
                                <label class="fw-bold ">Kode Reset</label>
                                <input type="text" maxlength="6" class="form-control" placeholder="_ _ _ _ _ _" autocomplete="new-password" x-model="data.otp" required>
                            </div>
                            <small class="text-danger" x-show="error" x-text="error"></small>
                        </div>
                    </div>
                    <div class="form-group boxed px-3">
                        <div class="text-start input-wrapper">
                            <label class=" fs-6" for="identity">Kata Sandi Baru</label>
                            <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="new-password" x-model="data.password" required>
                            <i x-on:click="showPwd = !showPwd" class="input-icon-append">
                                <ion-icon id="pw-icon" :name="showPwd ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group px-3 mt-3">
                        <button type="button" x-on:click="confirm" class="btn btn-primary rounded-pill btn-block btn-lg">Ganti Kata Sandi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</div>

<?= $this->include('reset_password/change/script') ?>