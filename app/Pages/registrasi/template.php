<div id="member-register" x-data="register(`<?= config('Heroic')->recaptcha['siteKey'] ?>`)">

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5">
        <div class="login-form mt-1">
            <div class="section">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="150" alt="">
            </div>
            <div class="section mt-5">
                <p class="fs-5 my-3">Daftar akun baru untuk melanjutkan</p>
            </div>

            <div class="section mt-1">
                <div>
                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="fullname">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fullname" x-model="data.fullname" placeholder="Nama lengkap" @input="data.fullname = data.fullname.replace(/[^A-Za-zÀ-ÖØ-öø-ÿ\s'’-]/g, '')" required>
                            <small class="text-danger" x-show="errors.fullname" x-text="errors.fullname"></small>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" x-model="data.email" placeholder="email@example.com" required>
                            <small class="text-danger" x-show="errors.email" x-text="errors.email"></small>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="phone">No. Telepon <span class="text-danger">*</span></label>
                            <small class="text-muted d-block mb-1">Awali dengan 62, Cth: 6289xxxxxx</small>
                            <input type="text" class="form-control" id="phone" x-model="data.phone" placeholder="628xxxxxxxxx" inputmode="numeric" pattern="[0-9]*" @input="data.phone = data.phone.replace(/[^0-9]/g, '')" required>
                            <small class="text-danger" x-show="errors.phone" x-text="errors.phone"></small>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="password">Kata Sandi <span class="text-danger">*</span></label>
                            <input :type="showPwd ? 'text' : 'password'" class="form-control" id="password" autocomplete="new-password" x-model="data.password" required>
                            <i role="button" tabindex="0" aria-label="Tampilkan kata sandi" :aria-pressed="showPwd" @click="showPwd = !showPwd" @keydown.enter="showPwd = !showPwd" class="input-icon-append">
                                <i id="pw-icon" :class="showPwd ? 'bi bi-eye' : 'bi bi-eye-slash'" aria-hidden="true"></i>
                            </i>
                            <small class="text-danger" x-show="errors.password" x-text="errors.password"></small>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="text-start input-wrapper">
                            <label class="fs-6" for="repeat_password">Ulangi Kata Sandi <span class="text-danger">*</span></label>
                            <input :type="showRepeatPwd ? 'text' : 'password'" class="form-control" id="repeat_password" autocomplete="new-password" x-model="data.repeat_password" required>
                            <i role="button" tabindex="0" aria-label="Tampilkan ulang kata sandi" :aria-pressed="showRepeatPwd" @click="showRepeatPwd = !showRepeatPwd" @keydown.enter="showRepeatPwd = !showRepeatPwd" class="input-icon-append">
                                <i id="pw-icon-repeat" :class="showRepeatPwd ? 'bi bi-eye' : 'bi bi-eye-slash'" aria-hidden="true"></i>
                            </i>
                            <small class="text-danger" x-show="errors.repeat_password" x-text="errors.repeat_password"></small>
                        </div>
                    </div>

                    <div class="text-start mt-3">
                        <div class="d-flex justify-content-center mb-3" id="grecaptcha-register" x-show="showRecaptcha"></div>

                        <button type="button" x-on:click="register" class="btn btn-primary btn-block btn-lg rounded" :disabled="buttonSubmitting">
                            <span class="spinner-border spinner-border-sm me-1" x-show="buttonSubmitting" aria-hidden="true"></span>
                            <span x-text="buttonSubmitting ? 'MENDAFTAR...' : 'DAFTAR'"></span>
                        </button>

                        <div class="text-center mt-3">
                            <a href="/masuk" class="btn btn-link text-primary fs-6">Sudah punya akun? Masuk di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <div id="toast-register-error"
        class="toast-box toast-bottom bg-danger"
        :class="errorMessage ? 'show' : ''">
        <div class="in">
            <div class="text" x-text="errorMessage"></div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light" x-on:click="errorMessage = false">OK</button>
    </div>

    <div id="toast-register-success"
        class="toast-box toast-bottom bg-success"
        :class="successMessage ? 'show' : ''">
        <div class="in">
            <div class="text" x-text="successMessage"></div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light" x-on:click="successMessage = false">OK</button>
    </div>
</div>

<?= $this->include('registrasi/script') ?>
