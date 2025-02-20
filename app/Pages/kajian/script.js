window.kajian = function(){
    return {
        title: "Kajian",
        videos: [],
        nextPage: 1,
        empty: false,
        init(){
            document.title = this.title;
            Alpine.store('masagi').currentPage = 'videos'
            

            if(cachePageData[`kajian`]?.videos.length > 0){
                cachePageData[`kajian`].videos.forEach(item => {
                    this.videos.push(item)
                })
                this.nextPage = cachePageData[`kajian`].nextPage ?? 1;
                this.empty = cachePageData[`kajian`].empty ?? false;
            } else {
                cachePageData[`kajian`] = {}
                this.loadVideos()
            }
        },
        formatDate(dateString){
            if(dateString && dateString != '0000-00-00'){
                const date = new Date(dateString);
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Intl.DateTimeFormat('id-ID', options).format(date);
            }
            return '';
        },
        loadMore() {
            this.loadVideos()
        },
        loadVideos() {
            console.log('Fetching data...');
            fetchPageData(`kajian/supply?page=${this.nextPage}`, {
                headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                    'Pesantrenku-ID': Alpine.store('masagi').pesantrenID
                }
            }).then(data => {
                if(data.data.videos.length == 0){
                    this.empty = true
                    cachePageData[`kajian`].empty = true
                } else {
                    data.data.videos.forEach(item => {
                        this.videos.push(item)
                    })
                    this.nextPage++

                    cachePageData[`kajian`].videos = this.videos
                    cachePageData[`kajian`].nextPage = this.nextPage
                }
            })
        },
        showDetail(index){
            window.PineconeRouter.context.navigate(`/kajian/${this.videos[index].id}`);
        },
        stripIntro(wordNum, sentence, index){
            let words = sentence.split(` `);
            if(words.length > wordNum){
                let result = words.slice(0, wordNum).join(` `)
                return result + `... <a href="javascript:void()" x-on:click="showDetail(${index})">Selengkapnya</a>`
            } else {
                return sentence;
            }
        }
    }
}
