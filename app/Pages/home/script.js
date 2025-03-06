// Page home
window.home = function(){
  return {
    title: "Beranda",
    data: [],
    comingsoon: false,
    showAllIcons: false,
    swiperArticle: null,
    swiperVideo: null,
    pengumumanRead: [],

    init() {
      if(localStorage.getItem('intro') != 1){
        window.PineconeRouter.context.redirect('/intro');
      }
      
      document.title = this.title;
      Alpine.store('core').currentPage = ''
      
      this.pengumumanRead = JSON.parse(localStorage.getItem('pengumumanRead') ?? '[]')

      this.data.posts = [
        {
          id: 1,
          title: "Belajar AI",
          youtube_url: "/pengumuman",
          published_at: "2022-01-01",
          medias : [
            {
              url: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            }
          ]
        },
        {
          id: 2,
          title: "Belajar AI",
          youtube_url: "/pengumuman",
          published_at: "2022-01-01",
          medias : [
            {
              url: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            }
          ]
        },
        {
          id: 3,
          title: "Belajar AI",
          youtube_url: "/pengumuman",
          published_at: "2022-01-01",
          medias : [
            {
              url: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            }
          ]
        },
      ]
      
      // if(cachePageData['home']){
      //   this.data = cachePageData['home']
      // } else {
      //   fetchPageData('home/supply', {
      //     headers: {
      //       'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
      //       'Pesantrenku-ID': Alpine.store('core').pesantrenID
      //     }
      //   }).then(data => {
      //     cachePageData['home'] = data
      //     this.data = data
      //   }).catch(err => {
      //     console.error(err)
      //   })
      // }
    },
    
    initSwiperArticles () {
      let config = {
        slidesPerView: 1.6,
        spaceBetween: 10,
        slidesOffsetBefore: 15,
        slidesOffsetAfter: 20,
        autoplay: {
          delay: 60000,
          pauseOnMouseEnter: true,
        },
        breakpoints: {
          // when window width is >= 640px
          640: {
            slidesPerView: 2.8,
            spaceBetween: 20
          }
        }
      }

      if(this.data.posts.length > 2){
        config.autoplay.delay = 60000;
      }

      this.swiperArticle = new Swiper(".swiper-article", config);
    },

    initSwiperKajian () {
      let config = {
        slidesPerView: 1.6,
        spaceBetween: 10,
        slidesOffsetBefore: 15,
        slidesOffsetAfter: 20,
        autoplay: {
          delay: 120000,
          pauseOnMouseEnter: true,
        },
        breakpoints: {
          // when window width is >= 640px
          640: {
            slidesPerView: 2.8,
            spaceBetween: 20
          }
        }
      };
      
      if(this.data.kajian.length > 2){
        config.autoplay.delay = 60000;
      }

      this.swiperVideo = new Swiper(".swiper-video", config);
    },

  }
}
