<script>
    Alpine.data('profile', function(){
        return {
            title: "Profile",
            data: {},
            init(){
                window.scrollTo({top:0, behavior:'auto'});
                
                document.title = this.title;
                Alpine.store('core').currentPage = 'profile'
                
    
                if($heroicHelper.cached['profile']){
                    this.data = $heroicHelper.cached['profile']
                } else {   
                    $heroicHelper.fetch('profile/data')
                    .then(response => {
                        $heroicHelper.cached['profile'] = response.data
                        this.data = response.data
                    })
                }
            },
            async logout(){
                // Confirm
                const confirmed = await Prompts.confirm("Anda yakin akan keluar dari aplikasi?");
                if (confirmed) {
                    window.location.href = '/keluar'
                }
            }
        }
        
    })
</script>
