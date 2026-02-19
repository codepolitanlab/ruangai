<script>
  Alpine.data("verifyEmail", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/verify_email/data/`,
    })

    return {
      ...base,
      title: "Verifikasi Email",
      email: '',
      loading: false,
      isVerifying: false,
      emailSent: false,
      errorMessage: null,
      
      otp: ['', '', '', '', '', ''],
      resendCooldown: 0,
      resendTimer: null,

      getCallbackUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const callback = urlParams.get('callback');
        return callback || '/'; // Default to root if no callback
      },

      init() {
        base.init.call(this);

        // Use server-side value from `data` (not localStorage) to prefill and decide redirect
        if (this.data) {
          // Prefill email if provided by the server
          if (this.data.email) this.email = this.data.email;

          if (this.data.isValidEmail === true) {
            $heroicHelper.toastr('Email Anda sudah terverifikasi', 'success', 'bottom');
            setTimeout(() => {
              window.location.href = this.getCallbackUrl();
            }, 800);
            return;
          }
        }

        // Watch server data for authoritative value (in case it changes)
        this.$watch('data', (value) => {
          if (!value) return;

          // keep email in sync with server
          if (value.email) this.email = value.email;

          if (value.isValidEmail === true) {
            $heroicHelper.toastr('Email Anda sudah terverifikasi', 'success', 'bottom');
            setTimeout(() => window.location.href = this.getCallbackUrl(), 800);
          }
        });
      },

      async sendEmailVerification(resend = false) {
        const token = localStorage.getItem('heroic_token');

        if (!this.email) {
          $heroicHelper.toastr('Email tidak boleh kosong', 'danger', 'bottom');
          return;
        }

        if (this.emailSent && !resend) {
          setTimeout(() => {
            if (this.$refs.otp0) {
              this.$refs.otp0.focus();
            }
          }, 600);
          return;
        }

        this.loading = true;
        setTimeout(() => {
          $heroicHelper
            .post("/verify_email/sendEmailVerification", {
              email: this.email
            })
            .then(async (response) => {
              if (response.data.status == 'success') {
                this.startResendCooldown();
                this.emailSent = true;
                $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                
                setTimeout(() => {
                  if (this.$refs.otp0) {
                    this.$refs.otp0.focus();
                  }
                }, 300);
              } else {
                await $heroicHelper.toastr(response.data.message || "Gagal mengirim email verifikasi.", 'danger', 'bottom');
              }
            })
            .catch((error) => {
              console.error(error);
              $heroicHelper.toastr("Terjadi kesalahan saat mengirim email.", 'danger', 'bottom');
            })
            .finally(() => {
              this.loading = false;
            });
        }, 1300)
      },

      startResendCooldown() {
        this.resendCooldown = 60;
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
          .post("/verify_email/verifyEmail", {
            email: this.email,
            otp: otpCode
          })
          .then(async (response) => {
            if (response.data.status == 'success') {
              this.isVerifying = false;

              // Persist new token and do a full-page redirect to ensure all pages pick up the new JWT
              localStorage.setItem('heroic_token', response.data.jwt);
              await Prompts.alert(response.data.message);
              window.location.href = this.getCallbackUrl();
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
      }
    };
  });
</script>
