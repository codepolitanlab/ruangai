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
            // Target date: March 13, 2026 23:59:59 WIB (UTC+7)
            const targetDate = new Date('2026-03-13T23:59:59+07:00').getTime();
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

        // Stepper wizard state
        currentStep: 1,
        hasSubmission: false,
        submissionStatus: null,
        submissionNotes: null,
        canEditSubmission: false,
        isEdit: false,
        submissionId: null,
        isSubmitting: false,
        isSavingProfile: false,
        redirecting: false,
        emailNotVerified: false,
        alert: {
            show: false,
            type: 'success',
            message: ''
        },
        form: {
            twitter_post_url: '',
            video_title: '',
            video_category: '',
            video_description: '',
            other_tools: '',
            ethical_statement_agreed: false,
            is_followed_accounts: false
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
        errors: {},
        profileErrors: {},
        savedProfile: {},
        config: {},
        modalTnc: {
            is_followed_accounts: false,
            agreed_terms_1: false,
            agreed_terms_2: false,
            agreed_terms_3: false
        },

        async init() {
            try {
                const response = await $heroicHelper.fetch('challenge/submit/data');
                const result = response.data;

                // If user's email is not yet verified, show warning but don't redirect
                if (result.user && result.user.email_valid != 1) {
                    this.emailNotVerified = true;
                    // Continue loading data but forms will be disabled
                } else {
                    this.emailNotVerified = false;
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

                    // Snapshot of saved values (used to determine which fields to show)
                    this.savedProfile = {
                        birthday: this.profile.birthday,
                        gender: this.profile.gender,
                        occupation: this.profile.occupation,
                        institution: this.profile.institution,
                        x_profile_url: this.profile.x_profile_url,
                    };
                }

                this.hasSubmission = !!result.existing_submission;
                this.submissionStatus = result.existing_submission?.status || null;
                this.submissionNotes = result.existing_submission?.notes || result.existing_submission?.admin_notes || null;
                this.canEditSubmission = result.can_edit === true;

                // Pre-fill existing submission if present
                if (result.existing_submission) {
                    this.submissionId = result.existing_submission.id;
                    this.form.twitter_post_url = result.existing_submission.twitter_post_url || '';
                    this.form.video_title = result.existing_submission.video_title || '';
                    this.form.video_category = result.existing_submission.video_category || '';
                    this.form.video_description = result.existing_submission.video_description || '';
                    this.form.other_tools = result.existing_submission.other_tools || '';
                    if (this.form.other_tools) {
                        // If stored as "Lainnya: ...", keep only the 'other' text for the free-text field
                        const toolsText = this.form.other_tools;
                        if (toolsText.includes('Lainnya:')) {
                            this.form.other_tools = toolsText.split('Lainnya:').pop().trim();
                        }
                    }
                    this.form.ethical_statement_agreed = result.existing_submission.ethical_statement_agreed == 1 ? true : false;
                    // combined follow checkbox — prefill true only when user previously followed both accounts
                    this.form.is_followed_accounts = (result.existing_submission.is_followed_account_codepolitan == 1 && result.existing_submission.is_followed_account_alibaba == 1) ? true : false;

                    if (result.can_edit) {
                        this.isEdit = true;
                    }

                    if (result.existing_submission.ethical_statement_agreed == 1) {
                        this.profile.agreed_terms_1 = true;
                        this.profile.agreed_terms_2 = true;
                        this.profile.agreed_terms_3 = true;
                    }

                    // legacy prompt file values are ignored but kept server-side
                }

                this.setInitialStep();
            } catch (error) {
                this.showAlert('error', 'Gagal memuat data. Silakan refresh halaman.');
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

        setInitialStep() {
            // If email not verified, always start at step 1
            if (this.emailNotVerified) {
                this.currentStep = 1;
                return;
            }

            if (!this.isProfileComplete()) {
                this.currentStep = 1;
                return;
            }

            if (!this.hasSubmission) {
                this.currentStep = 2;
                return;
            }
            if (!this.submissionStatus || this.submissionStatus === 'pending') {
                this.currentStep = 1;
                return;
            }

            this.currentStep = 3;
        },

        normalizedStatus() {
            if (!this.submissionStatus || this.submissionStatus === 'pending' || this.submissionStatus === 'validated') {
                return 'review';
            }

            return this.submissionStatus;
        },

        statusLabel() {
            const status = this.normalizedStatus();
            const labels = {
                pending: 'Pending',
                review: 'Review',
                approved: 'Approved',
                rejected: 'Rejected'
            };

            return labels[status] || 'Pending';
        },

        statusClass() {
            const status = this.normalizedStatus();
            return `status-${status}`;
        },

        stepClass(step) {
            if (this.currentStep === step) return 'active';
            if (step < this.currentStep) return 'completed';
            if (this.isStepLocked(step)) return 'locked';
            return '';
        },

        isStepLocked(step) {
            if (step === 1) return false; // Step 1 always accessible but form disabled if email not verified
            
            // Lock all steps (2 and 3) if email not verified
            if (this.emailNotVerified) return true;
            
            if (!this.isProfileComplete()) return true;
            if (step === 3 && !this.hasSubmission) return true;
            return false;
        },

        goToStep(step) {
            if (this.isStepLocked(step)) {
                $heroicHelper.toastr('Lengkapi data diri terlebih dahulu sebelum lanjut.', 'warning', 'bottom');
                return;
            }

            this.currentStep = step;
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
                    this.setInitialStep();
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
            if (!this.form.video_category) {
                this.errors.video_category = 'Kategori video wajib dipilih';
            }
            if (!this.form.video_description || this.form.video_description.length < 10) {
                this.errors.video_description = 'Prompt minimal 10 karakter';
            }



            // Validate follow accounts (single combined checkbox)
            if (!this.form.is_followed_accounts) {
                this.errors.is_followed_accounts = 'Anda harus mengikuti akun @alibaba_cloud dan @codepolitan';
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

            if (this.hasSubmission && !this.canEditSubmission) {
                $heroicHelper.toastr('Submission Anda sudah final dan tidak dapat diubah.', 'warning', 'bottom');
                this.currentStep = 3;
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

            // Close modal if open
            const modal = bootstrap.Modal.getInstance(document.getElementById('tncModal'));
            if (modal) {
                modal.hide();
            }

            this.isSubmitting = true;
            this.errors = {};

            // Prepare data object for $heroicHelper.post
            const data = {
                twitter_post_url: this.form.twitter_post_url,
                video_title: this.form.video_title,
                video_category: this.form.video_category,
                video_description: this.form.video_description,
                other_tools: '',
                ethical_statement_agreed: (this.modalTnc.agreed_terms_1 && this.modalTnc.agreed_terms_2 && this.modalTnc.agreed_terms_3) ? '1' : '0',
                is_followed_account_codepolitan: this.modalTnc.is_followed_accounts ? '1' : '0',
                is_followed_account_alibaba: this.modalTnc.is_followed_accounts ? '1' : '0'
            };

            if (this.form.other_tools && this.form.other_tools.trim() !== '') {
                data.other_tools = this.form.other_tools.trim();
            }

            if (this.isEdit && this.submissionId) {
                data.submission_id = this.submissionId;
            }

            try {
                const response = await $heroicHelper.post(base_url + 'challenge/submit/postSubmit', data);
                const result = response.data;

                if (result.success === 1) {
                    $heroicHelper.toastr(result.message, 'success', 'bottom');
                    this.submissionId = result.submission_id || this.submissionId;
                    this.hasSubmission = true;
                    this.submissionStatus = result.status || 'review';
                    this.canEditSubmission = true;
                    this.isEdit = true;
                    this.currentStep = 3;
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
        },

        showTncModal() {
            // Check if profile is complete first
            if (!this.isProfileComplete()) {
                $heroicHelper.toastr('Harap lengkapi profil Anda terlebih dahulu sebelum submit challenge', 'warning', 'bottom');
                return;
            }

            if (this.hasSubmission && !this.canEditSubmission) {
                $heroicHelper.toastr('Submission Anda sudah final dan tidak dapat diubah.', 'warning', 'bottom');
                return;
            }

            // Validate form before showing modal
            this.errors = {};

            // Validate basic fields
            if (!this.form.twitter_post_url) {
                this.errors.twitter_post_url = 'URL Twitter wajib diisi';
            }
            if (!this.form.video_title || this.form.video_title.length < 5) {
                this.errors.video_title = 'Judul video minimal 5 karakter';
            }
            if (!this.form.video_category) {
                this.errors.video_category = 'Kategori video wajib dipilih';
            }
            if (!this.form.video_description || this.form.video_description.length < 10) {
                this.errors.video_description = 'Prompt minimal 10 karakter';
            }

            // If there are validation errors, show them and don't open modal
            if (Object.keys(this.errors).length > 0) {
                const errorMessages = Object.values(this.errors).join(', ');
                $heroicHelper.toastr(errorMessages || 'Mohon periksa kembali form yang diisi', 'danger', 'bottom');
                const firstErrorField = Object.keys(this.errors)[0];
                if (firstErrorField) {
                    const el = document.querySelector(`[x-model="form.${firstErrorField}"]`);
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            // Pre-fill modal checkboxes with current form values
            this.modalTnc.is_followed_accounts = this.form.is_followed_accounts;
            this.modalTnc.agreed_terms_1 = this.profile.agreed_terms_1;
            this.modalTnc.agreed_terms_2 = this.profile.agreed_terms_2;
            this.modalTnc.agreed_terms_3 = this.profile.agreed_terms_3;

            // Show the modal
            const modalElement = document.getElementById('tncModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        },

        allTncChecked() {
            return this.modalTnc.is_followed_accounts && 
                   this.modalTnc.agreed_terms_1 && 
                   this.modalTnc.agreed_terms_2 && 
                   this.modalTnc.agreed_terms_3;
        },

        confirmAndSubmit() {
            if (!this.allTncChecked()) {
                $heroicHelper.toastr('Harap centang semua persyaratan', 'warning', 'bottom');
                return;
            }

            // Update form values with modal values
            this.form.is_followed_accounts = this.modalTnc.is_followed_accounts;
            this.profile.agreed_terms_1 = this.modalTnc.agreed_terms_1;
            this.profile.agreed_terms_2 = this.modalTnc.agreed_terms_2;
            this.profile.agreed_terms_3 = this.modalTnc.agreed_terms_3;

            // Call the actual submit function
            this.submitForm();
        }
    }
}
</script>
