<style>
    #member-reset-password {
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
    
    .reset-container {
        width: 100%;
        max-width: 540px;
    }
    
    .reset-card {
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
    
    .btn-reset {
        background: linear-gradient(90deg, #5CADC9 0%, #4A8DA8 100%);
        border: none;
        border-radius: 25px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-reset:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(92, 173, 201, 0.4);
    }
    
    .back-button {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2D3748;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 100;
    }
    
    .back-button:hover {
        background: rgba(255, 255, 255, 1);
        color: #5CADC9;
    }
</style>

<div id="member-reset-password" x-data="reset_password(`<?= config('Heroic')->recaptcha['siteKey'] ?>`)">

    <a href="javascript:void()" onclick="history.back()" class="back-button">
        <i class="bi bi-chevron-left" style="font-size: 1.5rem;"></i>
    </a>

    <!-- App Capsule -->
    <div id="appCapsule" class="reset-container">
        
        <!-- Logo outside card -->
        <div class="text-center mb-3">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/RuangAI-logo-transparan.png" width="100" alt="">
        </div>

        <div class="card reset-card rounded-4 py-4 px-4 px-md-5">

            <div class="text-center mb-4">
                <img src="https://www.ruangai.id/icon-ruangai.svg" width="130" alt="RuangAI" class="mb-3">
                <h2 style="color: #2D3748; font-weight: 700; font-size: 2rem; margin: 0;">Reset Kata Sandi</h2>
            </div>

            <div>
                <p style="color: #718096; font-size: 0.95rem; text-align: center; margin-bottom: 2rem;">Masukkan alamat email yang Anda daftarkan di aplikasi untuk kami kirimkan kode reset kata sandi</p>

                <div class="mb-3">
                    <label class="fw-semibold mb-2" for="email" style="color: #2D3748; font-size: 1rem;">Email</label>
                    <input type="text" class="form-control form-control-lg input-field" id="email" placeholder="email@example.com" autocomplete="new-password" x-model="model.email" required>
                </div>

                <div class="d-flex justify-content-center mb-3" id="grecaptcha"></div>

                <div class="mt-4">
                    <button type="button" x-on:click="confirm" class="btn btn-lg btn-reset w-100 d-flex align-items-center justify-content-center" :disabled="sending || (model.phone.length < 10 && model.email.length < 10)">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" x-show="sending"></span>
                        <span x-text="sending ? 'Mengirim Kode..' : 'Kirim Kode Reset'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?= $this->include('reset_password/script') ?>
</div>
