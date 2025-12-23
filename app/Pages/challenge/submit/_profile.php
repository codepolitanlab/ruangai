<!-- Meta Pixel Code (added for Save Data tracking) -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '745152591506359');
fbq('track', 'PageView');

// helper to track save button
window.trackSaveProfile = function(info = {}) {
    if (typeof fbq === 'function') {
        fbq('trackCustom', 'SaveProfile', info);
    }
};
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=745152591506359&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<div class="accordion rounded-4 mb-3" id="profileAccordion">
    <div class="accordion-item rounded-4 border-0 shadow-sm">
        <h2 class="accordion-header" id="headingProfile">
            <button
                class="fs-6 fw-bold accordion-button accordion-button-green"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseProfile" aria-expanded="true"
                aria-controls="collapseProfile">
                1. Lengkapi Data Diri
            </button>
        </h2>
        <div id="collapseProfile" class="accordion-collapse collapse show" aria-labelledby="headingProfile" data-bs-parent="#profileAccordion">
            <div class="accordion-body">

                <!-- Teks panduan -->
                <div class="card p-3 shadow-none border mb-4 panduan">
                    <h5 class="mb-2">Panduan Pendaftaran & Aktivasi</h5>
                    <ol class="mb-0">
                        <li><strong>GenAI Video Fest</strong> tidak dipungut biaya (gratis).</li>
                        <li>Peserta wajib memasukkan kartu Debit/Kredit pada akun Alibaba Cloud untuk mengaktifkan trial <a target="_blank" class="fw-bold" href="https://s.id/WanModelStudio">Alibaba Cloud Model Studio</a>.</li>
                        <li>Panduan registrasi akun Alibaba Cloud tersedia dalam <a class="fw-bold" target="_blank" href="https://www.youtube.com/watch?v=lFLDUMHjEfc">video tutorial berikut</a>.</li>
                        <li>Peserta yang tidak memiliki kartu kredit dapat menggunakan kartu debit fisik berlogo Visa atau Mastercard, seperti BCA, Mandiri, Jenius, Jago, atau bank lainnya yang mendukung transaksi internasional.</li>
                        <li>Pastikan fitur transaksi online dan internasional pada kartu debit telah aktif.</li>
                        <li>Pastikan kartu memiliki saldo minimal Rp100.000 dan pernah digunakan untuk transaksi sebelumnya (misalnya pembelian pulsa, belanja online, atau pembayaran QRIS) guna meminimalkan risiko verifikasi gagal.</li>
                        <li>Proses verifikasi kartu akan dilakukan melalui simulasi transaksi sebesar USD 1 dan saldo akan dikembalikan secara otomatis dalam beberapa jam setelah proses verifikasi berhasil.</li>
                    </ol>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.name" :class="{'is-invalid': profileErrors.name}" disabled>
                        <template x-if="profileErrors.name">
                            <small class="text-danger" x-text="profileErrors.name"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" x-model="profile.email" :class="{'is-invalid': profileErrors.email}" disabled>
                        <template x-if="profileErrors.email">
                            <small class="text-danger" x-text="profileErrors.email"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.whatsapp" placeholder="62812xxxx" :class="{'is-invalid': profileErrors.whatsapp}" disabled>
                        <template x-if="profileErrors.whatsapp">
                            <small class="text-danger" x-text="profileErrors.whatsapp"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" x-model="profile.birth_date" :class="{'is-invalid': profileErrors.birth_date}">
                        <small class="form-text text-muted">Minimal usia 17 tahun</small>
                        <template x-if="profileErrors.birth_date">
                            <small class="text-danger d-block" x-text="profileErrors.birth_date"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" x-model="profile.gender" :class="{'is-invalid': profileErrors.gender}">
                            <option value="">-Pilih-</option>
                            <option value="male">Pria</option>
                            <option value="female">Wanita</option>
                        </select>
                        <template x-if="profileErrors.gender">
                            <small class="text-danger" x-text="profileErrors.gender"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Profesi <span class="text-danger">*</span></label>
                        <select class="form-select" x-model="profile.profession" :class="{'is-invalid': profileErrors.profession}">
                            <option value="">-Pilih-</option>
                            <option value="jobseeker">Job Seeker / Pencari Kerja</option>
                            <option value="college_student">Mahasiswa</option>
                            <option value="student">Pelajar</option>
                            <option value="entrepreneur">Wirausaha (UMKM)</option>
                            <option value="employee">Karyawan / Profesional / PNS</option>
                            <option value="freelance">Freelance</option>
                            <option value="fresh_graduate">Fresh Graduate</option>
                        </select>

                        <template x-if="profileErrors.profession">
                            <small class="text-danger" x-text="profileErrors.profession"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Instansi / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.company" :class="{'is-invalid': profileErrors.company}">
                        <template x-if="profileErrors.company">
                            <small class="text-danger" x-text="profileErrors.company"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Link Profil X <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" x-model="profile.x_profile_url" placeholder="Masukkan URL Profil X Kamu" :class="{'is-invalid': profileErrors.x_profile_url}">
                        <small class="form-text text-muted">Contoh: https://x.com/username</small>
                        <template x-if="profileErrors.x_profile_url">
                            <small class="text-danger d-block" x-text="profileErrors.x_profile_url"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mb-0">AlibabaCloud ID <span class="text-danger">*</span></label>
                        <small class="mb-2 d-block">Daftar akun Alibaba Cloud dan WAN Model Studio <a href="https://s.id/WanModelStudio" target="_blank">DI SINI</a></small>
                        <input type="text" class="form-control" x-model="profile.alibabacloud_id" :class="{'is-invalid': profileErrors.alibabacloud_id}" inputmode="numeric" pattern="[0-9]*" @input="profile.alibabacloud_id = profile.alibabacloud_id.replace(/[^0-9]/g, '')" placeholder="Cth: 5921721919160498">
                        <template x-if="profileErrors.alibabacloud_id">
                            <small class="text-danger" x-text="profileErrors.alibabacloud_id"></small>
                        </template>
                    </div>

                    <div class="col-12">
                        <label class="form-label mb-0">Alibaba Account Screenshot <span class="text-danger">*</span></label>
                        <small class="mb-2 d-block">Lihat contoh screenshoot <a href="https://image.web.id/images/contoh_akun_alibabacloud.jpg" target="_blank">DI SINI</a></small>
                        <input type="file" class="form-control" accept="image/*" @change="handleProfileScreenshot($event)" :class="{'is-invalid': profileErrors.alibabacloud_screenshot}">
                        <template x-if="profile.alibabacloud_screenshot">
                            <div class="mt-2 small text-muted">Tersimpan: <span x-text="profile.alibabacloud_screenshot"></span></div>
                        </template>
                        <template x-if="profileErrors.alibabacloud_screenshot">
                            <small class="text-danger" x-text="profileErrors.alibabacloud_screenshot"></small>
                        </template>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-success" @click="trackSaveProfile({email: profile.email, name: profile.name}); saveProfile()" :disabled="isSavingProfile">
                        <template x-if="isSavingProfile">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                        </template>
                        <span x-text="isSavingProfile ? 'Menyimpan...' : 'Simpan Data'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>