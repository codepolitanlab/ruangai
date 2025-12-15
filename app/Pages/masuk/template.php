<div id="member-login" x-data="login()">

    <!-- App Capsule -->
    <div id="appCapsule" class="pt-5 px-4">
        <div class="card shadow rounded-4 py-4 px-2">
            <div class="mt-1">
                <div class="section text-center">
                    <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
                </div>
                <div class="section mt-5">
                    <p class="lead my-3">Silakan masuk untuk melanjutkan</p>
                </div>

                <div class="section mt-1">
                    <div>
                        <div class="form-group boxed">
                            <div class="text-start input-wrapper">
                                <label class=" fs-6" for="identity">Email</label>
                                <input type="text" class="form-control" id="identity" x-model="data.username">
                            </div>
                        </div>

                        <div class="form-group boxed">
                            <div class="text-start input-wrapper">
                                <label class="fs-6" for="identity">Kata Sandi</label>
                                <input :type="showPwd ? 'text' : 'password'" class="form-control" id="pwd" autocomplete="off" x-model="data.password">
                                <i x-on:click="showPwd = !showPwd" class="input-icon-append bi" :class="showPwd ? 'bi-eye' : 'bi-eye-slash'"></i>
                            </div>
                        </div>

                        <div class="text-start mt-3">
                            <button type="button" x-on:click="login" class="btn btn-primary btn-block btn-lg rounded" :disabled="buttonSubmitting">
                                <span class="spinner-border spinner-border-sm me-1" x-show="buttonSubmitting" aria-hidden="true"></span>
                                MASUK
                            </button>
                        </div>

                        <div class="text-start pt-4">
                            <div class="lead mb-1">Belum punya akun? <a href="/registrasi">Daftar di sini</a></div>
                            <div class="lead">Lupa kata sandi? <a href="/reset_password">Reset Kata Sandi</a></div>
                        </div>
                    </div>
                </div>
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

<?= $this->include('masuk/script') ?>