<script>
  Alpine.data('home', function() {
    return {
      title: "Beranda",
      data: [],
      comingsoon: false,
      showAllIcons: false,
      swiperArticle: null,
      swiperVideo: null,
      pengumumanRead: [],
      redirectToCourse: true,

      initialize() {
        // Sementara redirect ke intro course
        if(this.redirectToCourse) {
          console.log('redirecting...')
          window.PineconeRouter.navigate('/courses/intro/353/laravel-security');
        }

        // if (localStorage.getItem('intro') != 1) {
        //   window.PineconeRouter.navigate('/intro');
        // }

        document.title = this.title;
        Alpine.store('core').currentPage = ''

        this.pengumumanRead = JSON.parse(localStorage.getItem('pengumumanRead') ?? '[]')

        this.data.posts = [{
            id: 1,
            title: "Belajar AI",
            youtube_url: "/pengumuman",
            published_at: "2022-01-01",
            medias: [{
              url: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            }]
          },
          {
            id: 2,
            title: "Belajar AI",
            youtube_url: "/pengumuman",
            published_at: "2022-01-01",
            medias: [{
              url: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            }]
          },
          {
            id: 3,
            title: "Belajar AI",
            youtube_url: "/pengumuman",
            published_at: "2022-01-01",
            medias: [{
              url: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            }]
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

      initSwiperArticles() {
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

        if (this.data.posts.length > 2) {
          config.autoplay.delay = 60000;
        }

        this.swiperArticle = new Swiper(".swiper-article", config);
      },

      initSwiperKajian() {
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

        if (this.data.kajian.length > 2) {
          config.autoplay.delay = 60000;
        }

        this.swiperVideo = new Swiper(".swiper-video", config);
      },

      init() {
        this.data.videos = [{
            id: 1,
            title: "Belajar AI",
            youtube_url: "/pengumuman",
            published_at: "2022-01-01",
            featured_image: "https://madrasahdigital.id//uploads/madrasahdigital/sources/desain-bangunan-pesantren.jpg",
          },
          {
            id: 2,
            title: "Belajar AI",
            youtube_url: "/pengumuman",
            published_at: "2022-01-01",
            featured_image: "https://madrasahdigital.id//uploads/madrasahdigital/sources/pengurugan-tanah-pesantren.jpg",
          },
          {
            id: 3,
            title: "Belajar AI",
            youtube_url: "/pengumuman",
            published_at: "2022-01-01",
            featured_image: "https://madrasahdigital.id//uploads/madrasahdigital/sources/jalan-pesantren.jpg",
          },
          // Add more video items as needed
        ];

        this.data.articles = [{
            id: 1,
            title: "Belajar AI",
            slug: "belajar-ai",
            featured_image: "https://madrasahdigital.id//uploads/madrasahdigital/sources/sumber-cuan-content-creator.png",
            custom_author: "RuangAI"
          },
          {
            id: 2,
            title: "Belajar AI",
            slug: "belajar-ai",
            featured_image: "https://madrasahdigital.id//uploads/madrasahdigital/sources/Apa%20itu%20Digital%20Savvy%20(1).png",
            custom_author: "RuangAI"
          },
          {
            id: 3,
            title: "Belajar AI",
            slug: "belajar-ai",
            featured_image: "https://madrasahdigital.id//uploads/madrasahdigital/sources/Al-Jazari.png",
            custom_author: "RuangAI"
          },
          // Add more article items as needed
        ];
      },

      initBannerSwiper() {
        let config = {
          slidesPerView: 1,
          spaceBetween: 0,
          autoplay: {
            delay: 3000,
            disableOnInteraction: false,
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          loop: true
        };

        this.swiperBanner = new Swiper(".swiper-banner", config);
      },

      initVideoSwiper() {
        let config = {
          slidesPerView: 2.5,
          spaceBetween: 10,
          slidesOffsetBefore: 15,
          slidesOffsetAfter: 20,
          autoplay: {
            delay: 120000,
            pauseOnMouseEnter: true,
          }
        };

        if (this.data.videos?.length > 2) {
          config.autoplay.delay = 60000;
        }

        this.swiperVideo = new Swiper(".swiper-video", config);
      },

      initArticleSwiper() {
        let config = {
          slidesPerView: 2.5,
          spaceBetween: 10,
          slidesOffsetBefore: 15,
          slidesOffsetAfter: 20,
          autoplay: {
            delay: 60000,
            pauseOnMouseEnter: true,
          }
        };

        if (this.data.articles?.length > 2) {
          config.autoplay.delay = 60000;
        }

        this.swiperArticle = new Swiper(".swiper-article", config);
      }
    }
  })
</script>