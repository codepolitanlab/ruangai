<div class="header-mobile-only" id="verify_email" x-data="verifyEmail()">

    <?= $this->include('_appHeader'); ?>

    <style>
        .verify-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            font-size: 24px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        .otp-input:focus {
            border-color: #0d6efd;
            outline: none;
        }

        .verify-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            padding: 32px;
            margin-top: 20px;
        }

        .verify-icon {
            width: 80px;
            height: 80px;
            background: #e7f3ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 40px;
            color: #0d6efd;
        }

        /* Spacing helpers for verify page */
        .verify-card .form-label {
            margin-bottom: 8px;
        }

        .alert-info.verify-info {
            margin-bottom: 18px;
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }

        .otp-row {
            gap: 12px;
            margin-bottom: 14px;
        }

        .otp-input {
            width: 56px;
            height: 62px;
            font-size: 22px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #e6e6e6;
            padding: 6px 0;
        }

        .otp-input:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.06);
        }

        .error-alert {
            margin-bottom: 12px;
        }

        .btn-verify {
            margin-bottom: 12px;
        }

        @media (max-width: 576px) {
            .verify-container { padding: 18px; }
            .verify-card { padding: 22px; }
            .otp-input { width: 48px; height: 54px; font-size: 20px; }
        }
    </style>

    <div class="verify-container">
        <div class="verify-card">
            <div class="verify-icon">
                <i class="bi bi-envelope-check"></i>
            </div>

            <h3 class="text-center mb-2">Verifikasi Email Anda</h3>
            <p class="text-center text-muted mb-4">
                Mohon verifikasi email Anda untuk melanjutkan
            </p>

            <!-- Email Input Section -->
            <div x-show="!emailSent" class="mb-4">
                <p class="mb-3">Pastikan email Anda sudah benar agar OTP dapat diterima untuk aktivasi.</p>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        x-model="email" 
                        :disabled="loading"
                        placeholder="email@example.com">
                </div>
                <button 
                    type="button" 
                    class="btn btn-primary w-100" 
                    @click="sendEmailVerification()" 
                    :disabled="loading || !email">
                    <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                    <span x-text="loading ? 'Mengirim...' : 'Kirim Kode OTP'"></span>
                </button>
            </div>

            <!-- OTP Input Section -->
            <div x-show="emailSent">
                <div class="alert alert-info verify-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Kode OTP telah dikirim ke <strong x-text="email"></strong>. Silakan cek inbox atau folder spam Anda.
                </div>

                <div class="d-flex justify-content-center otp-row mb-3">
                    <input
                        type="tel"
                        class="form-control otp-input"
                        maxlength="1"
                        x-model="otp[0]"
                        x-ref="otp0"
                        @input="handleOtpInput($event, 0)"
                        @keydown.backspace="handleBackspace($event, 0)"
                        :disabled="isVerifying"
                        autocomplete="off">
                    <input
                        type="tel"
                        class="form-control otp-input"
                        maxlength="1"
                        x-model="otp[1]"
                        x-ref="otp1"
                        @input="handleOtpInput($event, 1)"
                        @keydown.backspace="handleBackspace($event, 1)"
                        :disabled="isVerifying"
                        autocomplete="off">
                    <input
                        type="tel"
                        class="form-control otp-input"
                        maxlength="1"
                        x-model="otp[2]"
                        x-ref="otp2"
                        @input="handleOtpInput($event, 2)"
                        @keydown.backspace="handleBackspace($event, 2)"
                        :disabled="isVerifying"
                        autocomplete="off">
                    <input
                        type="tel"
                        class="form-control otp-input"
                        maxlength="1"
                        x-model="otp[3]"
                        x-ref="otp3"
                        @input="handleOtpInput($event, 3)"
                        @keydown.backspace="handleBackspace($event, 3)"
                        :disabled="isVerifying"
                        autocomplete="off">
                    <input
                        type="tel"
                        class="form-control otp-input"
                        maxlength="1"
                        x-model="otp[4]"
                        x-ref="otp4"
                        @input="handleOtpInput($event, 4)"
                        @keydown.backspace="handleBackspace($event, 4)"
                        :disabled="isVerifying"
                        autocomplete="off">
                    <input
                        type="tel"
                        class="form-control otp-input"
                        maxlength="1"
                        x-model="otp[5]"
                        x-ref="otp5"
                        @input="handleOtpInput($event, 5)"
                        @keydown.backspace="handleBackspace($event, 5)"
                        :disabled="isVerifying"
                        autocomplete="off">
                </div>

                <div x-show="errorMessage" class="alert alert-danger error-alert" x-text="errorMessage"></div>

                <button 
                    type="button" 
                    class="btn btn-primary w-100 mb-3 btn-verify" 
                    @click="verifyEmail()"
                    :disabled="isVerifying || otp.join('').length !== 6">
                    <span x-show="isVerifying" class="spinner-border spinner-border-sm me-2"></span>
                    <span x-text="isVerifying ? 'Memverifikasi...' : 'Verifikasi Email'"></span>
                </button>

                <div class="text-center">
                    <span x-show="resendCooldown <= 0">
                        Tidak menerima kode?
                        <a href="#" @click.prevent="resendOtp()">Kirim Ulang</a>
                    </span>
                    <span x-show="resendCooldown > 0" class="text-muted">
                        Kirim ulang dalam <strong x-text="resendCooldown"></strong> detik...
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->include('verify_email/script'); ?>
</div>
