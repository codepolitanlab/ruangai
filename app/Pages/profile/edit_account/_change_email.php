<!-- Modal Form Change Email -->
<div class="modal fade modalbox" id="ModalFormEmail" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbaharui Email</h5>
                <a href="#" data-bs-dismiss="modal">Tutup</a>
            </div>
            <div class="modal-body">
                <div class="login-form">
                    <div class="section mt-4 mb-5">
                        <form>
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <label class="form-label" for="email">Alamat Email</label>
                                    <input type="email" class="form-control" id="email" x-model="model.email" placeholder="Masukkan alamat email baru">
                                </div>
                            </div>

                            <div class="form-group px-3 py-3 text-start bg-secondary bg-opacity-10"> 
                                <div class="d-flex justify-content-between">
                                    <label class="fw-bold mb-1">Kirim Kode Verifikasi</label>
                                </div>
                                <button type="button" x-on:click="sendOTPEmail" class="btn bg-success text-white btn-sm" :disabled="model.email.trim() == '' || otp_email_sent">
                                    <span class="bi bi-envelope me-1"></span> 
                                    <span x-text="otp_email_sent ? 'Kode Terkirim' : 'Kirim Kode ke WhatsApp'"></span>
                                </button>
                            
                                <div class="text-start input-wrapper mt-3">
                                    <label class="fw-bold">Masukkan kode verifikasi di sini</label>
                                    <input type="text" maxlength="6" class="form-control" placeholder="_ _ _ _ _ _" autocomplete="new-password" x-model="model.otp_email" required>
                                </div>
                                <small class="text-danger" x-show="errors.email" x-text="errors.email"></small>
                            </div>

                            <div class="mt-2">
                                <button 
                                 type="button" 
                                 class="btn btn-primary btn-block fs-6" 
                                 :disabled="model.email.trim() == '' || model.otp_email.length < 6"
                                 @click="changeEmail">PERBAHARUI EMAIL</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Modal Form -->