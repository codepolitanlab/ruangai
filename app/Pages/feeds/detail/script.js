window.feeds_detail = function(id){
    return {
        title: "Detail Info",
        id: id,
        notFound: false,
        feed: {},
        swiper: null,
        init(){
            document.title = this.title;
            Alpine.store('masagi').currentPage = 'feed'
            

            // Get cache if exists
            this.feed = cachePageData[`feeds`]?.feeds.filter(item => item.id == this.id) ?? {};
            if(Object.keys(this.feed).length == 0) {
                fetchPageData(`feeds/detail/supply/${this.id}`, {
                    headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                        'Pesantrenku-ID': Alpine.store('masagi').pesantrenID
                    }
                })
                .then(data => {
                    if(data.data.post.length == 0){
                        this.notFound = true
                    } else {
                        this.feed = data.data.post
                    }
                })
            }
        },
        
        initFeedSwiper() {
            this.swiper = new Swiper(".feed-carousel", {
                pagination: {
                  el: ".swiper-pagination",
                  type: "fraction",
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        },

        formatDate(dateString){
            if(dateString && dateString != '0000-00-00') {
                const date = new Date(dateString);
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Intl.DateTimeFormat('id-ID', options).format(date);
            }
            return '';
        },
    }
}
