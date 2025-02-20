// Page component
window.profile_edit_account = function () {
  return {
    title: "Edit Akun",
    sendingEmail: false,
    sendingPhone: false,
    token: "",
    otp_email_sent: false,
    otp_phone_sent: false,
    data: {
      profile: {},
    },
    model: {
      email: "",
      phone: "",
      otp_email: "",
      otp_phone: ""
    },
    errors: {
      email: "",
      phone: "",
    },
    emailModalInstance: null,
    phoneModalInstance: null,

    init() {
      document.title = this.title;
      Alpine.store("masagi").currentPage = "profile";

      if (cachePageData["profile"]) {
        this.data = cachePageData["profile"];
      } else {
        fetchPageData("profile/supply", {
          headers: {
            Authorization: `Bearer ` + Alpine.store("masagi").sessionToken,
          },
        }).then((data) => {
          this.data = data;
          cachePageData["profile"] = this.data;
        });
      }

       // Create modal instance
       const modalEmail = document.getElementById('ModalFormEmail')
       this.emailModalInstance = window.bootstrap.Modal.getOrCreateInstance(modalEmail)
       const modalPhone = document.getElementById('ModalFormWA')
       this.phoneModalInstance = window.bootstrap.Modal.getOrCreateInstance(modalPhone)
    },

    generateToken(type) {
      postPageData('/profile/edit_account/generateToken/' + type)
      .then(response => {
        if(response.success == 1){
          this.token = response.token
        } else {
          toastr('Terjadi kesalahan saat membuat token', 'warning')
        }
      })
    },

    // Sending OTP to email
    sendOTPEmail() {
      this.sendingEmail = true
      postPageData('/profile/edit_account/sendOTPEmail', {token: this.token, email: this.model.email})
      .then(response => {
        if(response.success == 1) {
          toastr(response.message, 'info');
          this.otp_email_sent = true
        } else {
          toastr(response.message, 'warning');
        }
        this.sendingemail = false
      })
    },
    
    // Sending OTP to whatsapp number
    sendOTPPhone() {
      this.sendingPhone = true
      postPageData('/profile/edit_account/sendOTPPhone', {token: this.token, phone: this.model.phone})
      .then(response => {
        if(response.success == 1) {
          toastr(response.message, 'info');
          this.otp_phone_sent = true
        } else {
          toastr(response.message, 'warning');
        }
        this.sendingPhone = false
      })
    },

    // Submit new phone number
    changePhone() {
      this.errors = {
        phone: "",
      };

      // Check login using axios post
      postPageData("/profile/edit_account/changePhone", {phone: this.model.phone, otp: this.model.otp_phone})
      .then((response) => {
        if (response.success == 1) {
          toastr(response.message, 'success', 'bottom');
          this.phoneModalInstance.hide()
          this.model.phone = ''
          this.model.otp_phone = ''
          this.token = ''
          this.data.profile.phone = response.phone
        } else {
          this.errors.phone = response.message;
        }
      });
    },
    
    // Submit new phone number
    changeEmail() {
      this.errors = {
        email: "",
      };

      // Check login using axios post
      postPageData("/profile/edit_account/changeEmail", {email: this.model.email, otp: this.model.otp_email})
      .then((response) => {
        if (response.success == 1) {
          toastr(response.message, 'success', 'bottom');
          this.emailModalInstance.hide()
          this.model.email = ''
          this.model.otp_email = ''
          this.token = ''
          this.data.profile.email = response.email
        } else {
          this.errors.email = response.message;
        }
      });
    },
  }
  
};
