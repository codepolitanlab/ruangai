<div
    id="certificate_claim"
    x-data="certificate_claim($params.course_id)"
    x-effect="loadPage(`/certificate/claim/data/${$params.course_id}`)"
>
    <?= $this->include('_appHeader'); ?>

    <div id="appCapsule" class="pt-0">
        <div class="appContent" style="min-height:90vh;">
            <div class="pt-4">

                <div x-show="data.status == 'error'">
                    <p class="alert alert-warning" x-text="data.message"></p>
                    <a href="/" class="btn btn-link"><span class="bi bi-arrow-left"></span> Kembali</a>
                </div>
                
                <div x-show="!data.student.cert_claim_date">
                    <!-- Show form feedback with rating star -->
                    <div class="card shadow-none rounded-4">
                        <div class="card-body">
                            <div class="text-center">
                                <h2 class="mb-4">Klaim Sertifikat</h2>
                            </div>
                            <p>Tulis testimoni kamu selama belajar di RuangAI </p>
                            <form @submit.prevent="submitFeedback">
                                <div class="form-group mb-3">
                                    <textarea minlength="15" cols="30" rows="5" class="form-control" placeholder="Tulis testimoni di sini" x-model="data.comment" required></textarea>
                                </div>
                                <div class="mt-4">Berikan <em>rating</em> kepuasan kamu belajar di RuangAI</div>
                                <div x-data="{ localRating: data.rating || 0 }" class="d-flex mt-2">
                                    <template x-for="i in 4" :key="i">
                                        <svg @click="localRating = i; data.rating = i"
                                            :class="{'text-warning': i <= localRating, 'text-muted opacity-50': i > localRating}"
                                            class="bi bi-star-fill"
                                            width="30" height="30" fill="currentColor" viewBox="0 0 16 16"
                                            style="cursor: pointer;">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.997L.945 7.085c-.322-.322-.12-.76.223-.788l4.042-.56L6.99 1.498c.183-.343.6-.343.784 0l1.853 3.53L14.85 6.297c.343.028.545.466.223.788l-3.69 3.612.83 4.997c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                    </template>
                                </div>
                                <div class="form-group mt-4">
                                    <p>Pastikan nama (dan gelar) sudah benar untuk dicetak di sertifikat. Gunakan huruf kapital hanya di awal kata.</p>
                                    <input type="text" class="form-control" x-model="data.student.name" required>
                                    <p class="small text-warning">Sertifikat hanya dapat digenerate satu kali</p>
                                </div>
                                <div class="form-group my-4">
                                    <button 
                                     type="submit" 
                                     class="btn btn-primary btn-lg w-100"
                                     :class="submitting ? 'btn-progress' : ''">Submit dan Klaim Sertifikat</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('certificate/claim/script') ?>