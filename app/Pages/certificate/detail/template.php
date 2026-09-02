<div
    id="certificate_print"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `certificate/detail/data/${$params.code}`
        })">

    <div id="appCapsule" class="mt-4" x-data="render_certificate()">

        <style>
            /* ==============================================================
               TEMA GELAP — disamakan dengan dashboard home user (tanpa ubah logic)
               ============================================================== */
            #certificate_print {
                background-color: var(--rd-bg);
                color: var(--rd-text);
                min-height: 100vh;
            }
            #certificate_print #appCapsule {
                background-color: var(--rd-bg) !important;
                color: var(--rd-text);
            }
            #certificate_print .appContent { color: var(--rd-text); }

            /* Judul & teks */
            #certificate_print h1, #certificate_print h2, #certificate_print h3,
            #certificate_print h4, #certificate_print h5, #certificate_print h6 {
                color: var(--rd-text) !important;
            }
            #certificate_print p {
                color: var(--rd-text-muted) !important;
            }
            #certificate_print strong {
                color: var(--rd-text) !important;
            }

            /* Tombol kembali */
            #certificate_print a[href="/certificate"] {
                color: var(--rd-text) !important;
                text-decoration: none;
            }
            #certificate_print a[href="/certificate"] i {
                color: var(--rd-primary) !important;
            }

            /* Tombol unduh */
            #certificate_print .btn-secondary {
                background-color: var(--rd-primary) !important;
                border-color: var(--rd-primary) !important;
                color: var(--rd-primary-contrast, #fff) !important;
            }

            /* Preview PDF (wadah) */
            #certificate_print #pdf-pages {
                background: var(--rd-surface) !important;
                border: 1px solid var(--rd-border) !important;
                border-radius: 8px;
            }
        </style>

        <template x-if="data?.status !== 'failed'">
            <div class="appContent" style="min-height:90vh;">
                <a href="/certificate" class="mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left-circle-fill fs-2 text-secondary"></i>
                    <h4 class="m-0">Kembali</h4>
                </a>

                <div class="mt-3 text-center">
                    <p>
                        Sertifikat ini valid diterbitkan oleh PT CODEPOLITAN INTEGRASI INDONESIA
                        untuk peserta atas nama <strong x-text="data.claimer?.name"></strong>.</p>

                    <p>
                        Program: <strong x-text="data.claimer?.course"></strong> <br>
                        Tanggal Terbit: <strong x-text="data.claimer?.publishDate"></strong> <br>
                        Nomor Sertifikat: <strong x-text="data.claimer?.number"></strong></p>

                        <button
                            x-show="localStorage.getItem('heroic_token')"
                            @click="downloadPDF()"
                            class="btn btn-secondary mb-3">Unduh PDF Sertifikat</button>
                </div>

                <!-- Wadah preview -->
                <div id="pdf-container" style="width:100%; max-width:900px; margin:0 auto; position:relative">

                    <!-- Container multi halaman -->
                    <div id="pdf-pages" style="width:100%; border-radius:8px; position:relative; background:#f8f8f8"></div>

                    <p @click="window.location.reload()"
                        style="position: absolute; top: 1%; right: 1%; cursor: pointer; font-size: 12px; background: #eee; padding: 11px 20px; border-radius: 50px; font-style: italic; opacity: .5">
                        Klik untuk refresh preview
                    </p>

                    <template x-if="data.claimer?.number">
                        <div x-init="previewPDF()"></div>
                    </template>
                </div>

            </div>
        </template>

    </div>
</div>

<?= $this->include('certificate/detail/script'); ?>