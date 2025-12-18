<script>
  Alpine.data('register', (recaptchaSiteKey) => {
    return {
      title: "Daftar Akun",
      showPwd: false,
      showRepeatPwd: false,
      errorMessage: null,
      successMessage: null,
      buttonSubmitting: false,
      recaptcha: '',
      recaptchaWidget: null,
      redirect: null,
      showRecaptcha: false,
      data: {
        fullname: "",
        email: "",
        phone: "",
        password: "",
        repeat_password: "",
        logo: "",
        sitename: "",
      },
      errors: {
        fullname: "",
        email: "",
        phone: "",
        password: "",
        repeat_password: "",
      },

      async init() {
        document.title = this.title;
        Alpine.store('core').currentPage = "registrasi";

        this.data.logo = Alpine.store('core').settings.auth_logo;
        this.data.sitename = Alpine.store('core').settings.app_title;

        // Read redirect parameter from URL
        const params = new URLSearchParams(window.location.search);
        const r = params.get('redirect');
        if (r) {
          this.redirect = decodeURIComponent(r);
        }

        // Wait for grecaptcha to be ready and render widget
        const waitForRecaptcha = () => {
          if (typeof grecaptcha !== 'undefined' && grecaptcha.render) {
            try {
              this.recaptchaWidget = grecaptcha.render('grecaptcha-register', { 
                'sitekey': recaptchaSiteKey,
                'callback': (response) => {
                  this.recaptcha = response;
                }
              });
            } catch (e) {
              console.error('reCAPTCHA init error', e);
            }
          } else {
            setTimeout(waitForRecaptcha, 100);
          }
        };
        
        if (recaptchaSiteKey) {
          waitForRecaptcha();
        }
      },

      register() {
        // Reset messages and errors
        this.errorMessage = "";
        this.successMessage = "";
        this.errors = {
          fullname: "",
          email: "",
          phone: "",
          password: "",
          repeat_password: "",
        };

        // Validate fullname: disallow numbers and symbols
        if (this.data.fullname && /[^A-Za-zÀ-ÖØ-öø-ÿ\s'’-]/.test(this.data.fullname)) {
          this.errors.fullname = "Nama tidak boleh mengandung angka atau simbol";
          this.errorMessage = "Nama tidak boleh mengandung angka atau simbol";
          setTimeout(() => (this.errorMessage = ""), 5000);
          return;
        }

        // Validate phone number is numeric
        if (this.data.phone && !/^\d+$/.test(this.data.phone)) {
          this.errors.phone = "Nomor telepon harus berupa angka";
          this.errorMessage = "Nomor telepon harus berupa angka";
          setTimeout(() => (this.errorMessage = ""), 5000);
          return;
        }

        this.buttonSubmitting = true;

        // get recaptcha response from widget
        if (typeof grecaptcha !== 'undefined' && this.recaptchaWidget !== null) {
          try {
            this.recaptcha = grecaptcha.getResponse(this.recaptchaWidget);
          } catch (e) {
            console.error('grecaptcha getResponse error', e);
            this.recaptcha = '';
          }
        }

        if (!this.recaptcha || this.recaptcha.trim() === '') {
          this.errorMessage = 'Ceklis dulu Recaptcha.';
          this.buttonSubmitting = false;
          setTimeout(() => (this.errorMessage = ''), 4000);
          return;
        }

        // Check registration using axios post
        const formData = new FormData();
        formData.append("fullname", this.data.fullname ?? "");
        formData.append("email", this.data.email ?? "");
        formData.append("phone", this.data.phone ?? "");
        formData.append("password", this.data.password ?? "");
        formData.append("repeat_password", this.data.repeat_password ?? "");
        formData.append("recaptcha", this.recaptcha);
        
        axios
          .post("/registrasi", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            if (response.data.success == 1) {
              this.successMessage = response.data.message || "Registrasi berhasil!";
              
              // Save JWT token to localStorage for auto-login
              if (response.data.jwt) {
                localStorage.setItem("heroic_token", response.data.jwt);
                Alpine.store('core').sessionToken = response.data.jwt;
              }
              
              // Redirect to specified page or challenge
              setTimeout(() => {
                let target = '/challenge';
                if (this.redirect) {
                  const r = String(this.redirect).trim();
                  if (/^https?:\/\//i.test(r)) {
                    target = r;
                  } else {
                    target = r.startsWith('/') ? r : '/' + r;
                  }
                }
                window.location.replace(target);
              }, 1000);
            } else {
              this.buttonSubmitting = false;
              
              // Reset reCAPTCHA widget after any error so user can get new token
              if (this.recaptchaWidget !== null) {
                try { 
                  grecaptcha.reset(this.recaptchaWidget);
                  this.recaptcha = ''; // Clear stored token
                } catch (e) { 
                  console.error('reCAPTCHA reset error', e); 
                }
              }

              // Check if there are validation errors
              if (response.data.errors) {
                this.errors = response.data.errors;
                
                // Show first error as toast message
                const firstError = Object.values(response.data.errors)[0];
                this.errorMessage = firstError;
              } else {
                this.errorMessage = response.data.message || "Gagal mendaftar. Silahkan coba lagi.";
              }
              
              setTimeout(() => (this.errorMessage = ""), 5000);
            }
          })
          .catch((error) => {
            this.buttonSubmitting = false;
            
            // Reset reCAPTCHA on network error
            if (this.recaptchaWidget !== null) {
              try { 
                grecaptcha.reset(this.recaptchaWidget);
                this.recaptcha = '';
              } catch (e) { 
                console.error('reCAPTCHA reset error', e); 
              }
            }
            
            this.errorMessage = "Terjadi kesalahan. Silahkan coba lagi.";
            setTimeout(() => (this.errorMessage = ""), 5000);
            console.error("Registration error:", error);
          });
      },

    };
  });
</script>
