<div
    id="challenge-submit"
    x-data="challengeSubmit()"
    x-init="init()">

    <div id="appCapsule">
        <!-- Header -->
        <div class="appHeader bg-primary text-white">
            <div class="left">
                <a href="/challenge" class="headerButton">
                    <i class="bi bi-chevron-back-outline"></i>
                </a>
            </div>
            <div class="pageTitle">Submit Challenge</div>
        </div>

        <!-- Alert Messages -->
        <div class="section mt-2" x-show="alert.show" x-cloak>
            <div class="alert" :class="alert.type === 'error' ? 'alert-danger' : 'alert-success'" role="alert">
                <span x-text="alert.message"></span>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="section mt-3">
            <template x-if="isEdit">
                <div class="alert bg-warning bg-opacity-10 mb-2">
                    Anda masih dapat mengedit submission sebelum batas akhir pendaftaran.
                </div>
            </template>
            
            <div class="card rounded-4 mb-3">
                <div class="card-body">
                    <!-- All fields combined into a single section -->
                    <div>
                        <h5 class="mb-3">Informasi Video</h5>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Twitter Post URL *</label>
                                <input type="url" class="form-control" x-model="form.twitter_post_url" 
                                    placeholder="https://twitter.com/username/status/123456">
                                <i class="clear-input"><i class="bi bi-close-circle"></i></i>
                            </div>
                            <template x-if="errors.twitter_post_url">
                                <small class="text-danger" x-text="errors.twitter_post_url"></small>
                            </template>
                        </div>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Video Title *</label>
                                <input type="text" class="form-control" x-model="form.video_title" 
                                    placeholder="Judul video Anda (min. 5 karakter)">
                                <i class="clear-input"><i class="bi bi-close-circle"></i></i>
                            </div>
                            <template x-if="errors.video_title">
                                <small class="text-danger" x-text="errors.video_title"></small>
                            </template>
                        </div>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Video Description *</label>
                                <textarea class="form-control" rows="3" x-model="form.video_description" 
                                    placeholder="Deskripsikan video Anda (min. 10 karakter)"></textarea>
                            </div>
                            <template x-if="errors.video_description">
                                <small class="text-danger" x-text="errors.video_description"></small>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card rounded-4 mb-3">
                <div class="card-body">
                    <div>
                        <h5>Team Members <small class="text-muted">(max 3)</small></h5>
                        
                        <template x-for="(member, index) in teamMembers" :key="index">
                            <div class="card mb-2 shadow-none border rounded-4 bg-success bg-opacity-10">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong x-text="'Member ' + (index + 1)"></strong>
                                        <button type="button" class="btn btn-sm btn-link text-danger" 
                                            @click="removeMember(index)" 
                                            x-show="index > 0">
                                            <i class="bi bi-trash me-0"></i>
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control mb-2" 
                                            x-model="member.name" 
                                            placeholder="Nama Lengkap *">
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control mb-2" 
                                            x-model="member.email" 
                                            placeholder="Email *">
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" x-model="member.role">
                                            <option value="leader">Leader</option>
                                            <option value="member">Member</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <button type="button" class="btn btn-outline-primary mt-3" 
                            @click="addMember()" 
                            x-show="teamMembers.length < 3">
                            <i class="bi bi-person-plus"></i> Tambah Anggota Tim
                        </button>

                        <template x-if="errors.team_members">
                            <div class="alert alert-danger" x-text="errors.team_members"></div>
                        </template>

                        <!-- Submit/Update will be at the bottom -->
                    </div>
                </div>
            </div>

            <div class="card rounded-4 mb-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">Upload Required Files</h5>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Prompt File (PDF/TXT) *</label>
                                <input type="file" class="form-control" @change="handleFileUpload($event, 'prompt_file')" 
                                    accept=".pdf,.txt">
                                <small class="text-muted">Upload full prompt yang digunakan</small>
                            </div>
                            <template x-if="errors.prompt_file">
                                <small class="text-danger" x-text="errors.prompt_file"></small>
                            </template>
                            <template x-if="files.prompt_file">
                                <div class="badge bg-success mt-1" x-text="files.prompt_file.name"></div>
                            </template>
                            <template x-if="!files.prompt_file && existingFiles.prompt_file">
                                <div class="badge bg-info mt-1" x-text="existingFiles.prompt_file"></div>
                            </template>
                        </div>

                        <!-- <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Params File (JSON) *</label>
                                <input type="file" class="form-control" @change="handleFileUpload($event, 'params_file')" 
                                    accept=".json">
                                <small class="text-muted">Model, version, seed, resolution, fps</small>
                            </div>
                            <template x-if="errors.params_file">
                                <small class="text-danger" x-text="errors.params_file"></small>
                            </template>
                            <template x-if="files.params_file">
                                <div class="badge bg-success mt-1" x-text="files.params_file.name"></div>
                            </template>
                            <template x-if="!files.params_file && existingFiles.params_file">
                                <div class="badge bg-info mt-1" x-text="existingFiles.params_file"></div>
                            </template>
                        </div> -->

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Assets List (TXT)</label>
                                <input type="file" class="form-control" @change="handleFileUpload($event, 'assets_list_file')" 
                                    accept=".txt">
                                <small class="text-muted">Link & license proof (optional)</small>
                            </div>
                            <template x-if="files.assets_list_file">
                                <div class="badge bg-success mt-1" x-text="files.assets_list_file.name"></div>
                            </template>
                            <template x-if="!files.assets_list_file && existingFiles.assets_list_file">
                                <div class="badge bg-info mt-1" x-text="existingFiles.assets_list_file"></div>
                            </template>
                        </div>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Alibaba Cloud Screenshot *</label>
                                <input type="file" class="form-control" @change="handleFileUpload($event, 'alibaba_screenshot')" 
                                    accept="image/*">
                                <small class="text-muted">Screenshot akun Alibaba Model Studio</small>
                            </div>
                            <template x-if="errors.alibaba_screenshot">
                                <small class="text-danger" x-text="errors.alibaba_screenshot"></small>
                            </template>
                            <template x-if="files.alibaba_screenshot">
                                <div class="badge bg-success mt-1" x-text="files.alibaba_screenshot.name"></div>
                            </template>
                            <template x-if="!files.alibaba_screenshot && existingFiles.alibaba_screenshot">
                                <div class="badge bg-info mt-1" x-text="existingFiles.alibaba_screenshot"></div>
                            </template>
                        </div>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Twitter Follow Screenshot *</label>
                                <input type="file" class="form-control" @change="handleFileUpload($event, 'twitter_follow_screenshot')" 
                                    accept="image/*">
                                <small class="text-muted">Screenshot follow @codepolitan & @alibaba_cloud</small>
                            </div>
                            <template x-if="errors.twitter_follow_screenshot">
                                <small class="text-danger" x-text="errors.twitter_follow_screenshot"></small>
                            </template>
                            <template x-if="files.twitter_follow_screenshot">
                                <div class="badge bg-success mt-1" x-text="files.twitter_follow_screenshot.name"></div>
                            </template>
                            <template x-if="!files.twitter_follow_screenshot && existingFiles.twitter_follow_screenshot">
                                <div class="badge bg-info mt-1" x-text="existingFiles.twitter_follow_screenshot"></div>
                            </template>
                        </div>

                        <template x-if="errors.files">
                            <div class="alert alert-danger" x-text="errors.files"></div>
                        </template>

                        <!-- Nothing to navigate between - single page -->
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">

                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" x-model="form.ethical_statement_agreed" id="ethicalCheck">
                            <label class="form-check-label" for="ethicalCheck">
                                Saya menyatakan bahwa karya ini adalah hasil saya sendiri, tidak melanggar hak cipta pihak ketiga, 
                                dan memberi izin kepada RuangAI/Codepolitan untuk menampilkan karya ini untuk keperluan promosi. *
                            </label>
                        </div>

                        <template x-if="errors.ethical_statement_agreed">
                            <small class="text-danger" x-text="errors.ethical_statement_agreed"></small>
                        </template>

                        <template x-if="errors.general">
                            <div class="alert alert-danger" x-text="errors.general"></div>
                        </template>

                        <div class="row mt-5">
                            <div class="col-12">
                                <button type="button" class="btn btn-success btn-block" @click="submitForm()" 
                                    :disabled="isSubmitting">
                                    <span x-show="!isSubmitting" x-text="isEdit ? 'Update Submission' : 'Submit'"></span>
                                    <span x-show="isSubmitting">Submitting...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<script>
function challengeSubmit() {
    return {
        data:{
            module: 'challenge',
        },

        // Single-page form (not step-based)
        isEdit: false,
        submissionId: null,
        isSubmitting: false,
        alert: {
            show: false,
            type: 'success',
            message: ''
        },
        form: {
            twitter_post_url: '',
            video_title: '',
            video_description: '',
            ethical_statement_agreed: false
        },
        teamMembers: [
            {
                name: '',
                email: '',
                role: 'leader'
            }
        ],
        files: {
            prompt_file: null,
            // params_file: null,
            assets_list_file: null,
            alibaba_screenshot: null,
            twitter_follow_screenshot: null
        },
        existingFiles: {
            prompt_file: null,
            // params_file: null,
            assets_list_file: null,
            alibaba_screenshot: null,
            twitter_follow_screenshot: null
        },
        errors: {},
        config: {},

        async init() {
            try {
                const response = await $heroicHelper.fetch('challenge/submit/data');
                const result = response.data;
                
                if (result.success === 0) {
                    this.showAlert('error', result.message);
                    setTimeout(() => {
                        window.location.href = '/challenge';
                    }, 3000);
                    return;
                }

                this.config = result.config;
                
                // Pre-fill first team member with user data
                if (result.user) {
                    this.teamMembers[0].name = result.user.name;
                    this.teamMembers[0].email = result.user.email;
                }

                // Pre-fill existing submission if present and editable
                if (result.existing_submission && result.can_edit) {
                    this.isEdit = true;
                    this.submissionId = result.existing_submission.id;
                    this.form.twitter_post_url = result.existing_submission.twitter_post_url || '';
                    this.form.video_title = result.existing_submission.video_title || '';
                    this.form.video_description = result.existing_submission.video_description || '';
                    this.form.ethical_statement_agreed = result.existing_submission.ethical_statement_agreed == 1 ? true : false;

                    // team members
                    try {
                        const members = JSON.parse(result.existing_submission.team_members || '[]');
                        if (Array.isArray(members) && members.length) {
                            this.teamMembers = members;
                        }
                    } catch (e) {
                        this.teamMembers = [{ name: '', email: '', role: 'leader' }];
                    }

                    // existing files (display only until replaced)
                    this.existingFiles.prompt_file = result.existing_submission.prompt_file || null;
                    // // this.existingFiles.params_file = result.existing_submission.params_file || null;
                    this.existingFiles.assets_list_file = result.existing_submission.assets_list_file || null;
                    this.existingFiles.alibaba_screenshot = result.existing_submission.alibaba_screenshot || null;
                    this.existingFiles.twitter_follow_screenshot = result.existing_submission.twitter_follow_screenshot || null;
                } else if (result.existing_submission && !result.can_edit) {
                    // User has an existing non-editable submission, show a message and redirect
                    this.showAlert('error', 'Anda sudah memiliki submission aktif dan tidak dapat diubah.');
                    setTimeout(() => { window.location.href = '/challenge'; }, 2500);
                    return;
                }
            } catch (error) {
                this.showAlert('error', 'Gagal memuat data. Silakan refresh halaman.');
            }
        },

        addMember() {
            if (this.teamMembers.length < 3) {
                this.teamMembers.push({
                    name: '',
                    email: '',
                    role: 'member'
                });
            }
        },

        removeMember(index) {
            if (index > 0) {
                this.teamMembers.splice(index, 1);
            }
        },

        handleFileUpload(event, fieldName) {
            const file = event.target.files[0];
            if (file) {
                this.files[fieldName] = file;
                // If replacing existing file, clear its name so valiation relies on this.files
                if (this.existingFiles[fieldName]) {
                    this.existingFiles[fieldName] = null;
                }
            }
        },

        validateForm() {
            this.errors = {};

            // Validate basic fields
            if (!this.form.twitter_post_url) {
                this.errors.twitter_post_url = 'URL Twitter wajib diisi';
            }
            if (!this.form.video_title || this.form.video_title.length < 5) {
                this.errors.video_title = 'Judul video minimal 5 karakter';
            }
            if (!this.form.video_description || this.form.video_description.length < 10) {
                this.errors.video_description = 'Deskripsi minimal 10 karakter';
            }

            // Validate team members
            for (let member of this.teamMembers) {
                if (!member.name || !member.email) {
                    this.errors.team_members = 'Semua anggota tim harus memiliki nama dan email';
                    break;
                }
            }

            // Validate files - either new file is uploaded or existing file present (for edit)
            if (!this.files.prompt_file && !this.existingFiles.prompt_file) {
                this.errors.prompt_file = 'Prompt file wajib diupload';
            }
            // if (!this.files.params_file && !this.existingFiles.params_file) {
                // this.errors.params_file = 'Params file wajib diupload';
            // }
            if (!this.files.alibaba_screenshot && !this.existingFiles.alibaba_screenshot) {
                this.errors.alibaba_screenshot = 'Screenshot Alibaba wajib diupload';
            }
            if (!this.files.twitter_follow_screenshot && !this.existingFiles.twitter_follow_screenshot) {
                this.errors.twitter_follow_screenshot = 'Screenshot follow Twitter wajib diupload';
            }

            if (!this.form.ethical_statement_agreed) {
                this.errors.ethical_statement_agreed = 'Anda harus menyetujui pernyataan etika';
            }

            return Object.keys(this.errors).length === 0;
        },

        // No step flow in single-page form
        nextStep() {},
        prevStep() {},

        async submitForm() {
            if (!this.validateForm()) {
                return;
            }

            this.isSubmitting = true;
            this.errors = {};

            // Prepare data object for $heroicHelper.post
            const data = {
                twitter_post_url: this.form.twitter_post_url,
                video_title: this.form.video_title,
                video_description: this.form.video_description,
                team_members: JSON.stringify(this.teamMembers),
                ethical_statement_agreed: this.form.ethical_statement_agreed ? '1' : '0'
            };

            if (this.isEdit && this.submissionId) {
                data.submission_id = this.submissionId;
            }

            // Add files to data object
            for (let key in this.files) {
                if (this.files[key]) {
                    data[key] = this.files[key];
                }
            }

            try {
                const response = await $heroicHelper.post(base_url + 'challenge/submit/postSubmit', data);
                const result = response.data;

                if (result.success === 1) {
                    this.showAlert('success', result.message);
                    setTimeout(() => {
                        window.location.href = '/challenge';
                    }, 2000);
                } else {
                    this.errors = result.errors || {};
                    if (result.errors && result.errors.general) {
                        this.showAlert('error', result.errors.general);
                    }
                    // go back to top to show errors (single-section form)
                }
            } catch (error) {
                this.showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        },

        showAlert(type, message) {
            this.alert = {
                show: true,
                type: type,
                message: message
            };

            setTimeout(() => {
                this.alert.show = false;
            }, 5000);
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
