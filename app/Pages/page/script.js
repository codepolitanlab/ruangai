window.page = function(slug) {
    return {
        title: "Detail Halaman",
        slug: slug,
        notFound: false,
        page: {},
        init(){
            document.title = this.title;
            Alpine.store('masagi').currentPage = 'page'
            

            // Get cache if exists
            let url = `page/supply/${this.slug}`;
            this.page = cachePageData[url] ?? {};
            if(Object.keys(this.page).length === 0) {
                fetchPageData(url, {
                    headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                        'Pesantrenku-ID': Alpine.store('masagi').pesantrenID
                    }
                })
                .then(data => {
                    if(data.data.page.length == 0) {
                        this.notFound = true
                    } else {
                        this.page = data.data.page
                        cachePageData[url] = this.page
                        this.title = this.page.title
                        document.title = this.page.title
                    }
                })
            }
        },
    }
}
