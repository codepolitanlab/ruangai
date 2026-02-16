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
        fbq('trackCustom', 'Leads', info);
    }
};
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=745152591506359&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<div class="row g-4">
    <div class="col-12 col-lg-7 order-lg-first order-last">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Step 1 - Lengkapi Data Diri</h5>
                        <p class="text-muted mb-0">Pastikan data profil sesuai agar proses verifikasi berjalan lancar.</p>
                    </div>
                    <span class="badge bg-success ms-md-auto" x-show="isProfileComplete()" x-cloak>Profil Lengkap</span>
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
                        <input type="date" class="form-control" x-model="profile.birthday" :class="{'is-invalid': profileErrors.birthday}" :disabled="emailNotVerified">
                        <small class="form-text text-muted">Minimal usia 17 tahun</small>
                        <template x-if="profileErrors.birthday">
                            <small class="text-danger d-block" x-text="profileErrors.birthday"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" x-model="profile.gender" :class="{'is-invalid': profileErrors.gender}" :disabled="emailNotVerified">
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
                        <select class="form-select" x-model="profile.occupation" :class="{'is-invalid': profileErrors.occupation}" :disabled="emailNotVerified">
                            <option value="">-Pilih-</option>
                            <option value="jobseeker">Job Seeker / Pencari Kerja</option>
                            <option value="college_student">Mahasiswa</option>
                            <option value="student">Pelajar</option>
                            <option value="entrepreneur">Wirausaha (UMKM)</option>
                            <option value="employee">Karyawan / Profesional / PNS</option>
                            <option value="freelance">Freelance</option>
                            <option value="fresh_graduate">Fresh Graduate</option>
                        </select>

                        <template x-if="profileErrors.occupation">
                            <small class="text-danger" x-text="profileErrors.occupation"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Instansi / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.institution" :class="{'is-invalid': profileErrors.institution}" :disabled="emailNotVerified">
                        <template x-if="profileErrors.institution">
                            <small class="text-danger" x-text="profileErrors.institution"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Link Profil X <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" x-model="profile.x_profile_url" placeholder="Masukkan URL Profil X Kamu" :class="{'is-invalid': profileErrors.x_profile_url}" :disabled="emailNotVerified">
                        <small class="form-text text-muted">Contoh: https://x.com/username</small>
                        <template x-if="profileErrors.x_profile_url">
                            <small class="text-danger d-block" x-text="profileErrors.x_profile_url"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label mb-0">AlibabaCloud ID <span class="text-danger">*</span></label>
                        <small class="mb-2 d-block">Daftar akun Alibaba Cloud dan WAN Model Studio <a href="https://s.id/WanModelStudio" target="_blank">DI SINI</a></small>
                        <input type="text" class="form-control" x-model="profile.alibaba_cloud_id" :class="{'is-invalid': profileErrors.alibaba_cloud_id}" inputmode="numeric" pattern="[0-9]*" @input="profile.alibaba_cloud_id = profile.alibaba_cloud_id.replace(/[^0-9]/g, '')" placeholder="Cth: 5921721919160498" :disabled="emailNotVerified">
                        <template x-if="profileErrors.alibaba_cloud_id">
                            <small class="text-danger" x-text="profileErrors.alibaba_cloud_id"></small>
                        </template>
                    </div>

                    <div class="col-12">
                        <label class="form-label mb-0">Alibaba Account Screenshot <span class="text-danger">*</span></label>
                        <small class="mb-2 d-block">Lihat contoh screenshoot <a href="https://image.web.id/images/contoh_akun_alibabacloud.jpg" target="_blank">DI SINI</a></small>
                        <input type="file" class="form-control" accept="image/*" @change="handleProfileScreenshot($event)" :class="{'is-invalid': profileErrors.alibaba_cloud_screenshot}" :disabled="emailNotVerified">
                        <template x-if="profile.alibaba_cloud_screenshot">
                            <div class="mt-2 small text-muted">Tersimpan: <span x-text="profile.alibaba_cloud_screenshot"></span></div>
                        </template>
                        <template x-if="profileErrors.alibaba_cloud_screenshot">
                            <small class="text-danger" x-text="profileErrors.alibaba_cloud_screenshot"></small>
                        </template>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-success" @click="trackSaveProfile({email: profile.email, name: profile.name}); saveProfile()" :disabled="isSavingProfile || emailNotVerified">
                        <template x-if="isSavingProfile">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                        </template>
                        <span x-text="isSavingProfile ? 'Menyimpan...' : 'Simpan Data'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5 order-first order-lg-last">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body panduan">
                <h5 class="mb-3">Panduan Pendaftaran</h5>
                <ol class="mb-0 ps-3">
                    <li>Melakukan Verifikasi Email akunmu;</li>
                    <li>Masukkan ID Alibaba Cloud aktif kamu (<a target="_blank" href="https://account.alibabacloud.com/login/login.htm?oauth_callback=https%3A%2F%2Fmodelstudio.console.alibabacloud.com%2Fap-southeast-1%2F%3Fsource_channel%3DCodePolitan%26tab%3Ddashboard%23%2Fefm%2Fmodel_experience_center%2Fvision%3FcurrentTab%3DvideoGenerate&clearRedirectCookie=1">buat akun Alibaba Cloud</a>);</li>
                    <li>Masukkan Link Profil akun X yang kamu gunakan untuk submit karya;</li>
                    <li>Upload screenshot halaman ID Alibabacloud (untuk verifikasi);</li>
                    <li>
                        Untuk Panduan lainnya, akses link berikut:
                        <ul class="mt-2">
                            <li>Link Video/Artikel buat akun alibaba: <a href="#" target="_blank">Link</a></li>
                            <li>Link Video/Artikel buat video di wan.video: <a href="#" target="_blank">Link</a></li>
                            <li>Link Video/Artikel cara buat video di WAN Model Studio: <a href="#" target="_blank">Link</a></li>
                            <li>Panduan membuat video kreatif yang mengkombinasikan beberapa tools AI selain WAN: <a href="#" target="_blank">Link Rekaman Video ruangAI (wan + suno)</a></li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>