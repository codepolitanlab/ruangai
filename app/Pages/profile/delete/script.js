// Page component
window.profile_delete = function(){
    return {
        title: "Hapus Akun",
        showPwd: false,
        errorMessage: "",
        deleting: false,
        data: {
            whatsapp: '',
            password: '',
        },

        init(){
            document.title = this.title
            Alpine.store('masagi').currentPage = 'profile_delete'
            
        },

        removeAccount() {
            this.errorMessage = ""

            if(this.data.whatsapp == '' || this.data.password == '') {
                this.errorMessage = 'Mohon lengkapi semua kolom'
                return;
            }

            // Check login using axios post
            const formData = new FormData();
            formData.append('whatsapp', this.data.whatsapp ?? '');
            formData.append('password', this.data.password ?? '');
            axios.post('/profile/delete', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Pesantrenku-ID': Alpine.store('masagi').pesantrenID,
                    'Authorization': 'Bearer ' + localStorage.getItem('heroic_token')
                }
            }).then(response => {
                if(response.data.success == 1){
                    localStorage.removeItem('heroic_token')
                    window.PineconeRouter.context.navigate('/login')
                } else {
                    this.errorMessage = response.data.message
                }
            })
        }
    }
}