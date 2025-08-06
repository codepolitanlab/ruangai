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
        loading: false
      }
    })

    return {
      ...base,
      title: "Homepage",
      errorMessage: null,
      swiperNotif: null,
      isVerifying: false,

      otp: ['', '', '', '', '', ''], // 6 digit OTP
      modalInstance: null,

      resendCooldown: 0,
      resendTimer: null,
      emailSent: false,

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
        this.resendCooldown = 5; // Mulai dari 60 detik
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

        // Check if email verification has been sent, only show modal
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
          }) // Kirim OTP ke backend
          .then(async (response) => {
            if (response.data.status == 'success') {
              this.isVerifying = false;
              this.meta.isValidEmail = true;

              localStorage.setItem('heroic_token', response.data.jwt);
              await Prompts.alert(response.data.message);
              this.modalInstance.hide();
              this.resetOtp();
            } else {
              // Tampilkan error dari backend
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
      }
    };
  });
</script>