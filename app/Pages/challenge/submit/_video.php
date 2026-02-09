<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
            <div>
                <h5 class="fw-bold mb-1">Step 2 - Submit Karya</h5>
                <p class="text-muted mb-0">Masukkan data karya Anda secara ringkas dan jelas.</p>
            </div>
            <span class="badge bg-light text-dark ms-md-auto">Wajib isi semua field</span>
        </div>

        <div class="card p-3 shadow-none border mb-4 panduan">
            <h5 class="mb-2">Panduan Singkat</h5>
            <ul class="mb-0">
                <li>Gunakan WAN Model Studio / WAN Video AI untuk membuat video minimal 15 detik.</li>
                <li>Upload video ke X, lalu tempelkan URL postingan.</li>
                <li>Isi judul, deskripsi, dan unggah dokumen prompt (PDF/TXT).</li>
            </ul>
        </div>

        <div class="col-12 mb-4">
            <label class="form-label d-block mb-0">URL Post X <span class="text-danger">*</span></label>
            <small class="d-block mb-2">Submit video di X.com dan salin tautannya di sini</small>
            <input type="url" class="form-control" x-model="form.twitter_post_url"
                placeholder="Masukkan URL Post X Kamu">
            <small class="form-text text-muted">Contoh: https://x.com/username/status/123456</small>

            <template x-if="errors.twitter_post_url">
                <small class="text-danger" x-text="errors.twitter_post_url"></small>
            </template>
        </div>

        <div class="col-12 mb-4">
            <label class="form-label">Judul Video <span class="text-danger">*</span></label>
            <input type="text" class="form-control" x-model="form.video_title"
                placeholder="Judul video Anda">

            <template x-if="errors.video_title">
                <small class="text-danger" x-text="errors.video_title"></small>
            </template>
        </div>

        <div class="col-12 mb-4">
            <label class="form-label">Deskripsi Video <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="3" x-model="form.video_description"
                placeholder="Deskripsikan video Anda"></textarea>

            <template x-if="errors.video_description">
                <small class="text-danger" x-text="errors.video_description"></small>
            </template>
        </div>

        <div class="col-12 mb-4">
            <label class="form-label mb-2">Tools yang Digunakan <span class="text-danger">*</span></label>
            <div class="d-flex flex-column gap-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" x-model="form.tools_wan_video" id="toolsWanVideo">
                    <label class="form-check-label" for="toolsWanVideo">WAN Video AI</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" x-model="form.tools_wan_model" id="toolsWanModel">
                    <label class="form-check-label" for="toolsWanModel">WAN Model Studio AI</label>
                </div>
            </div>
            <template x-if="errors.tools_required">
                <small class="text-danger" x-text="errors.tools_required"></small>
            </template>
        </div>

        <div class="col-12 mb-4">
            <label class="form-label">Tools Lainnya (Opsional)</label>
            <input type="text" class="form-control" x-model="form.other_tools"
                placeholder="Contoh: Adobe Premiere, After Effects">
        </div>

        <div class="col-12 mb-4">
            <label class="form-label d-block mb-0">Dokumen Prompt <span class="text-danger">*</span></label>
            <small class="d-block mb-2">Unduh Template dokumen <a class="fw-bold" native target="_blank" href="https://docs.google.com/document/d/1bmLNpP-GLsdntfIkvMaMUC4DvjoDQPx9pUuSofM4-js/copy">DI SINI</a></small>
            <input type="file" class="form-control" @change="handleFileUpload($event, 'prompt_file')"
                accept=".pdf,.txt">
            <template x-if="errors.prompt_file">
                <small class="text-danger" x-text="errors.prompt_file"></small>
            </template>
            <template x-if="files.prompt_file">
                <div class="badge bg-success mt-1" x-text="files.prompt_file.name"></div>
            </template>
            <template x-if="!files.prompt_file && existingFiles.prompt_file">
                <div class="badge bg-info mt-1" x-text="existingFiles.prompt_file"></div>
            </template>
        </div>

        <div class="col-12">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" x-model="form.is_followed_account_codepolitan" id="followCodepolitan" :class="{'is-invalid': errors.is_followed_account_codepolitan}">
                <label class="form-check-label" for="followCodepolitan">
                    Saya sudah mengikuti akun X <a class="fw-bold" target="_blank" href="https://x.com/codepolitan">@codepolitan</a> <span class="text-danger">*</span>
                </label>
            </div>
            <template x-if="errors.is_followed_account_codepolitan">
                <small class="text-danger" x-text="errors.is_followed_account_codepolitan"></small>
            </template>
        </div>

        <div class="col-12">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" x-model="form.is_followed_account_alibaba" id="followAlibaba" :class="{'is-invalid': errors.is_followed_account_alibaba}">
                <label class="form-check-label" for="followAlibaba">
                    Saya sudah mengikuti akun X <a class="fw-bold" target="_blank" href="https://x.com/alibaba_cloud">@alibaba_cloud</a> <span class="text-danger">*</span>
                </label>
            </div>
            <template x-if="errors.is_followed_account_alibaba">
                <small class="text-danger" x-text="errors.is_followed_account_alibaba"></small>
            </template>
        </div>

        <div class="col-12">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" x-model="profile.agreed_terms_1" id="agreeTerms1" :class="{'is-invalid': errors.agreed_terms_1}">
                <label class="form-check-label" for="agreeTerms1">
                    Saya menyatakan bahwa karya ini adalah hasil saya sendiri, tidak melanggar hak cipta pihak ketiga <span class="text-danger">*</span>
                </label>
            </div>
            <template x-if="errors.agreed_terms_1">
                <small class="text-danger" x-text="errors.agreed_terms_1"></small>
            </template>
        </div>

        <div class="col-12">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" x-model="profile.agreed_terms_2" id="agreeTerms2" :class="{'is-invalid': errors.agreed_terms_2}">
                <label class="form-check-label" for="agreeTerms2">
                    Karya dibuat menggunakan WAN Model Studio atau WAN.video <span class="text-danger">*</span>
                </label>
            </div>
            <template x-if="errors.agreed_terms_2">
                <small class="text-danger" x-text="errors.agreed_terms_2"></small>
            </template>
        </div>

        <div class="col-12">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" x-model="profile.agreed_terms_3" id="agreeTerms3" :class="{'is-invalid': errors.agreed_terms_3}">
                <label class="form-check-label" for="agreeTerms3">
                    Saya menyetujui syarat dan ketentuan kompetisi <span class="text-danger">*</span>
                </label>
            </div>
            <template x-if="errors.agreed_terms_3">
                <small class="text-danger" x-text="errors.agreed_terms_3"></small>
            </template>
        </div>

        <template x-if="errors.files">
            <div class="alert alert-danger" x-text="errors.files"></div>
        </template>

        <div class="mt-3 d-flex justify-content-end">
            <button type="button" class="btn btn-success" @click="submitForm()" :disabled="isSubmitting || !isProfileComplete() || (hasSubmission && !canEditSubmission)">
                <template x-if="isSubmitting">
                    <span class="spinner-border spinner-border-sm me-2"></span>
                </template>
                <span x-text="isSubmitting ? 'Mengirim...' : 'Submit Challenge'"></span>
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