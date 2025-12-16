<div class="accordion rounded-4 mb-3" id="profileAccordion">
    <div class="accordion-item rounded-4 border-0 shadow-sm">
        <h2 class="accordion-header" id="headingProfile">
            <button 
                class="fs-6 fw-bold accordion-button" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseProfile" aria-expanded="true" 
                aria-controls="collapseProfile">
                Lengkapi Data Diri (+100 poin)
            </button>
        </h2>
        <div id="collapseProfile" class="accordion-collapse collapse show" aria-labelledby="headingProfile" data-bs-parent="#profileAccordion">
            <div class="accordion-body">
                <p class="small text-muted">Lengkapi data dengan informasi yang valid. Data dapat diupdate jika diperlukan.</p>

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
                        <input type="text" class="form-control" x-model="profile.whatsapp" placeholder="62812xxxx" :class="{'is-invalid': profileErrors.whatsapp}">
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

                    <!-- <div class="col-12">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.address" :class="{'is-invalid': profileErrors.address}">
                        <template x-if="profileErrors.address">
                            <small class="text-danger" x-text="profileErrors.address"></small>
                        </template>
                    </div> -->

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

                    <!-- <div class="col-md-6">
                        <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.job_title" :class="{'is-invalid': profileErrors.job_title}">
                        <template x-if="profileErrors.job_title">
                            <small class="text-danger" x-text="profileErrors.job_title"></small>
                        </template>
                    </div> -->

                    <div class="col-md-6">
                        <label class="form-label">Instansi / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.company" :class="{'is-invalid': profileErrors.company}">
                        <template x-if="profileErrors.company">
                            <small class="text-danger" x-text="profileErrors.company"></small>
                        </template>
                    </div>

                    <!-- <div class="col-md-6">
                        <label class="form-label">Industri Institusi / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.industry" :class="{'is-invalid': profileErrors.industry}">
                        <template x-if="profileErrors.industry">
                            <small class="text-danger" x-text="profileErrors.industry"></small>
                        </template>
                    </div> -->

                    <div class="col-md-6">
                        <label class="form-label">Link Profil X <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" x-model="profile.x_profile_url" placeholder="https://x.com/username" :class="{'is-invalid': profileErrors.x_profile_url}">
                        <small class="form-text text-muted">Contoh: https://x.com/username</small>
                        <template x-if="profileErrors.x_profile_url">
                            <small class="text-danger d-block" x-text="profileErrors.x_profile_url"></small>
                        </template>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">AlibabaCloud ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" x-model="profile.alibabacloud_id" :class="{'is-invalid': profileErrors.alibabacloud_id}">
                        <template x-if="profileErrors.alibabacloud_id">
                            <small class="text-danger" x-text="profileErrors.alibabacloud_id"></small>
                        </template>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alibaba Account Screenshot <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" @change="handleProfileScreenshot($event)" :class="{'is-invalid': profileErrors.alibabacloud_screenshot}">
                        <template x-if="profile.alibabacloud_screenshot">
                            <div class="mt-2 small text-muted">Tersimpan: <span x-text="profile.alibabacloud_screenshot"></span></div>
                        </template>
                        <template x-if="profileErrors.alibabacloud_screenshot">
                            <small class="text-danger" x-text="profileErrors.alibabacloud_screenshot"></small>
                        </template>
                    </div>

                    <!-- <div class="col-md-6">
                        <label class="form-label">Kode Referral</label>
                        <input type="text" class="form-control" x-model="profile.referral_code">
                    </div> -->

                    <div class="col-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" x-model="profile.agreed_terms" id="agreeTerms" :class="{'is-invalid': profileErrors.agreed_terms}">
                            <label class="form-check-label" for="agreeTerms">
                                Saya menyatakan bahwa karya ini adalah hasil saya sendiri, tidak melanggar hak cipta pihak ketiga, dan memberi izin kepada RuangAI/Codepolitan untuk menampilkan karya ini untuk keperluan promosi. *
                            </label>
                        </div>
                        <template x-if="profileErrors.agreed_terms">
                            <small class="text-danger" x-text="profileErrors.agreed_terms"></small>
                        </template>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <!-- <button type="button" class="btn btn-outline-secondary me-2" @click="resetProfile()">Reset</button> -->
                    <button type="button" class="btn btn-success" @click="saveProfile()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</div>