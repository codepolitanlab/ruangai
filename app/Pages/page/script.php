<script>
Alpine.data('page', function(slug) {
    return {
        title: "Detail Halaman",
        slug: slug,
        notFound: false,
        page: {},
        init(){
            document.title = this.title;
            Alpine.store('core').currentPage = 'page'

            // Get cache if exists
            let url = `page/supply/${this.slug}`;
            this.page = $heroicHelper.cached[url] ?? {};
            if(Object.keys(this.page).length === 0) {
                $heroicHelper.fetch(url, {
                    'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                })
                .then(response => {
                    if(response.data.page.length == 0) {
                        this.notFound = true
                    } else {
                        this.page = response.data.page
                        $heroicHelper.cached[url] = this.page
                        this.title = this.page.title
                        document.title = this.page.title
                    }
                })
            }
        },
    }
})
</script>