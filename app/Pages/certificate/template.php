<div
    id="certificate"
    x-data="certificate($params.id)"
    x-effect="loadPage(`/certificate/data/${$params.id}`)"
>
    <div id="appCapsule" class="pt-0 bg-white">
        <div class="appContent" style="min-height:90vh;">
            <div class="container pt-5">
                <div class="text-center table-responsive shadow">
                    <div id="print-area" class="position-relative">
                        <img src="<?= base_url('mobilekit/assets/img/template-certificate.jpg') ?>" id="img-cert" class="position-relative" alt="">
                        <div class="text-primary position-absolute" id="no-certi">No: CP-RAI/2025/V/0001</div>
                        <h3 class="text-primary position-absolute" id="name-certi">Aldiansyah Ibrahim</h3>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <h3>Congratulations</h3>
                    <div>Sertifikat ini adalah dokumen resmi dan valid dirilis <br> oleh CODEPOLITAN</div>
                    <div class="d-flex gap-2 justify-content-center mt-3">
                        <button onclick="printArea('print-area')" class="btn btn-primary rounded-pill"><i class="bi bi-download"></i> Unduh</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printArea(areaId) {

            var printContents = document.getElementById(areaId).outerHTML; // Menggunakan outerHTML
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

            location.reload(); // Jika perlu reload untuk event listeners
        }
    </script>

    <?= $this->include('certificate/script') ?>
</div>