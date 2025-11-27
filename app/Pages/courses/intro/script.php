<script>
  Alpine.data("courseIntro", function(course_id) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/courses/intro/data/${course_id}`,
      meta: {
        expandDesc: false,
        graduate: false,
        isValidEmail: false,
        videoTeaser: null
      }
    })

    return {
      ...base,
      title: "course intro",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
          // if (!value.is_enrolled) {
          //   alert("Kamu belum terdaftar di kelas. Silahkan daftar terlebih dahulu.")
          //   window.location.replace(`https://www.ruangai.id/registration`)
          // }
        });

        const token = localStorage.getItem('heroic_token');
        if (token) {
          try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            this.meta.isValidEmail = +payload.isValidEmail === 1 ? true : false;
          } catch (e) {
            console.error("Failed to parse JWT payload", e);
          }
        }
      },

      claimCertificate() {
        if (!this.meta.isValidEmail) {
          $heroicHelper.toastr("Kamu belum melakukan verifikasi email nih, silahkan lakukan verifikasi email terlebih dahulu untuk klaim sertifikat.", "warning", "bottom");
          return
        }

        if (this.data.course_completed) {
          if (!this.data.certificate_id) {
            this.$router.navigate(`/courses/claim_certificate/${this.data.course.id}`)
          } else {
            window.location.href = `/certificate/show/${this.data.certificate_id}`;
          }
        } else {
          $heroicHelper.toastr("Kamu belum menyelesaikan kelas ini. Silahkan selesaikan kelas terlebih dahulu.", "warning", "bottom");
        }
      },

      claimReward() {
        this.$router.navigate(`/courses/reward`)
      },

      heregister() {
        $heroicHelper.post(`/courses/intro/heregister`, {
          course_id: this.data.course.id
        }).then((response) => {
          if (response.data.response_code == 200) {
            $heroicHelper.toastr("Anda telah terdaftar di program Chapter 3! Selamat melanjukan belajar.", 'success', 'bottom')
            this.data.is_expire = false
          }
        })
      },

      setVideoTeaser(url) {
        this.meta.videoTeaser = url;
      },
    };
  });
</script>