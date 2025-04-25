<script>
Alpine.data('register', function(){
    return {
        title: "Register",
        token: '',
        npa: '',
        logo: '',
        sitename: '',
        showPwd: false,
        registering: false,
        data: {
            fullname: '',
            whatsapp: '',
            password: '',
            repeat_password: '',
        },
        errors: {
            fullname: '',
            whatsapp: '',
            password: '',
            repeat_password: '',
        },

        init(){
            document.title = this.title
            Alpine.store('core').currentPage = 'register'
            
            this.logo = Alpine.store('core').settings.auth_logo;
            this.sitename = Alpine.store('core').settings.site_title;

            // Get token from URL
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            if(token){
                this.token = token
                // Get user data based on token
                $heroicHelper.fetch('/aktivasi/register/supply/' + token)
                .then(response => {
                    if(response.found == 0){
                        // Redirect to home if token not found
                        window.PineconeRouter.navigate('/aktivasi')
                    }

                    this.npa = response.data.npa
                    this.data.fullname = response.data.nama_lengkap
                })
            } else {
                // Redirect to home if token not found
                window.PineconeRouter.navigate('/aktivasi')
            }
        },

        register() {
            this.registering = true;

            this.errors = {
                fullname: '',
                whatsapp: '',
                password: '',
                repeat_password: '',
            };

            // Check login using axios post
            const formData = new FormData();
            formData.append('npa', this.npa ?? '');
            formData.append('fullname', this.data.fullname ?? '');
            formData.append('whatsapp', this.data.whatsapp ?? '');
            formData.append('password', this.data.password ?? '');
            formData.append('repeat_password', this.data.repeat_password ?? '');
            axios.post('/aktivasi/register', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then(response => {
                if(response.data.success == 1){
                    let token = response.data.token
                    window.PineconeRouter.navigate('/aktivasi/register/confirm/?token=' + token)
                } else {
                    this.errors = response.data.errors
                    this.registering = false;
                }
            })
        }
    }
})
</script>