<script>
    // Page member/component
    window.member_register = function(recaptchaSiteKey) {
        return {
            title: "Register",
            showPwd: false,
            registering: false,
            recaptcha: '',
            recaptchaWidget: null,
            error: '',

            data: {
                fullname: '',
                email: '',
                password: '',
                repeat_password: '',
                logo: '',
                sitename: '',
            },
            errors: {
                fullname: '',
                email: '',
                password: '',
                repeat_password: '',
            },
            init() {
                document.title = this.title
                Alpine.store('core').currentPage = 'registrasi'
                Alpine.store('core').showBottomMenu = false

                // Call google recaptcha
                this.recaptchaWidget = grecaptcha.render('grecaptcha', {
                    'sitekey': recaptchaSiteKey
                });
                if (this.recaptchaWidget === null)
                    window.location.href = '/registrasi'
            },
            register() {
                this.registering = true;

                this.errors = {
                    fullname: '',
                    email: '',
                    password: '',
                    repeat_password: '',
                };

                this.recaptcha = grecaptcha.getResponse(this.recaptchaWidget);
                if (this.recaptcha == '') {
                    $heroicHelper.toastr('Ceklis dulu Recaptcha.', 'warning')
                    this.registering = false
                    return;
                }

                // Check login using axios post
                const formData = new FormData();
                formData.append('fullname', this.data.fullname ?? '');
                formData.append('email', this.data.email ?? '');
                formData.append('password', this.data.password ?? '');
                formData.append('repeat_password', this.data.repeat_password ?? '');
                formData.append('recaptcha', this.recaptcha ?? '');
                axios.post('/registrasi', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    if (response.data.success == 1) {
                        localStorage.setItem("heroic_token", response.data.jwt);
                        Alpine.store('core').sessionToken = localStorage.getItem("heroic_token");

                        setTimeout(() => {
                            window.location.replace("/");
                        }, 500);
                    } else {
                        this.errors = response.data.errors
                        this.registering = false;
                    }
                })
            }
        }
    }
</script>