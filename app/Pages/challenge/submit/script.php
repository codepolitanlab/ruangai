<script>
function countdown() {
    return {
        days: '00',
        hours: '00',
        minutes: '00',
        seconds: '00',
        
        init() {
            this.updateCountdown();
            setInterval(() => {
                this.updateCountdown();
            }, 1000);
        },
        
        updateCountdown() {
            // Target date: February 8, 2026 23:59:59 WIB (UTC+7)
            const targetDate = new Date('2026-02-08T23:59:59+07:00').getTime();
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            if (distance < 0) {
                this.days = '00';
                this.hours = '00';
                this.minutes = '00';
                this.seconds = '00';
                return;
            }
            
            this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }
    };
}

function challengeSubmit() {
    return {
        data:{
            module: 'challenge',
        },

        // Single-page form (not step-based)
        isEdit: false,
        submissionId: null,
        isSubmitting: false,
        isSavingProfile: false,
        redirecting: false,
        alert: {
            show: false,
            type: 'success',
            message: ''
        },
        form: {
            twitter_post_url: '',
            video_title: '',
            video_description: '',
            other_tools: '',
            ethical_statement_agreed: false,
            is_followed_account_codepolitan: false,
            is_followed_account_alibaba: false
        },
        profile: {
            name: '',
            email: '',
            alibaba_cloud_id: '',
            alibaba_cloud_screenshot: null,
            occupation: '',
            institution: '',
            whatsapp: '',
            gender: '',
            agreed_terms: false,
            agreed_terms_1: false,
            agreed_terms_2: false,
            agreed_terms_3: false,
            birthday: '',
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
        },
        existingFiles: {
            prompt_file: null,
        },
        errors: {},
        profileErrors: {},
        config: {},

        async init() {
            try {
                const response = await $heroicHelper.fetch('challenge/submit/data');
                const result = response.data;

                // If user's email is not yet verified, block access to submit page
                if (result.user && result.user.email_valid != 1) {
                    // Prevent duplicate alerts/redirects
                    if (this.redirecting) return;
                    this.redirecting = true;

                    // Use native alert then redirect
                    alert('Silakan verifikasi email Anda terlebih dahulu.');
                    window.location.href = '/challenge';
                    return;
                }

                this.config = result.config;
                
                // Pre-fill first team member with user data
                if (result.user) {
                    const u = result.user || {};

                    this.profile.name = u.name || '';
                    this.profile.email = u.email || '';

                    // fill profile from getData fields only
                    this.profile.alibaba_cloud_id = u.alibaba_cloud_id || '';
                    this.profile.alibaba_cloud_screenshot = u.alibaba_cloud_screenshot || null;
                    this.profile.occupation = u.occupation || '';
                    this.profile.institution = u.institution || '';
                    this.profile.whatsapp = u.phone || '';
                    this.profile.gender = u.gender || '';
                    this.profile.birthday = u.birthday || '';
                    this.profile.x_profile_url = u.x_profile_url || '';
                }

                // Pre-fill existing submission if present and editable
                if (result.existing_submission && result.can_edit) {
                    this.isEdit = true;
                    this.submissionId = result.existing_submission.id;
                    this.form.twitter_post_url = result.existing_submission.twitter_post_url || '';
                    this.form.video_title = result.existing_submission.video_title || '';
                    this.form.video_description = result.existing_submission.video_description || '';
                    this.form.other_tools = result.existing_submission.other_tools || '';
                    this.form.ethical_statement_agreed = result.existing_submission.ethical_statement_agreed == 1 ? true : false;
                    this.form.is_followed_account_codepolitan = result.existing_submission.is_followed_account_codepolitan == 1 ? true : false;
                    this.form.is_followed_account_alibaba = result.existing_submission.is_followed_account_alibaba == 1 ? true : false;
                    // Map ethical_statement_agreed to checkboxes
                    if (result.existing_submission.ethical_statement_agreed == 1) {
                        this.profile.agreed_terms_1 = true;
                        this.profile.agreed_terms_2 = true;
                        this.profile.agreed_terms_3 = true;
                    }

                    // existing files (display only until replaced)
                    this.existingFiles.prompt_file = result.existing_submission.prompt_file || null;
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

        handleFileUpload(event, fieldName) {
            const file = event.target.files[0];
            if (file) {
                // Validate file size (max 1MB)
                const maxSize = 1 * 1024 * 1024; // 1MB in bytes
                if (file.size > maxSize) {
                    this.errors[fieldName] = 'Ukuran file maksimal 1MB';
                    event.target.value = ''; // Clear input
                    $heroicHelper.toastr('Ukuran file maksimal 1MB', 'danger', 'bottom');
                    return;
                }
                
                this.files[fieldName] = file;
                // Clear error if any
                delete this.errors[fieldName];
                // If replacing existing file, clear its name so valiation relies on this.files
                if (this.existingFiles[fieldName]) {
                    this.existingFiles[fieldName] = null;
                }
            }
        },

        handleProfileScreenshot(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file type (only images)
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    this.profileErrors.alibaba_cloud_screenshot = 'File harus berupa gambar (JPG, PNG, GIF, WEBP)';
                    event.target.value = ''; // Clear input
                    $heroicHelper.toastr('File harus berupa gambar (JPG, PNG, GIF, WEBP)', 'danger', 'bottom');
                    return;
                }
                
                // Validate file size (max 1MB)
                const maxSize = 1 * 1024 * 1024; // 1MB in bytes
                if (file.size > maxSize) {
                    this.profileErrors.alibaba_cloud_screenshot = 'Ukuran file maksimal 1MB';
                    event.target.value = ''; // Clear input
                    $heroicHelper.toastr('Ukuran file maksimal 1MB', 'danger', 'bottom');
                    return;
                }
                
                // show filename, actual upload happens on submitProfile
                this.profile.alibaba_cloud_screenshot = file.name;
                this.profile._screenshot_file = file;
                // Clear error if any
                delete this.profileErrors.alibaba_cloud_screenshot;
            }
        },

        resetProfile() {
            // revert profile to initial user data
            if (this.config && this.config.userDefaults) {
                Object.assign(this.profile, this.config.userDefaults);
            } else {
                this.profile = { name: '', email: '', alibaba_cloud_id: '', alibaba_cloud_screenshot: null, occupation: '', institution: '' };
            }
        },

        isProfileComplete() {
            return (
                this.profile.whatsapp && this.profile.whatsapp.trim() !== '' &&
                this.profile.birthday && this.profile.birthday.trim() !== '' &&
                this.profile.gender && this.profile.gender !== '' &&
                this.profile.occupation && this.profile.occupation.trim() !== '' &&
                this.profile.institution && this.profile.institution.trim() !== '' &&
                this.profile.x_profile_url && this.profile.x_profile_url.trim() !== '' &&
                this.profile.alibaba_cloud_id && this.profile.alibaba_cloud_id.trim() !== '' &&
                (this.profile.alibaba_cloud_screenshot || this.profile._screenshot_file)
            );
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
            }

            // Validasi Tanggal Lahir
            if (!this.profile.birthday || this.profile.birthday.trim() === '') {
                this.profileErrors.birthday = 'Tanggal lahir wajib diisi';
            } else {
                const birthDate = new Date(this.profile.birthday);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 17) {
                    this.profileErrors.birthday = 'Usia minimal 17 tahun';
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
            if (!this.profile.occupation || this.profile.occupation.trim() === '') {
                this.profileErrors.occupation = 'Profesi wajib diisi';
            }

            // Validasi Job Title
            // if (!this.profile.job_title || this.profile.job_title.trim() === '') {
            //     this.profileErrors.job_title = 'Pekerjaan/Job Title wajib diisi';
            // }

            // Validasi Company
            if (!this.profile.institution || this.profile.institution.trim() === '') {
                this.profileErrors.institution = 'Instansi/Perusahaan wajib diisi';
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
            if (!this.profile.alibaba_cloud_id || this.profile.alibaba_cloud_id.trim() === '') {
                this.profileErrors.alibaba_cloud_id = 'AlibabaCloud ID wajib diisi';
            } else if (!/^\d+$/.test(this.profile.alibaba_cloud_id)) {
                this.profileErrors.alibaba_cloud_id = 'AlibabaCloud ID harus berupa angka';
            } else if (this.profile.alibaba_cloud_id.length < 15) {
                this.profileErrors.alibaba_cloud_id = 'AlibabaCloud ID minimal 15 karakter';
            }

            // Validasi Screenshot
            if (!this.profile.alibaba_cloud_screenshot && !this.profile._screenshot_file) {
                this.profileErrors.alibaba_cloud_screenshot = 'Screenshot Alibaba Account wajib diupload';
            }

            return Object.keys(this.profileErrors).length === 0;
        },

        async saveProfile() {
            // Clear previous errors
            this.profileErrors = {};

            // Validate form
            if (!this.validateProfileForm()) {
                const errorMessages = Object.values(this.profileErrors).join(', ');
                $heroicHelper.toastr(errorMessages || 'Mohon periksa kembali form yang diisi', 'danger', 'bottom');
                const firstErrorField = Object.keys(this.profileErrors)[0];
                if (firstErrorField) {
                    const el = document.querySelector(`[x-model="profile.${firstErrorField}"]`) || document.querySelector(`[name="${firstErrorField}"]`);
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            this.isSavingProfile = true;

            const data = {
                name: this.profile.name,
                email: this.profile.email,
                whatsapp: this.profile.whatsapp,
                gender: this.profile.gender,
                occupation: this.profile.occupation,
                institution: this.profile.institution,
                alibaba_cloud_id: this.profile.alibaba_cloud_id,
                birthday: this.profile.birthday,
                x_profile_url: this.profile.x_profile_url,
            };

            // include screenshot file if present
            if (this.profile._screenshot_file) {
                data.alibaba_cloud_screenshot = this.profile._screenshot_file;
            }

            try {
                const res = await $heroicHelper.post(base_url + 'challenge/submit/saveProfile', data);
                if (res.data && res.data.success) {
                    this.profileErrors = {};
                    $heroicHelper.toastr('Data profil berhasil disimpan', 'success', 'bottom');
                    // optionally refresh defaults
                } else {
                    // Handle server-side validation errors
                    if (res.data && res.data.errors) {
                        this.profileErrors = res.data.errors;
                        const errorMessages = Object.values(res.data.errors).join(', ');
                        $heroicHelper.toastr(errorMessages, 'danger', 'bottom');
                    } else {
                        $heroicHelper.toastr((res.data && res.data.message) || 'Gagal menyimpan profil', 'danger', 'bottom');
                    }
                }
            } catch (e) {
                $heroicHelper.toastr('Gagal menyimpan profil: ' + e.message, 'danger', 'bottom');
            } finally {
                this.isSavingProfile = false;
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

            // Validate files - either new file is uploaded or existing file present (for edit)
            if (!this.files.prompt_file && !this.existingFiles.prompt_file) {
                this.errors.prompt_file = 'Prompt file wajib diupload';
            }

            // Validate follow accounts
            if (!this.form.is_followed_account_codepolitan) {
                this.errors.is_followed_account_codepolitan = 'Anda harus mengikuti akun @codepolitan';
            }
            if (!this.form.is_followed_account_alibaba) {
                this.errors.is_followed_account_alibaba = 'Anda harus mengikuti akun @alibaba_cloud';
            }

            // Validate agreed terms
            if (!this.profile.agreed_terms_1) {
                this.errors.agreed_terms_1 = 'Anda harus menyetujui pernyataan ini';
            }
            if (!this.profile.agreed_terms_2) {
                this.errors.agreed_terms_2 = 'Anda harus menyetujui pernyataan ini';
            }
            if (!this.profile.agreed_terms_3) {
                this.errors.agreed_terms_3 = 'Anda harus menyetujui pernyataan ini';
            }

            return Object.keys(this.errors).length === 0;
        },

        // No step flow in single-page form
        nextStep() {},
        prevStep() {},

        async submitForm() {
            // Check if profile is complete first
            if (!this.isProfileComplete()) {
                $heroicHelper.toastr('Harap lengkapi profil Anda terlebih dahulu sebelum submit challenge', 'warning', 'bottom');
                // Scroll to profile accordion
                const profileAccordion = document.querySelector('#collapseProfile');
                if (profileAccordion) {
                    profileAccordion.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Open the profile accordion if closed
                    if (!profileAccordion.classList.contains('show')) {
                        const profileButton = document.querySelector('[data-bs-target="#collapseProfile"]');
                        if (profileButton) profileButton.click();
                    }
                }
                return;
            }

            if (!this.validateForm()) {
                const errorMessages = Object.values(this.errors).join(', ');
                $heroicHelper.toastr(errorMessages || 'Mohon periksa kembali form yang diisi', 'danger', 'bottom');
                const firstErrorField = Object.keys(this.errors)[0];
                if (firstErrorField) {
                    const el = document.querySelector(`[name="${firstErrorField}"]`) || document.querySelector(`[x-model="form.${firstErrorField}"]`) || document.querySelector(`[x-model="profile.${firstErrorField}"]`);
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            this.isSubmitting = true;
            this.errors = {};

            // Prepare data object for $heroicHelper.post
            const data = {
                twitter_post_url: this.form.twitter_post_url,
                video_title: this.form.video_title,
                video_description: this.form.video_description,
                ethical_statement_agreed: (this.profile.agreed_terms_1 && this.profile.agreed_terms_2 && this.profile.agreed_terms_3) ? '1' : '0',
                is_followed_account_codepolitan: this.form.is_followed_account_codepolitan ? '1' : '0',
                is_followed_account_alibaba: this.form.is_followed_account_alibaba ? '1' : '0'
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
                    $heroicHelper.toastr(result.message, 'success', 'bottom');
                    setTimeout(() => {
                        window.location.href = '/challenge';
                    }, 2000);
                } else {
                    this.errors = result.errors || {};
                    if (result.errors && result.errors.general) {
                        $heroicHelper.toastr(result.errors.general, 'danger', 'bottom');
                    } else if (result.message) {
                        $heroicHelper.toastr(result.message, 'danger', 'bottom');
                    }
                    // go back to top to show errors (single-section form)
                }
            } catch (error) {
                $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
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
