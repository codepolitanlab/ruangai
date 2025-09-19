<script>
  Alpine.data("home", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/home/data/`,
      meta: {
        expandDesc: false,
        graduate: false,
        email: '',
        isValidEmail: false,
        loading: false,
        videoTutorial: null
      }
    })

    return {
      ...base,
      title: "Homepage",
      errorMessage: null,
      swiperNotif: null,
      isVerifying: false,

      videoTutorial: '<iframe width="560" height="315" src="https://www.youtube.com/embed/w53uuuglK-c?si=MOkoAMdF3sALJMmr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',

      otp: ['', '', '', '', '', ''], // 6 digit OTP
      modalInstance: null,

      resendCooldown: 0,
      resendTimer: null,
      emailSent: false,

      // Tambahan countdown
      countdown: '',
      countdownTimer: null,

      init() {
        base.init.call(this);
        this.initSwiperNotif();

        const token = localStorage.getItem('heroic_token');
        if (token) {
          try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            this.meta.isValidEmail = +payload.isValidEmail === 1 ? true : false;
            this.meta.email = payload.email;
          } catch (e) {
            console.error("Failed to parse JWT payload", e);
          }
        }

        this.modalInstance = new bootstrap.Modal(this.$refs.modalVerify);

        const savedDate = localStorage.getItem("event_date_end");
        if (savedDate) {
          this.startCountdown(savedDate);
        }

        // Jalankan countdown kalau ada event
        this.$watch('data', (value) => {
          // if (!value.is_enrolled) {
          //   alert("Kamu belum terdaftar di kelas. Silahkan daftar terlebih dahulu.")
          //   window.location.replace(`https://www.ruangai.id/registration`)
          // }
          localStorage.setItem("event_date_end", value.event.date_end);
          if (value?.event?.date_end) {
            this.startCountdown(value.event.date_end);
          }
        });
      },

      countdownParts: {
        days: "00",
        hours: "00",
        minutes: "00",
        seconds: "00",
      },

      startCountdown(dateEnd) {
        this.updateCountdown(dateEnd);
        this.countdownTimer = setInterval(() => {
          this.updateCountdown(dateEnd);
        }, 1000);
      },

      updateCountdown(dateEnd) {
        const now = new Date().getTime();
        const endDate = new Date(dateEnd).getTime();
        const distance = endDate - now;

        if (distance <= 0) {
          this.countdownParts = {
            days: "00",
            hours: "00",
            minutes: "00",
            seconds: "00"
          };
          clearInterval(this.countdownTimer);
          return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        this.countdownParts = {
          days: String(days).padStart(2, "0"),
          hours: String(hours).padStart(2, "0"),
          minutes: String(minutes).padStart(2, "0"),
          seconds: String(seconds).padStart(2, "0"),
        };
      },

      claimCertificate() {
        if (this.data.course_completed) {
          if (!this.data.student.cert_code || !this.data.student.cert_code == '') {
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

          breakpoints: {
            0: {
              slidesPerView: 1.15,
              spaceBetween: 15,
              slidesOffsetBefore: 20,
              slidesOffsetAfter: 15,
            },
            640: {
              slidesPerView: 1.1,
              spaceBetween: 15,
              slidesOffsetBefore: 0,
              slidesOffsetAfter: 15,
            }
          }
        }
        this.swiperNotif = new Swiper(".swiper-notif", config);
      },

      heregister() {
        $heroicHelper.post(`/courses/intro/heregister`, {
          course_id: 1
        }).then((response) => {
          if (response.data.response_code == 200) {
            $heroicHelper.toastr("Anda telah terdaftar di program Chapter 2! Selamat melanjukan belajar.", 'success', 'bottom')
            this.data.is_expire = false
          }
        })
      },

      startResendCooldown() {
        this.resendCooldown = 5;
        this.resendTimer = setInterval(() => {
          this.resendCooldown--;
          if (this.resendCooldown <= 0) {
            clearInterval(this.resendTimer);
          }
        }, 1000);
      },

      handleOtpInput(event, index) {
        this.errorMessage = null;
        const value = event.target.value;

        if (/^[0-9]$/.test(value)) {
          this.otp[index] = value;
          if (index < 5) {
            this.$nextTick(() => {
              this.$refs[`otp${index + 1}`].focus();
            });
          }
        } else {
          this.otp[index] = '';
        }
      },

      handleBackspace(event, index) {
        if (index > 0 && event.target.value === '') {
          this.$nextTick(() => {
            this.$refs[`otp${index - 1}`].focus();
          });
        }
      },

      resetOtp() {
        this.otp = ['', '', '', '', '', ''];
        this.errorMessage = null;
      },

      showPopupVerification() {
        this.modalInstance.show();
      },

      async sendEmailVerification(resend = false) {
        const token = localStorage.getItem('heroic_token');

        if (this.emailSent && !resend) {
          setTimeout(() => {
            if (this.$refs.otp0) {
              this.$refs.otp0.focus();
            }
          }, 600);
          return;
        }

        this.meta.loading = true;
        setTimeout(() => {
          $heroicHelper
            .post("/home/sendEmailVerification", {
              email: this.meta.email
            })
            .then(async (response) => {
              if (response.data.status == 'success') {
                this.startResendCooldown();
                if (!resend) {
                  this.modalInstance.show();
                  setTimeout(() => {
                    if (this.$refs.otp0) {
                      this.$refs.otp0.focus();
                    }
                  }, 600);
                }
                this.emailSent = true;
              } else {
                await $heroicHelper.toastr(response.data.message || "Gagal mengirim email verifikasi.", 'danger', 'bottom');
              }
            })
            .catch((error) => {
              console.error(error);
              Prompts.alert("Terjadi kesalahan saat mengirim email.");
            })
            .finally(() => {
              this.meta.loading = false;
            });
        }, 1300)
      },

      async resendOtp() {
        if (this.resendCooldown > 0) return;
        this.resetOtp();
        this.emailSent = false;
      },

      copyToClipboard(text) {
        navigator.clipboard.writeText(`https://ruangai.id/cmref/${text}`);
        $heroicHelper.toastr('Link disalin ke clipboard', 'success', 'bottom');
      },

      async verifyEmail() {
        if (this.otp.join('').length !== 6) {
          this.errorMessage = "OTP harus terdiri dari 6 digit.";
          return;
        }

        this.isVerifying = true;
        this.errorMessage = null;

        const token = localStorage.getItem('heroic_token');
        const otpCode = this.otp.join('');

        $heroicHelper
          .post("/home/verifyEmail", {
            email: this.meta.email,
            otp: otpCode
          })
          .then(async (response) => {
            if (response.data.status == 'success') {
              this.isVerifying = false;
              this.meta.isValidEmail = true;

              localStorage.setItem('heroic_token', response.data.jwt);
              await Prompts.alert(response.data.message);
              this.modalInstance.hide();
              this.resetOtp();
            } else {
              this.errorMessage = response.data.message || "Kode OTP tidak valid.";
            }
          })
          .catch((error) => {
            this.errorMessage = "Terjadi kesalahan pada server.";
            console.error(error);
          })
          .finally(() => {
            this.isVerifying = false;
          });
      },
      setVideoTutorial(url) {
        this.meta.videoTutorial = url;
      }
    };
  });
</script>