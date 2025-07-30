<script>
  Alpine.data('instant_login', (token) => {
    return {
      title: "Login",
      errorMessage: null,
      token,

      async init() {
        this.errorMessage = "";

        // Check login using axios post
        $heroicHelper
          .post("/masuk/instant", {token: this.token})
          .then(async (response) => {
            if (response.data.status == 'success') {
              localStorage.setItem("heroic_token", response.data.jwt);
              Alpine.store('core').sessionToken = localStorage.getItem("heroic_token");

              setTimeout(() => {
                window.location.replace("/");
              }, 500);
            } else {
              this.errorMessage = "Token tidak valid";
              await $heroicHelper.toastr(this.errorMessage, 'danger');
              window.location.replace("https://ruangai.id/onboarding");
              setTimeout(() => (this.errorMessage = ""), 10000);
            }
          });
      },

    };
  });
</script>