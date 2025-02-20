// Page component
window.login = function () {
  return {
    title: "Login",
    showPwd: false,
    errorMessage: null,
    buttonSubmitting: false,
    data: {
      username: "",
      password: "",
      logo: "",
      sitename: "",
    },
    sanboxLogin: {},

    async init() {
      if (localStorage.getItem("intro") != 1) {
        window.PineconeRouter.context.navigate("/intro");
      }

      // Place sandbox login if set
      this.sandboxLogin = JSON.parse(Alpine.store('masagi').settings.sandbox_login ? Alpine.store('masagi').settings.sandbox_login : "{}");
      if(this.sandboxLogin && Object.keys(this.sandboxLogin).length > 0){
        this.data.username = this.sandboxLogin.username;
        this.data.password = this.sandboxLogin.password;
      }
      
      document.title = this.title;
      Alpine.store('masagi').currentPage = "login";
      ;

      this.data.logo = Alpine.store('masagi').settings.auth_logo;
      this.data.sitename = Alpine.store('masagi').settings.app_title;
    },

    login() {
      this.errorMessage = "";
      this.buttonSubmitting = true;

      // Check login using axios post
      const formData = new FormData();
      formData.append("username", this.data.username);
      formData.append("password", this.data.password);
      axios
        .post("/login", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.found == 1) {
            localStorage.setItem("heroic_token", response.data.jwt);
            Alpine.store('masagi').sessionToken = localStorage.getItem("heroic_token");

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
};
