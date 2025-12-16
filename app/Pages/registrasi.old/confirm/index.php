<div id="member-register-confirm" x-data="member_register_confirm()">

    <div class="appHeader">
        <div class="left">
        </div>
        <div class="pageTitle">Konfirmasi Registrasi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pt-5 mt-5 pb-2">
        <div class="login-form mt-1">
            <div class="section">
                <img src="https://image.web.id/images/logo-ruangai.png" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <p class="">Untuk melanjutkan pendaftaran, masukkan kode registrasi yang telah kami kirimkan ke nomor WhatsApp Anda.</p>
            </div>
            <div class="section mt-1 mb-5 px-0">
                <div>
                    <div class="py-3">
                        <div class="form-group px-3 py-3 text-start bg-secondary bg-opacity-25">
                            <div class="d-flex justify-content-between">
                                <label class="fw-bold mb-1">Tidak menerima Kode Registrasi?</label>
                            </div>
                            <small x-show="remainingTime > 0">Kirim ulang dalam <span x-text="formattedTime"></span></small>
                            <div class="d-flex">
                                <button type="button" x-on:click="resendOTP" class="btn bg-success text-white btn-sm" :disabled="remainingTime > 0 || resending"><span class="bi bi-whatsapp me-1"></span> <span x-text="resending ? 'Mengirim ulang...' : 'Kirim Ulang Kode ke WhatsApp'"></span></button>
                            </div>
                        </div>

                        <div class="form-group px-3 boxed mt-3 text-start">
                            <div class="text-start input-wrapper">
                                <label class="fw-bold">Masukkan kode registrasi di sini</label>
                                <input type="text" maxlength="6" class="form-control" placeholder="_ _ _ _ _ _" autocomplete="new-password" x-model="data.otp" required>
                            </div>
                            <small class="text-danger" x-show="error" x-text="error"></small>
                        </div>
                    </div>

                    <div class="form-group px-3 mt-3">
                        <button type="button" x-on:click="confirm" class="btn btn-primary btn-block btn-lg">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

</div>