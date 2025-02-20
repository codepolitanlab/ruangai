<!-- Modal Form Change Email -->
<div class="modal fade modalbox" id="ModalFormWA" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbaharui Nomor WhatsApp</h5>
                <a href="#" data-bs-dismiss="modal">Tutup</a>
            </div>
            <div class="modal-body">
                <div class="login-form">
                    <div class="section mt-4 mb-5">
                        <form>
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <label class="form-label" for="phone">Nomor WhatsApp</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Masukkan nomor WhatsApp baru" x-model="model.phone">
                                </div>
                            </div>

                            <div class="form-group px-3 py-3 text-start bg-secondary bg-opacity-10"> 
                                <div class="d-flex justify-content-between">
                                    <label class="fw-bold mb-1">Kirim Kode Verifikasi</label>
                                </div>
                                <button type="button" x-on:click="sendOTPPhone" :class="sendingPhone ? 'btn-progress' : ''" class="btn bg-success text-white btn-sm" :disabled="model.phone.trim() == '' || otp_phone_sent">
                                    <span class="bi bi-whatsapp me-1"></span> 
                                    <span x-text="otp_phone_sent ? 'Kode Terkirim' : 'Kirim Kode ke WhatsApp'"></span>
                                </button>
                            
                                <div class="text-start input-wrapper mt-3">
                                    <label class="fw-bold">Masukkan kode verifikasi di sini</label>
                                    <input type="text" maxlength="6" class="form-control" placeholder="_ _ _ _ _ _" autocomplete="new-password" x-model="model.otp_phone" required>
                                </div>
                                <small class="text-danger" x-show="errors.phone" x-text="errors.phone"></small>
                            </div>

                            <div class="mt-2">
                                <button 
                                 type="button" 
                                 class="btn btn-primary btn-block fs-6" 
                                 :disabled="model.phone.trim() == '' || model.otp_phone.length < 6"
                                 @click="changePhone">
                                    PERBAHARUI NOMOR
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Modal Form -->