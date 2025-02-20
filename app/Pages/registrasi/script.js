// Page member/component
window.member_register = function(){
    return {
        title: "Register",
        showPwd: false,
        registering: false,
        data: {
            fullname: '',
            whatsapp: '',
            password: '',
            repeat_password: '',
            logo: '',
            sitename: '',
        },
        errors: {
            fullname: '',
            whatsapp: '',
            password: '',
            repeat_password: '',
        },
        init(){
            document.title = this.title
            Alpine.store('core').currentPage = 'registrasi'
            Alpine.store('core').showBottomMenu = false
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
            formData.append('fullname', this.data.fullname ?? '');
            formData.append('whatsapp', this.data.whatsapp ?? '');
            formData.append('password', this.data.password ?? '');
            formData.append('repeat_password', this.data.repeat_password ?? '');
            axios.post('/registrasi', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Pesantrenku-ID': Alpine.store('core').pesantrenID
                }
            }).then(response => {
                if(response.data.success == 1){
                    let token = response.data.token + '_' + response.data.id + 'X' + Math.random().toString(36).substring(7)
                    window.PineconeRouter.context.navigate('/registrasi/confirm/?token=' + token)
                } else {
                    this.errors = response.data.errors
                    this.registering = false;
                }
            })
        }
    }
}