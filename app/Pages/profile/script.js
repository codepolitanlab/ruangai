// Page profile
window.profile = function(){
    return {
        title: "Profile",
        data: [],
        init(){
            window.scrollTo({top:0, behavior:'auto'});
            
            document.title = this.title;
            Alpine.store('masagi').currentPage = 'profile'
            

            if(cachePageData['profile']){
                this.data = cachePageData['profile']
            } else {   
                fetchPageData('profile/supply', {
                    headers: {
                        'Authorization': `Bearer ` + Alpine.store('masagi').sessionToken,
                        'Pesantrenku-ID': Alpine.store('masagi').pesantrenID,
                    }
                }).then(data => {
                    cachePageData['profile'] = data
                    this.data = data
                })
            }
        },
        async logout(){
            // Confirm
            const confirmed = await Prompts.confirm("Anda yakin akan keluar dari aplikasi?");
            if (confirmed) {
                window.location.href = '/logout'
            }
        }
    }
}
