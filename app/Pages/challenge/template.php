<div
    id="challenge"
    x-data="challenge()">

    <div id="appCapsule">

        <style>
            /* Bootstrap 5 Accordion Custom Styling */
            .accordion {
                --bs-accordion-border-radius: 1rem;
            }
            .accordion-button {
                font-size: 1.05rem;
                font-weight: 600;
                padding: 1.25rem 1.5rem;
                background-color: white !important;
                color: #1f2937 !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 1rem !important;
            }
            .accordion-button:not(.collapsed) {
                background-color: white !important;
                color: #1f2937 !important;
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }
            .accordion-button:focus {
                box-shadow: none !important;
                border-color: transparent !important;
            }
            .accordion-button::after {
                width: 1.25rem;
                height: 1.25rem;
                background-size: 1.25rem;
                filter: brightness(0) saturate(100%) invert(47%) sepia(6%) saturate(434%) hue-rotate(179deg) brightness(92%) contrast(86%);
            }
            .accordion-body {
                background-color: #F7F7F7;
                color: #4b5563;
                padding: 1.25rem 1.5rem 1.5rem 1.5rem;
                border-bottom-left-radius: 1rem !important;
                border-bottom-right-radius: 1rem !important;
            }
            .accordion-item {
                border: 1px solid #e5e7eb !important;
                border-radius: 1rem !important;
                overflow: hidden;
                margin-bottom: 1rem;
                background: white;
            }
            .accordion-item:first-of-type .accordion-button {
                border-top-left-radius: 1rem !important;
                border-top-right-radius: 1rem !important;
            }
            .accordion-item:last-of-type {
                margin-bottom: 1.5rem;
            }
            .accordion-collapse {
                border: none !important;
            }

            /* Small responsive tweaks */
            @media (max-width: 576px) {
                .challenge-hero h1 { font-size: 1.4rem !important; }
                .challenge-hero .display-5 { font-size: 1.5rem !important; }
                .challenge-hero .p-4 { padding-top: 28px !important; padding-bottom: 28px !important; }
            }
        </style>

        <!-- Hero -->
        <a native target="_blank" href="https://www.ruangai.id/genaivideofest">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%2010476.png" class="w-100 rounded-bottom-5" alt="">
        </a>

        <!-- Details -->
        <div id="details" class="mt-4 px-3 px-md-0">
            
            <!-- Email Verification Warning -->
            <template x-if="!data.isValidEmail">
                <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">
                        <strong>Email Belum Terverifikasi!</strong><br>
                        <small>Silakan verifikasi email Anda terlebih dahulu untuk dapat submit karya.</small>
                    </div>
                    <a href="/verify_email" class="btn btn-sm btn-warning ms-2">Verifikasi</a>
                </div>
            </template>

            <div class="card rounded-4 mb-3 shadow-sm">
                <!-- Tombol video panduan pendaftaran -->
                <div class="card-body px-4">
                    <h5 class="mb-3">Panduan Pendaftaran</h5>
                    <a 
                        native 
                        target="_blank" 
                        href="https://www.youtube.com/watch?v=lFLDUMHjEfc" 
                        class="btn btn-outline-primary py-4 px-3 d-flex align-items-top rounded-3 mb-1 justify-content-start fs-6 text-start">
                        <i class="bi bi-play-circle fs-3 me-2 pt-1"></i>
                        Panduang Pendaftaran Akun Alibaba Cloud
                    </a>
                    <a 
                        native 
                        target="_blank" 
                        href="https://youtu.be/lFLDUMHjEfc?si=EYjraLUuhAJLXgvL&t=372" 
                        class="btn btn-outline-primary py-4 px-3 d-flex align-items-top rounded-3 mb-1 justify-content-start fs-6 text-start">
                        <i class="bi bi-play-circle fs-3 me-2 pt-1"></i>
                        Tutorial Generate Video di WAN Model Studio
                    </a>
                </div>
            </div>

            <div class="accordion bg-transparent border-0" id="challengeAccordion">
                
                <!-- Persyaratan Pendaftaran -->
                <div class="accordion-item">
                    <h1 class="m-0">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Persyaratan Pendaftaran
                        </button>
                    </h1>
                    <div id="collapseOne" class="accordion-collapse collapse show p-4 pt-0">
                        <div class="accordion-body rounded-4">
                            <p class="mb-2">Untuk mengikuti GenAI Video Fest, peserta wajib memenuhi ketentuan berikut:</p>
                            <ul class="mb-0">
                                <li>Memiliki akun <a class="fw-bold" href="https://s.id/WanModelStudio" target="_blank">Alibaba Cloud</a> yang aktif.</li>
                                <li>Mengikuti akun X resmi <a class="fw-bold" href="https://x.com/codepolitan" target="_blank">@codepolitan</a>, dan <a class="fw-bold" href="https://x.com/alibaba_cloud" target="_blank">@alibaba_cloud</a>.</li>
                                <li>Wajib menggunakan <a class="fw-bold" href="https://s.id/WanModelStudio" target="_blank">WAN Model Studio</a>. Penggunaan model atau tools AI lain diperbolehkan sebagai tambahan (opsional).</li>
                                <li>1 akun hanya diperbolehkan 1 submission.</li>
                                <li>Memiliki Kartu Debit/Kredit Pribadi</li>
                                <li>Wajib menandatangani pernyataan etika dan hak cipta.</li>
                                <li>Konten terlarang akan langsung didiskualifikasi.</li>
                                <li>Karya harus orisinal dan belum pernah dipublikasikan di mana pun.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CTA Button -->
            <div class="mt-4 mb-2">
                <a :href="data && data.isValidEmail === true ? '/challenge/submit' : '#'" 
                   @click="!data || data.isValidEmail === false ? handleUnverifiedClick($event) : null"
                   class="btn btn-lg w-100 d-flex align-items-center justify-content-center" 
                   :class="!data || data.isValidEmail === false ? 'disabled' : ''"
                   style="background:#ff6b35; border:none; color:#fff; font-size: 1.1rem; font-weight: 700; padding: 1rem 2rem; border-radius: 2rem;">
                    SUBMIT KARYA
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ms-2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
            
            <!-- CTA Button -->
            <div class="mb-5">
                <a native target="_blank" href="https://ruangai.id/genaivideofest#faq" class="btn btn-outline-primary btn-lg w-100 d-flex align-items-center justify-content-center" style="font-size: 1.1rem; font-weight: 700; padding: 1rem 2rem; border-radius: 2rem;">
                    <i class="bi bi-question-square fs-4"></i>
                    Frequently Asked Questions
                </a>
            </div>

        </div>

        <!-- Small footer note -->
        <!-- <div class="text-center text-muted small mb-4">Untuk informasi lengkap dan syarat detail, klik "Lihat Selengkapnya"</div> -->
    <?= $this->include('challenge/script') ?>

    </div>

    <?= $this->include('_bottommenu') ?>
</div>
