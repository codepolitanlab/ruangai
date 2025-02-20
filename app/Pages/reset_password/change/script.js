// Page component
window.reset_password_confirm = function(tokens){
    return {
        title: "Reset Password",
        data: {
            logo: '',
            id: '',
            otp: '',
            token: '',
            password: '',
        },
        showPwd: false,
        sending: false,
        error: '',
        
        init(){
            document.title = this.title
            Alpine.store('masagi').currentPage = 'change_password'
            
            this.data.logo = Alpine.store('masagi').settings.auth_logo

            const tokenRegex = /^[a-f0-9]+_[0-9]+X.+$/;
            const urlParams = new URLSearchParams(window.location.search);
            if (!tokenRegex.test(tokens)) {
                window.PineconeRouter.context.redirect('/reset_password')
            }

            const [part1, rest] = tokens.split('_');  // Bagian pertama sebelum _ adalah token
            const [part2, part3] = rest.split('X'); // Bagian kedua antara _ dan X, dan bagian ketiga
            this.data.token = part1
            this.data.id = part2
        },

        confirm(){
            // Gain javascript form validation
            if(this.data.otp == ''){
                this.error = 'Kode Reset tidak boleh kosong.'
                return;
            }

            if(this.data.password == ''){
                this.error = 'Password baru tidak boleh kosong.'
                return;
            }

            // Check register_confirm using axios post
            const formData = new FormData();
            formData.append('id', this.data.id ?? '');
            formData.append('token', this.data.token ?? '');
            formData.append('otp', this.data.otp ?? '');
            formData.append('password', this.data.password ?? '');
            axios.post('/reset_password/change/confirm', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Pesantrenku-ID': Alpine.store('masagi').pesantrenID
                }
            }).then(response => {
                if(response.data.success == 1){
                    localStorage.setItem('heroic_token', response.data.jwt)
                    setTimeout(() => {
                        Alpine.store('masagi').sessionToken = localStorage.getItem('heroic_token')
                        window.PineconeRouter.context.redirect('/')
                    })
                } else {
                    this.error = response.data.message
                }
            })
        },
    }
}