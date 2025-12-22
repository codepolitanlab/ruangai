<style>
    #member-login {
        background-color: #CAE5F0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 1rem;
    }

    #appCapsule {
        background-color: transparent;
    }
    
    .login-container {
        width: 100%;
        max-width: 540px;
    }
    
    .login-card {
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
    
    .btn-login {
        background: linear-gradient(90deg, #5CADC9 0%, #4A8DA8 100%);
        border: none;
        border-radius: 25px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover:not(:disabled) {
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

<div id="member-login" x-data="login($params.redirect ?? null)">
    <!-- App Capsule -->
    <div id="appCapsule" class="login-container">
        
        <!-- Logo and Title outside card -->
        <div class="text-center mb-3">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="100" alt="">
        </div>

        <div class="card login-card rounded-4 py-4 px-4 px-md-5">

            <div class="text-center mb-3">
                <img src="https://www.ruangai.id/icon-ruangai.svg" width="130" alt="RuangAI" class="mb-3">
                <h2 style="color: #2D3748; font-weight: 700; font-size: 2rem; margin: 0;">Selamat Datang!</h2>
            </div>

            <div>
                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="identity" style="color: #2D3748; font-size: 1rem;">Email</label>
                    <input type="text" class="form-control form-control-lg input-field" id="identity" x-model="data.username" 
                        placeholder="aldi@codepolitan.com">
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="fw-semibold" for="pwd" style="color: #2D3748; font-size: 1rem;">Kata Sandi</label>
                        <a href="/reset_password" style="color: #718096; font-size: 0.9rem; text-decoration: none;">Lupa kata sandi?</a>
                    </div>
                    <div class="password-wrapper">
                        <input :type="showPwd ? 'text' : 'password'" class="form-control form-control-lg input-field w-100" id="pwd" autocomplete="off" x-model="data.password" style="padding-right: 3rem;">
                        <i x-on:click="showPwd = !showPwd" class="bi eye-icon" :class="showPwd ? 'bi-eye-slash' : 'bi-eye'"></i>
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <button type="button" x-on:click="login" class="btn btn-lg btn-login w-100 d-flex align-items-center justify-content-center" :disabled="buttonSubmitting">
                        <span class="spinner-border spinner-border-sm me-2" x-show="buttonSubmitting" aria-hidden="true"></span>
                        <span>Masuk</span>
                        <i class="bi bi-arrow-right ms-2" style="font-size: 1.1rem;"></i>
                    </button>
                </div>

                <div class="text-center">
                    <p style="color: #718096; font-size: 1rem; margin: 0;">
                        Belum punya akun? <a href="/registrasi" style="color: #5CADC9; text-decoration: none; font-weight: 600;">Daftar</a>
                    </p>
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
    
    <?= $this->include('masuk/script') ?>
</div>