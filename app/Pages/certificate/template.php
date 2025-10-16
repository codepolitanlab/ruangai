<div
    id="certificate_print"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `certificate/data/${$params.code}`
        })">

    <div id="appCapsule" class="mt-4" x-data="render_certificate()">

        <template x-if="data?.status !== 'failed'">
            <div class="appContent" style="min-height:90vh;">
                <a href="/courses" class="mb-4 d-flex align-items-center gap-2">
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

<?= $this->include('certificate/script'); ?>