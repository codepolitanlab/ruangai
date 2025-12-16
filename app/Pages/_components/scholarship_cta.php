<!-- Component: Scholarship Registration CTA -->
<!-- Untuk user kompetisi yang belum mendaftar beasiswa -->

<template x-if="!data?.is_scholarship_participant">
    <div class="card bg-gradient-primary rounded-4 mb-3 shadow">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-mortarboard-fill text-primary fs-3"></i>
                        </div>
                        <div class="text-white">
                            <h4 class="mb-2 fw-bold">Program Beasiswa RuangAI</h4>
                            <p class="mb-0 opacity-90">Bergabunglah dengan ribuan peserta lainnya dalam program beasiswa kami dan raih kesempatan belajar gratis dengan mentor berpengalaman.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center mt-3 mt-md-0">
                    <a :href="data?.scholarship_url || 'https://ruangai.id'" 
                       target="_blank"
                       class="btn btn-light btn-lg rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-box-arrow-up-right me-2"></i>
                        Daftar Beasiswa
                    </a>
                    <small class="d-block mt-2 text-white opacity-75">Gratis & Bersertifikat</small>
                </div>
            </div>
        </div>
    </div>
</template>
