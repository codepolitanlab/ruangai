<div class="accordion rounded-4 mb-3" id="videoAccordion">
    <div class="accordion-item rounded-4 border-0 shadow-sm">
        <h2 class="accordion-header" id="headingVideo">
            <button
                class="fs-6 fw-bold accordion-button accordion-button-green"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseVideo" aria-expanded="true"
                aria-controls="collapseVideo">
                2. Informasi Video
            </button>
        </h2>
        <div id="collapseVideo" class="accordion-collapse collapse show" aria-labelledby="headingVideo" data-bs-parent="#videoAccordion">
            <div class="accordion-body">

                <!-- Teks panduan -->
                <div class="card p-3 shadow-none border mb-4 panduan">
                    <h5 class="mb-2">Panduan Pengumpulan Karya</h5>
                    <ol class="mb-0">
                        <li>Buat video berdurasi minimal 15 detik (tanpa batas durasi maksimal) menggunakan WAN Model Studio dari Alibaba Cloud.</li>
                        <li>Panduan penggunaan WAN Model Studio dapat diakses melalui <strong><a target="_blank" href="https://www.youtube.com/watch?v=lFLDUMHjEfc">video tutorial berikut</a></strong>.</li>
                        <li>Unggah video karya Anda ke platform X dengan pengaturan publik, lalu salin URL postingan video dan tempelkan pada kolom <strong>URL Post X</strong>.</li>
                        <li>Isi kolom <strong>Judul Video</strong> dan <strong>Deskripsi Video</strong> secara singkat, jelas, dan relevan dengan isi video.</li>
                        <li>Isi kolom <strong>Tools Lain yang Digunakan (selain WAN Model Studio)</strong> apabila menggunakan tools AI atau tools tambahan lainnya. Biarkan kolom ini kosong jika tidak ada.</li>
                        <li>Unduh Template <strong>Dokumen Prompt</strong> <a native target="_blank" href="https://docs.google.com/document/d/1bmLNpP-GLsdntfIkvMaMUC4DvjoDQPx9pUuSofM4-js/copy">DI SINI</a>, isi sesuai petunjuk, dan unggah kembali dokumen tersebut dalam format <strong>PDF</strong> melalui kolom unggah yang tersedia.</li>
                    </ol>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label d-block mb-0">URL Post X <span class="text-danger">*</span></label>
                    <small class="d-block mb-2">Submit video di X.com dan salin tautannya di sini</small>
                    <input type="url" class="form-control" x-model="form.twitter_post_url"
                        placeholder="Masukkan URL Post X Kamu">
                    <small class="form-text text-muted">Contoh: https://x.com/username/status/123456</small>
                    <i class="clear-input"><i class="bi bi-close-circle"></i></i>

                    <template x-if="errors.twitter_post_url">
                        <small class="text-danger" x-text="errors.twitter_post_url"></small>
                    </template>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Judul Video <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" x-model="form.video_title"
                        placeholder="Judul video Anda">
                    <i class="clear-input"><i class="bi bi-close-circle"></i></i>

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

                <div class="col-12 mb-4" style="display: none;">
                    <label class="form-label">Tools Lain yang Digunakan (selain WAN)</label>
                    <textarea class="form-control" rows="3" x-model="form.other_tools"
                        placeholder="Deskripsikan tools lain yang Anda gunakan"></textarea>

                    <template x-if="errors.other_tools">
                        <small class="text-danger" x-text="errors.other_tools"></small>
                    </template>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label d-block mb-0">Dokumen Prompt <span class="text-danger">*</span></label>
                    <small class="d-block mb-2">Unduh Template dokumen <a native target="_blank" href="https://docs.google.com/document/d/1bmLNpP-GLsdntfIkvMaMUC4DvjoDQPx9pUuSofM4-js/copy">DI SINI</a></small>
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
                            Saya menyatakan bahwa karya ini dibuat salah satunya menggunakan WAN Model Studio dari Alibaba Cloud <span class="text-danger">*</span>
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
                            Saya menyatakan memberi izin kepada CODEPOLITAN dan Alibaba Cloud untuk menggunakan karya ini untuk keperluan promosi <span class="text-danger">*</span>
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
                    <button type="button" class="btn btn-success" @click="submitForm()" :disabled="isSubmitting">
                        <template x-if="isSubmitting">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                        </template>
                        <span x-text="isSubmitting ? 'Mengirim...' : 'Submit Challenge'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>