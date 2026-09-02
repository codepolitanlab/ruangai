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
            this.load()
            // Muat ulang jika berpindah antar halaman statis via SPA (slug berubah)
            this.$watch('slug', () => this.load())
        },
        load(){
            this.notFound = false
            this.page = {}
            let url = `page/supply/${this.slug}`

            const cached = $heroicHelper.cached[url]
            if (cached) {
                this.applyPage(cached)
                return
            }

            $heroicHelper.fetch(url, {
                'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
            })
            .then(response => {
                if(!response.data.page) {
                    this.notFound = true
                } else {
                    this.applyPage(response.data.page)
                    $heroicHelper.cached[url] = response.data.page
                }
            })
            .catch(() => { this.notFound = true })
        },
        applyPage(p){
            this.page = p
            this.title = p.title || 'Detail Halaman'
            document.title = this.title
        },
    }
})
</script>