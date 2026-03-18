<script>
    Alpine.data('reset_password', (recaptchaSiteKey) => ({
        title: "Reset Kata Sandi",
        logo: '',
        model: {
            sendto: 'email',
            email: '',
            phone: '',
        },
        recaptcha: '',
        recaptchaWidget: null,
        error: '',
        sending: false,

        init(){
            document.title = this.title
            Alpine.store('core').currentPage = 'reset_password'

            this.logo = Alpine.store('core').settings.auth_logo

            // Prefill email from query params
            const urlParams = new URLSearchParams(window.location.search);
            const emailParam = urlParams.get('email');
            if (emailParam) {
                this.model.email = emailParam;
            }

            // Call google recaptcha with retry mechanism
            this.initRecaptcha(recaptchaSiteKey);
        },

        initRecaptcha(siteKey) {
            // Check if grecaptcha is available
            if (typeof grecaptcha !== 'undefined' && grecaptcha.render) {
                try {
                    this.recaptchaWidget = grecaptcha.render('grecaptcha', {
                        'sitekey': siteKey
                    });
                } catch (error) {
                    console.error('Failed to render reCAPTCHA:', error);
                    // Retry after a short delay
                    setTimeout(() => this.initRecaptcha(siteKey), 500);
                }
            } else {
                // grecaptcha not loaded yet, retry after a short delay
                setTimeout(() => this.initRecaptcha(siteKey), 100);
            }
        },

        sendTo(to) {
            this.model.sendto = to
        },

        confirm(){
            this.sending = true

            // Check if recaptcha widget is initialized
            if (this.recaptchaWidget === null || typeof grecaptcha === 'undefined') {
                $heroicHelper.toastr('Recaptcha belum siap, mohon tunggu sebentar.', 'warning');
                this.sending = false;
                return;
            }

            // Gain javascript form validation
            if(this.model.sendto == 'phone' && this.model.phone == ''){
                $heroicHelper.toastr('Nomor WhatsApp tidak boleh kosong.', 'warning')
                this.sending = false
                return;
            }
            if(this.model.sendto == 'email' && this.model.email == ''){
                $heroicHelper.toastr('Nomor WhatsApp tidak boleh kosong.', 'warning')
                this.sending = false
                return;
            }

            this.recaptcha = grecaptcha.getResponse(this.recaptchaWidget);
            if(this.recaptcha == '') {
                $heroicHelper.toastr('Ceklis dulu Recaptcha.','warning')
                this.sending = false
                return;
            }

            // Check register_confirm using axios post
            const formData = new FormData();
            $heroicHelper.post('/reset_password', {
                recaptcha: this.recaptcha,
                phone: this.model.phone,
                email: this.model.email,
                sendto: this.model.sendto,
            })
            .then(response => {
                if(response.data.success == 1){
                    let token = response.data.token + '_' + response.data.id + 'X' + Math.random().toString(36).substring(7)
                    window.PineconeRouter.navigate('/reset_password/change/' + token)
                } else {
                    $heroicHelper.toastr(response.data.message, 'danger')
                    grecaptcha.reset(this.recaptchaWidget)
                    this.sending = false
                }
            })
        },

    }))
</script>