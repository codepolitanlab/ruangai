<script>
    Alpine.data('pengumuman', function(){
        return {
            title: "Pengumuman",
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
        }
        
    })
</script>
