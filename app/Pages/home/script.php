<script>
  Alpine.data("home", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/home/data/`,
      meta: {
        expandDesc: false,
        graduate: false
      }
    })

    return {
      ...base,
      title: "Homepage",
      errorMessage: null,
      swiperNotif: null,

      init() {
        base.init.call(this);
        this.initSwiperNotif();
        this.$watch('data', (value) => {
          // if (!value.is_enrolled) {
          //   alert("Kamu belum terdaftar di kelas. Silahkan daftar terlebih dahulu.")
          //   window.location.replace(`https://www.ruangai.id/registration`)
          // }
        });
      },

      claimCertificate() {
        if(this.data.course_completed) {
          if(!this.data.student.cert_code || !this.data.student.cert_code == '') {
            this.$router.navigate(`/certificate/claim/${this.data.course.id}`)
          } else {
            this.$router.navigate(`/certificate/${this.data.student.cert_code}`)
          }
        }
      },

      initSwiperNotif() {
        let config = {
          slidesPerView: 1.5,
          spaceBetween: 15,
          slidesOffsetAfter: 15,

          // Non-aktifkan autoplay jika tidak diperlukan, atau sesuaikan
          // autoplay: {
          //   delay: 5000,
          //   pauseOnMouseEnter: true,
          // },

          breakpoints: {
            // Untuk layar lebih kecil, jika perlu
            0: {
              slidesPerView: 1.15,
              spaceBetween: 15,
              slidesOffsetBefore: 20,
              slidesOffsetAfter: 15,
            },
            // Untuk layar lebih besar, jika perlu
            640: {
              slidesPerView: 1.5,
              spaceBetween: 15,
              slidesOffsetBefore: 20,
              slidesOffsetAfter: 15,
            }
          }
        }
        this.swiperNotif = new Swiper(".swiper-notif", config);
      },
    };
  });
</script>