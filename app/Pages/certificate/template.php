<div
    id="certificate"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `certificate/data`
        })">

    <div id="appCapsule">
        <div class="appContent py-4">
            <div class="header-large-title mb-4 ps-0">
                <h2 class="h3 fw-normal">Sertifikat Saya</h2>
			</div>
            
            <div class="row g-3">
                <template x-for="cert in data.certificates" :key="cert.cert_code">
                    <a :href="`/certificate/${cert.cert_code}`">
                        <div class="col-12">
                            <div class="cert-card d-flex align-items-stretch shadow-sm rounded-4">
                                <div class="cert-stripe" :class="{
                                    'bg-primary': cert.entity_type === 'course',
                                    'bg-warning': cert.entity_type === 'workshop',
                                    'bg-secondary': cert.entity_type !== 'course' && cert.entity_type !== 'workshop'
                                }"></div>

                                <div class="cert-body flex-grow-1 p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <h5 class="fs-5 text-primary mb-0 me-2" x-text="cert.title"></h5>
                                            </div>
                                            <p class="mb-1 text-muted small">
                                                <h5 x-text="cert.participant_name"></h5>
                                            </p>
                                            <p class="mb-0 text-muted" style="font-size: 13px;">
                                                <b>Nomor:</b> <span x-text="cert.cert_number"></span> <br>
                                                <b>Diterbitkan:</b> <span x-text="$heroicHelper.formatDate(cert.cert_claim_date)"></span>
                                            </p>
                                        </div>

                                        <div class="text-end ms-2">
                                            <div class="mb-2">
                                                <span class="px-2 py-1 rounded-2 border border-warning text-warning" x-text="cert.entity_type"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            <style>
            .cert-card { background: #fff; overflow: hidden; }
            .cert-card .cert-stripe { width:6px; }
            .cert-card .cert-body { min-height:110px; }
            @media (max-width: 576px) {
                .cert-card .cert-body { min-height:120px; }
            }
            </style>
    </div>

    <?= $this->include('_bottommenu'); ?>
</div>
