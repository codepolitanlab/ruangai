<style>
    #member-register {
        background-color: #CAE5F0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    #appCapsule {
        background-color: transparent;
    }
    
    .register-container {
        width: 100%;
        max-width: 540px;
    }
    
    .register-card {
        background: #FFFFFF;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }
    
    .input-field {
        background: #EDF2F7;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        color: #2D3748;
        font-size: 1rem;
    }
    
    .input-field:focus {
        background: #EDF2F7;
        border-color: #CBD5E0;
        box-shadow: none;
    }
    
    .btn-register {
        background: linear-gradient(90deg, #5CADC9 0%, #4A8DA8 100%);
        border: none;
        border-radius: 25px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-register:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(92, 173, 201, 0.4);
    }
    
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .eye-icon {
        position: absolute;
        right: 1rem;
        cursor: pointer;
        color: #A0AEC0;
        font-size: 1.2rem;
        z-index: 10;
    }
</style>

<div id="member-register" x-data="register(`<?= config('Heroic')->recaptcha['siteKey'] ?>`)">

    <!-- App Capsule -->
    <div id="appCapsule" class="register-container">
        
        <!-- Logo and Title outside card -->
        <div class="text-center mb-3">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="100" alt="">
        </div>

        <div class="card register-card rounded-4 py-4 px-4 px-md-5">

            <div class="text-center mb-4">
                <img src="https://www.ruangai.id/icon-ruangai.svg" width="130" alt="RuangAI" class="mb-3">
                <h2 style="color: #2D3748; font-weight: 700; font-size: 2rem; margin: 0;">Daftar Akun Baru</h2>
            </div>

            <div>
                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="fullname" style="color: #2D3748; font-size: 1rem;">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg input-field" id="fullname" x-model="data.fullname" placeholder="Nama lengkap" @input="data.fullname = data.fullname.replace(/[^A-Za-zÀ-ÖØ-öø-ÿ\s''-]/g, '')" required>
                    <small class="text-danger" x-show="errors.fullname" x-text="errors.fullname"></small>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="email" style="color: #2D3748; font-size: 1rem;">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-lg input-field" id="email" x-model="data.email" placeholder="email@example.com" required>
                    <small class="text-danger" x-show="errors.email" x-text="errors.email"></small>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="phone" style="color: #2D3748; font-size: 1rem;">No. Telepon <span class="text-danger">*</span></label>
                    <small class="text-muted d-block mb-1" style="font-size: 0.85rem;">Awali dengan 62, Cth: 6289xxxxxx</small>
                    <input type="text" class="form-control form-control-lg input-field" id="phone" x-model="data.phone" placeholder="628xxxxxxxxx" inputmode="numeric" pattern="[0-9]*" @input="data.phone = data.phone.replace(/[^0-9]/g, '')" required>
                    <small class="text-danger" x-show="errors.phone" x-text="errors.phone"></small>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="password" style="color: #2D3748; font-size: 1rem;">Kata Sandi <span class="text-danger">*</span></label>
                    <div class="password-wrapper">
                        <input :type="showPwd ? 'text' : 'password'" class="form-control form-control-lg input-field w-100" id="password" autocomplete="new-password" x-model="data.password" style="padding-right: 3rem;" required>
                        <i role="button" tabindex="0" aria-label="Tampilkan kata sandi" :aria-pressed="showPwd" @click="showPwd = !showPwd" @keydown.enter="showPwd = !showPwd" class="bi eye-icon" :class="showPwd ? 'bi-eye-slash' : 'bi-eye'" aria-hidden="true"></i>
                    </div>
                    <small class="text-danger" x-show="errors.password" x-text="errors.password"></small>
                </div>

                <div class="mb-4">
                    <label class="fw-semibold mb-2" for="repeat_password" style="color: #2D3748; font-size: 1rem;">Ulangi Kata Sandi <span class="text-danger">*</span></label>
                    <div class="password-wrapper">
                        <input :type="showRepeatPwd ? 'text' : 'password'" class="form-control form-control-lg input-field w-100" id="repeat_password" autocomplete="new-password" x-model="data.repeat_password" style="padding-right: 3rem;" required>
                        <i role="button" tabindex="0" aria-label="Tampilkan ulang kata sandi" :aria-pressed="showRepeatPwd" @click="showRepeatPwd = !showRepeatPwd" @keydown.enter="showRepeatPwd = !showRepeatPwd" class="bi eye-icon" :class="showRepeatPwd ? 'bi-eye-slash' : 'bi-eye'" aria-hidden="true"></i>
                    </div>
                    <small class="text-danger" x-show="errors.repeat_password" x-text="errors.repeat_password"></small>
                </div>

                <div class="d-flex justify-content-center mb-3" id="grecaptcha-register" x-show="showRecaptcha"></div>

                <input type="hidden" id="source" x-model="data.source">

                <div class="mt-4 mb-4">
                    <button type="button" x-on:click="register" class="btn btn-lg btn-register w-100 d-flex align-items-center justify-content-center" :disabled="buttonSubmitting">
                        <span class="spinner-border spinner-border-sm me-2" x-show="buttonSubmitting" aria-hidden="true"></span>
                        <span x-text="buttonSubmitting ? 'Mendaftar...' : 'Daftar'"></span>
                    </button>
                </div>

                <div class="text-center mt-3">
                    <a href="/masuk" class="btn btn-link text-primary fs-6">Sudah punya akun? Masuk di sini</a>
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
