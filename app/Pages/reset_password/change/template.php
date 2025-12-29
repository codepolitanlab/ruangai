<style>
    #member-reset-password-confirm {
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
    
    .change-container {
        width: 100%;
        max-width: 540px;
    }
    
    .change-card {
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
    
    .btn-change {
        background: linear-gradient(90deg, #5CADC9 0%, #4A8DA8 100%);
        border: none;
        border-radius: 25px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-change:hover:not(:disabled) {
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

<div id="member-reset-password-confirm" x-data="reset_password_confirm($params.token)">

    <!-- App Capsule -->
    <div id="appCapsule" class="change-container">
        
        <!-- Logo outside card -->
        <div class="text-center mb-3">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="100" alt="">
        </div>

        <div class="card change-card rounded-4 py-4 px-4 px-md-5">

            <div class="text-center mb-4">
                <img src="https://www.ruangai.id/icon-ruangai.svg" width="130" alt="RuangAI" class="mb-3">
                <h2 style="color: #2D3748; font-weight: 700; font-size: 2rem; margin: 0;">Ganti Kata Sandi</h2>
            </div>

            <div>
                <p style="color: #718096; font-size: 0.95rem; text-align: center; margin-bottom: 2rem;">Masukkan kode reset yang telah kami kirimkan ke alamat email Kamu, lalu masukkan kata sandi yang baru untuk masuk ke aplikasi.</p>

                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="otp" style="color: #2D3748; font-size: 1rem;">Kode Reset</label>
                    <input type="text" maxlength="6" class="form-control form-control-lg input-field text-center" id="otp" placeholder="_ _ _ _ _ _" autocomplete="new-password" x-model="data.otp" style="letter-spacing: 0.5rem; font-size: 1.5rem;" required>
                    <small class="text-danger" x-show="error" x-text="error"></small>
                </div>

                <div class="mb-4">
                    <label class="fw-semibold mb-2" for="pwd" style="color: #2D3748; font-size: 1rem;">Kata Sandi Baru</label>
                    <div class="password-wrapper">
                        <input :type="showPwd ? 'text' : 'password'" class="form-control form-control-lg input-field w-100" id="pwd" autocomplete="new-password" x-model="data.password" style="padding-right: 3rem;" required>
                        <i x-on:click="showPwd = !showPwd" class="bi eye-icon" :class="showPwd ? 'bi-eye-slash' : 'bi-eye'"></i>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" x-on:click="confirm" class="btn btn-lg btn-change w-100">Ganti Kata Sandi</button>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</div>

<?= $this->include('reset_password/change/script') ?>