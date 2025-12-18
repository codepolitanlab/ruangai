<script>
  Alpine.data('register', () => {
    return {
      title: "Daftar Akun",
      showPwd: false,
      errorMessage: null,
      successMessage: null,
      buttonSubmitting: false,
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

        // Validate phone number is numeric
        if (this.data.phone && !/^\d+$/.test(this.data.phone)) {
          this.errors.phone = "Nomor telepon harus berupa angka";
          this.errorMessage = "Nomor telepon harus berupa angka";
          setTimeout(() => (this.errorMessage = ""), 5000);
          return;
        }

        this.buttonSubmitting = true;

        // Check registration using axios post
        const formData = new FormData();
        formData.append("fullname", this.data.fullname ?? "");
        formData.append("email", this.data.email ?? "");
        formData.append("phone", this.data.phone ?? "");
        formData.append("password", this.data.password ?? "");
        formData.append("repeat_password", this.data.repeat_password ?? "");
        
        axios
          .post("/registrasi", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            if (response.data.success == 1) {
              this.successMessage = response.data.message || "Registrasi berhasil! Silakan login untuk melanjutkan.";
              
              // Redirect to login page after 2 seconds
              setTimeout(() => {
                window.location.replace("/masuk?redirect=challenge");
              }, 2000);
            } else {
              this.buttonSubmitting = false;
              
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
            this.errorMessage = "Terjadi kesalahan. Silahkan coba lagi.";
            setTimeout(() => (this.errorMessage = ""), 5000);
            console.error("Registration error:", error);
          });
      },

    };
  });
</script>
