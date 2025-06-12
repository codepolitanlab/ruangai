<div
    id="certificate"
    x-data="certificate($params.id)"
    x-effect="loadPage(`/certificate/data/${$params.id}`)"
>
    <div id="appCapsule" class="pt-0 bg-white">
        <div class="appContent" style="min-height:90vh;">
            <div class="container pt-5">
                <div x-show="data.student.cert_claim_date">
                    <div class="text-center table-responsive shadow">
                        <div id="print-area" class="position-relative">
                            <img src="<?= base_url('mobilekit/assets/img/template-certificate.jpg') ?>" id="img-cert" class="position-relative" alt="">
                            <div class="text-primary position-absolute" id="no-certi">No: CP-RAI/2025/V/0001</div>
                            <h3 class="text-primary position-absolute" id="name-certi" x-text="data.student.name"></h3>
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


                <div x-show="!data.student.cert_claim_date">
                    <!-- Show form feedback with rating star -->
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h4 class="mb-3">KLAIM Sertifikat</h4>
                            </div>
                            <p>Tulis Testimoni Kamu selama Belajar di RuangAI </p>
                            <form @submit.prevent="submitFeedback">
                                <div class="form-group mb-3">
                                    <textarea minlength="15" cols="30" rows="5" class="form-control" placeholder="tuliskan disini" x-model="data.comment" required></textarea>
                                </div>
                                <div class="mt-4">RATE Kepuasan kamu Belajar di RuangAI</div>
                                <div x-data="{ localRating: data.rating || 0 }" class="d-flex mt-2 mb-5">
                                    <template x-for="i in 4" :key="i">
                                        <svg @click="localRating = i; data.rating = i"
                                            :class="{'text-warning': i <= localRating, 'text-muted': i > localRating}"
                                            class="bi bi-star-fill"
                                            width="30" height="30" fill="currentColor" viewBox="0 0 16 16"
                                            style="cursor: pointer;">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.997L.945 7.085c-.322-.322-.12-.76.223-.788l4.042-.56L6.99 1.498c.183-.343.6-.343.784 0l1.853 3.53L14.85 6.297c.343.028.545.466.223.788l-3.69 3.612.83 4.997c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                    </template>
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Submit dan Claim Certificate</button>
                                </div>
                            </form>
                        </div>
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