<div
    id="certificate"
    x-data="certificate($params.code)"
    x-effect="loadPage(`/certificate/data/${$params.code}`)">

    <div id="app-header" class="appHeader main border-0">
        <div class="left">
            <a class="headerButton" :href="`/courses/intro/${data.course?.id}/${data.course?.slug}`"><i class="bi bi-chevron-left"></i></a>
        </div>
        <div class="">Sertifikat</div>
    </div>

    <div id="appCapsule" class="pt-0 bg-white">
        <div class="appContent px-0" style="min-height:90vh;">
            <div class="container px-0">
                <div x-show="data.student.cert_claim_date">
                    <div class="text-center">
                        <div id="print-area" class="position-relative table-responsive shadow">
                            <img :src="data.student.cert_url[1] + '?' + (Math.floor(new Date(data.student.updated_at.replace(' ', 'T')).getTime() / 1000))" id="img-cert" class="position-relative">
                        </div>
                    </div>
                    <div class="mt-4 px-3 text-center">
                        <div>Sertifikat ini adalah dokumen resmi dan valid dirilis oleh CODEPOLITAN</div>
                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <button @click="downloadImagesAsZip()" class="btn btn-primary rounded-pill"><i class="bi bi-download"></i> Unduh</button>
                        </div>
                    </div>
                </div>


                <div class="text-center" x-show="!data.student">
                    <h4>404</h4>
                    <p>Kode sertifikat tidak valid</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('certificate/script') ?>