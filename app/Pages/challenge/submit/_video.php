<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Step 2 - Submit Karya</h5>
                        <p class="text-muted mb-0">Masukkan data karya Anda secara ringkas dan jelas.</p>
                    </div>
                    <span class="badge bg-light text-dark ms-md-auto">Wajib isi semua field</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 mb-1">
                        <label class="form-label d-block mb-0">URL Karya <span class="text-danger">*</span></label>
                        <small class="d-block mb-2">Submit video di X.com dan salin tautannya di sini</small>
                        <input type="url" class="form-control" x-model="form.twitter_post_url"
                            placeholder="Masukkan URL Post X Kamu" :disabled="emailNotVerified">
                        <small class="form-text text-muted">Contoh: https://x.com/username/status/123456</small>

                        <template x-if="errors.twitter_post_url">
                            <small class="text-danger" x-text="errors.twitter_post_url"></small>
                        </template>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="form.video_title"
                            placeholder="Judul video Anda" :disabled="emailNotVerified">

                        <template x-if="errors.video_title">
                            <small class="text-danger" x-text="errors.video_title"></small>
                        </template>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Kategori Video <span class="text-danger">*</span></label>
                        <select class="form-select" x-model="form.video_category" :class="{'is-invalid': errors.video_category}" :disabled="emailNotVerified">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Hiburan">Hiburan</option>
                            <option value="Sains">Sains</option>
                            <option value="Kemanusiaan">Kemanusiaan</option>
                            <option value="Olahraga">Olahraga</option>
                        </select>

                        <template x-if="errors.video_category">
                            <small class="text-danger" x-text="errors.video_category"></small>
                        </template>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Prompt yang Digunakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" x-model="form.video_description"
                            placeholder="Tuliskan prompt yang kamu gunakan secara lengkap" :disabled="emailNotVerified"></textarea>

                        <template x-if="errors.video_description">
                            <small class="text-danger" x-text="errors.video_description"></small>
                        </template>
                    </div>



                    <div class="col-12">
                        <label class="form-label">Tools Lainnya (Jika Ada)</label>
                        <input type="text" class="form-control" x-model="form.other_tools"
                            placeholder="Contoh: Adobe Premiere, After Effects, Capcut, dll." :disabled="emailNotVerified">
                    </div>
                </div>

                <template x-if="errors.files">
                    <div class="alert alert-danger" x-text="errors.files"></div>
                </template>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-success" @click="showTncModal()" :disabled="isSubmitting || !isProfileComplete() || (hasSubmission && !canEditSubmission) || emailNotVerified">
                        <template x-if="isSubmitting">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                        </template>
                        <span x-text="isSubmitting ? 'Mengirim...' : 'Submit Karya'"></span>
                    </button>
                </div>

                <template x-if="!isProfileComplete()">
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Harap lengkapi profil Anda terlebih dahulu sebelum submit challenge.
                    </div>
                </template>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5 order-first order-lg-last">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body panduan">
                <h5 class="mb-3">Panduan Singkat</h5>
                <ul class="mb-0 ps-3">
                    <li>FOLLOW akun X resmi <a href="https://x.com/codepolitan" target="_blank">@codepolitan</a> dan <a href="https://x.com/alibaba_cloud" target="_blank">@alibaba_cloud</a>.</li>
                    <li>Buat video minimal 5 detik dengan <a href="https://wan.video" target="_blank">WAN.video</a> atau WAN MODEL STUDIO (<a href="https://s.id/WanModelStudio" target="_blank">https://s.id/WanModelStudio</a>).</li>
                    <li>Buat postingan di akun X kamu, upload karya video yang telah dibuat.</li>
                    <li>Berikan tagar <strong>#WanAVideo #GenAIVideoFest</strong> dan mention akun X <strong>@CODEPOLITAN</strong> dan <strong>@Alibaba_cloud</strong>.</li>
                    <li>Salin link postingan kamu, dan masukkan ke bagian <em>URL Karya</em>.</li>
                    <li>Pilih Kategori Video yang kamu submit (Hiburan, Sains, Kemanusiaan, Olahraga).</li>
                    <li>Masukkan Judul Video.</li>
                    <li>Masukkan semua prompt yang kamu gunakan di tools WAN.video dan juga tools lainnya.</li>
                    <li>Masukkan tools lainnya yang kamu gunakan untuk membuat video karya (jika ada).</li>
                    <li>Setelah semua lengkap, klik <strong class="fw-bold">Submit Karya</strong> dan setujui persyaratan kompetisi.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- T&C Confirmation Modal -->
<div class="modal fade" id="tncModal" tabindex="-1" aria-labelledby="tncModalLabel" aria-hidden="true" x-ref="tncModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tncModalLabel">Konfirmasi Syarat dan Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Sebelum submit, pastikan Anda telah memenuhi semua persyaratan berikut:</p>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" x-model="modalTnc.is_followed_accounts" id="modalFollowAccounts">
                    <label class="form-check-label" for="modalFollowAccounts">
                        Saya sudah mengikuti akun X <a class="fw-bold" target="_blank" href="https://x.com/alibaba_cloud">@alibaba_cloud</a> dan <a class="fw-bold" target="_blank" href="https://x.com/codepolitan">@codepolitan</a> <span class="text-danger">*</span>
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" x-model="modalTnc.agreed_terms_2" id="modalAgreeTerms2">
                    <label class="form-check-label" for="modalAgreeTerms2">
                        Saya menggunakan WAN.video atau WAN Model Studio <span class="text-danger">*</span>
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" x-model="modalTnc.agreed_terms_3" id="modalAgreeTerms3">
                    <label class="form-check-label" for="modalAgreeTerms3">
                        Saya menyetujui syarat dan ketentuan yang berlaku (<a href="https://docs.google.com/document/d/1FUh1c2fzrCZCA8TjVwo_JRwyie6992ja4vaRwuBe1JA/edit?usp=sharing" target="_blank">Lihat Syarat</a>) <span class="text-danger">*</span>
                    </label>
                </div>

                <div class="alert alert-warning mb-0" x-show="!allTncChecked()">
                    <i class="bi bi-info-circle me-2"></i>
                    Anda harus mencentang semua persyaratan untuk melanjutkan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" @click="confirmAndSubmit()" :disabled="!allTncChecked()">
                    <i class="bi bi-check-circle me-2"></i>
                    Setuju & Submit
                </button>
            </div>
        </div>
    </div>
</div>