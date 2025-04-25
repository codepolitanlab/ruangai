<script>
Alpine.data('aktivasi', function(){
    return {
        title: "Aktivasi",
        checking: false,
        data: {
            token: '',
            npa: '',
        },

        init(){
            document.title = this.title
            Alpine.store('core').currentPage = 'aktivasi'

            this.data.logo = Alpine.store('core').settings.auth_logo;
            this.data.sitename = Alpine.store('core').settings.site_title;
        },

        checkActivationToken() {
            this.checking = true;

            // Check login using axios post
            const formData = new FormData();
            formData.append('token', this.data.token ?? '');
            formData.append('npa', this.data.npa ?? '');
            axios.post('/aktivasi', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then(response => {
                if(response.data.found == 1){
                    let token = response.data.token
                    window.PineconeRouter.navigate('/aktivasi/register/?token=' + token)
                } else {
                    this.errors = response.data.message
                    this.registering = false;
                }
            })
        }
    }
})
</script>