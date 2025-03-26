<script>
    Alpine.data('profile', function(){
        return {
            title: "Profile",
            data: [],
            init(){
                window.scrollTo({top:0, behavior:'auto'});
                
                document.title = this.title;
                Alpine.store('core').currentPage = 'profile'
                
    
                if($heroicHelper.cached['profile']){
                    this.data = $heroicHelper.cached['profile']
                } else {   
                    $heroicHelper.fetch('profile/data', {
                        headers: {
                            'Authorization': `Bearer ` + Alpine.store('core').sessionToken,
                        }
                    }).then(data => {
                        $heroicHelper.cached['profile'] = data
                        this.data = data
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
