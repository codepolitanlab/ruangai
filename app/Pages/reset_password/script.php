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

            // Call google recaptcha
            this.recaptchaWidget = grecaptcha.render('grecaptcha', {
                'sitekey' : recaptchaSiteKey
            });
            if(this.recaptchaWidget === null)
                window.location.href = '/reset_password'
        },

        sendTo(to) {
            this.model.sendto = to
        },

        confirm(){
            this.sending = true

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