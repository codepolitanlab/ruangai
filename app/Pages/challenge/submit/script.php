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
        profile: {
            name: '',
            email: '',
            alibabacloud_id: '',
            alibabacloud_screenshot: null,
            profession: '',
            job_title: '',
            company: '',
            whatsapp: '',
            address: '',
            gender: '',
            industry: '',
            referral_code: '',
            agreed_terms: false,
            birth_date: '',
            x_profile_url: '',
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
        profileErrors: {},
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
                    this.profile.name = result.user.name || '';
                    this.profile.email = result.user.email || '';

                    this.teamMembers[0].name = result.user.name;
                    this.teamMembers[0].email = result.user.email;
                    // fill profile
                    this.profile.name = result.user.name || '';
                    this.profile.email = result.user.email || '';
                    this.profile.alibabacloud_id = result.user.alibabacloud_id || '';
                    this.profile.alibabacloud_screenshot = result.user.alibabacloud_screenshot || null;
                    this.profile.profession = result.user.profession || '';
                    this.profile.job_title = result.user.job_title || '';
                    this.profile.company = result.user.company || '';
                    this.profile.whatsapp = result.user.whatsapp || '';
                    this.profile.address = result.user.address || '';
                    this.profile.gender = result.user.gender || '';
                    this.profile.industry = result.user.industry || '';
                    this.profile.referral_code = result.user.referral_code || '';
                    this.profile.agreed_terms = result.user.agreed_terms == 1 ? true : false;
                    this.profile.birth_date = result.user.birth_date || '';
                    this.profile.x_profile_url = result.user.x_profile_url || '';
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

        handleProfileScreenshot(event) {
            const file = event.target.files[0];
            if (file) {
                // show filename, actual upload happens on submitProfile
                this.profile.alibabacloud_screenshot = file.name;
                this.profile._screenshot_file = file;
            }
        },

        resetProfile() {
            // revert profile to initial user data
            if (this.config && this.config.userDefaults) {
                Object.assign(this.profile, this.config.userDefaults);
            } else {
                this.profile = { name: '', email: '', alibabacloud_id: '', alibabacloud_screenshot: null, profession: '', job_title: '', company: '' };
            }
        },

        validateProfileForm() {
            this.profileErrors = {};

            // Validasi Nama
            // if (!this.profile.name || this.profile.name.trim() === '') {
            //     this.profileErrors.name = 'Nama wajib diisi';
            // } else if (this.profile.name.length < 3) {
            //     this.profileErrors.name = 'Nama minimal 3 karakter';
            // }

            // Validasi Email
            // if (!this.profile.email || this.profile.email.trim() === '') {
            //     this.profileErrors.email = 'Email wajib diisi';
            // } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.profile.email)) {
            //     this.profileErrors.email = 'Format email tidak valid';
            // }

            // Validasi WhatsApp
            if (!this.profile.whatsapp || this.profile.whatsapp.trim() === '') {
                this.profileErrors.whatsapp = 'WhatsApp wajib diisi';
            } else if (!/^62\d{9,13}$/.test(this.profile.whatsapp)) {
                this.profileErrors.whatsapp = 'Format WhatsApp: 62812xxxx (9-13 digit)';
            }

            // Validasi Tanggal Lahir
            if (!this.profile.birth_date || this.profile.birth_date.trim() === '') {
                this.profileErrors.birth_date = 'Tanggal lahir wajib diisi';
            } else {
                const birthDate = new Date(this.profile.birth_date);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 17) {
                    this.profileErrors.birth_date = 'Usia minimal 17 tahun';
                }
            }

            // Validasi Alamat
            // if (!this.profile.address || this.profile.address.trim() === '') {
            //     this.profileErrors.address = 'Alamat wajib diisi';
            // } else if (this.profile.address.length < 10) {
            //     this.profileErrors.address = 'Alamat minimal 10 karakter';
            // }

            // Validasi Jenis Kelamin
            if (!this.profile.gender || this.profile.gender === '') {
                this.profileErrors.gender = 'Jenis kelamin wajib dipilih';
            }

            // Validasi Profesi
            if (!this.profile.profession || this.profile.profession.trim() === '') {
                this.profileErrors.profession = 'Profesi wajib diisi';
            }

            // Validasi Job Title
            // if (!this.profile.job_title || this.profile.job_title.trim() === '') {
            //     this.profileErrors.job_title = 'Pekerjaan/Job Title wajib diisi';
            // }

            // Validasi Company
            if (!this.profile.company || this.profile.company.trim() === '') {
                this.profileErrors.company = 'Instansi/Perusahaan wajib diisi';
            }

            // Validasi Industry
            // if (!this.profile.industry || this.profile.industry.trim() === '') {
            //     this.profileErrors.industry = 'Industri wajib diisi';
            // }

            // Validasi Link Profil X
            if (!this.profile.x_profile_url || this.profile.x_profile_url.trim() === '') {
                this.profileErrors.x_profile_url = 'Link Profil X wajib diisi';
            } else if (!/^https:\/\/(www\.)?(x\.com|twitter\.com)\/.+/.test(this.profile.x_profile_url)) {
                this.profileErrors.x_profile_url = 'Format link harus: https://x.com/username';
            }

            // Validasi AlibabaCloud ID
            if (!this.profile.alibabacloud_id || this.profile.alibabacloud_id.trim() === '') {
                this.profileErrors.alibabacloud_id = 'AlibabaCloud ID wajib diisi';
            }

            // Validasi Screenshot
            if (!this.profile.alibabacloud_screenshot && !this.profile._screenshot_file) {
                this.profileErrors.alibabacloud_screenshot = 'Screenshot Alibaba Account wajib diupload';
            }

            // Validasi Agreed Terms
            if (!this.profile.agreed_terms) {
                this.profileErrors.agreed_terms = 'Anda harus menyetujui syarat dan ketentuan';
            }

            return Object.keys(this.profileErrors).length === 0;
        },

        async saveProfile() {
            // Clear previous errors
            this.profileErrors = {};

            // Validate form
            if (!this.validateProfileForm()) {
                this.showAlert('error', 'Mohon lengkapi semua field yang wajib diisi dengan benar');
                return;
            }

            const data = {
                name: this.profile.name,
                email: this.profile.email,
                whatsapp: this.profile.whatsapp,
                address: this.profile.address,
                gender: this.profile.gender,
                profession: this.profile.profession,
                job_title: this.profile.job_title,
                company: this.profile.company,
                industry: this.profile.industry,
                alibabacloud_id: this.profile.alibabacloud_id,
                referral_code: this.profile.referral_code,
                agreed_terms: this.profile.agreed_terms ? '1' : '0',
                birth_date: this.profile.birth_date,
                x_profile_url: this.profile.x_profile_url,
            };

            // include screenshot file if present
            if (this.profile._screenshot_file) {
                data.alibabacloud_screenshot = this.profile._screenshot_file;
            }

            try {
                const res = await $heroicHelper.post(base_url + 'challenge/submit/saveProfile', data);
                if (res.data && res.data.success) {
                    this.profileErrors = {};
                    this.showAlert('success', 'Data profil berhasil disimpan');
                    // optionally refresh defaults
                } else {
                    // Handle server-side validation errors
                    if (res.data && res.data.errors) {
                        this.profileErrors = res.data.errors;
                    }
                    this.showAlert('error', (res.data && res.data.message) || 'Gagal menyimpan profil');
                }
            } catch (e) {
                this.showAlert('error', 'Gagal menyimpan profil');
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
