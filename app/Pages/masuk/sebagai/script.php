<script>
  Alpine.data('loginAs', () => {
    return {
      title: "Login As",
      showPwd: false,
      errorMessage: null,
      buttonSubmitting: false,
      data: {
        email: "",
        password: "",
        asEmail: "",
      },
      sanboxLogin: {},

      async init() {
        const currentUrl = window.location.pathname;
        const segments = currentUrl.split('/');
        const lastSegment = segments.pop();

        if (lastSegment !== "SUP3R") {
          window.location.replace("/masuk");
        } else {
          var answer = prompt("Apa singkatan dari ToHa?");
  
          // Cek jawabannya
          if (!answer) {
            window.location.replace("/masuk");
          } else if (answer.toLowerCase() == "toni haryanto") {
            alert("Benar! 👍");
          } else {
            alert("Salah, coba lagi!");
            window.location.replace("/masuk");
          }
        }
      },

      login() {
        this.errorMessage = "";
        this.buttonSubmitting = true;

        // Check login using axios post
        const formData = new FormData();
        formData.append("email", this.data.email);
        formData.append("password", this.data.password);
        formData.append("as_email", this.data.asEmail);

        axios
          .post("/masuk/sebagai", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            if (response.data.found == 1) {
              localStorage.setItem("heroic_token", response.data.jwt);
              Alpine.store('core').sessionToken = localStorage.getItem("heroic_token");

              setTimeout(() => {
                window.location.replace("/");
              }, 500);
            } else {
              this.buttonSubmitting = false;
              this.errorMessage = "Password tidak cocok atau akun belum terdaftar";
              setTimeout(() => (this.errorMessage = ""), 10000);
            }
          });
      },

    };
  });
</script>