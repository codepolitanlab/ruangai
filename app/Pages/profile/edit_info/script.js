// Page component
window.profile_edit_info = function () {
  return {
    title: "Edit Info Profil",
    showPwd: false,
    data: {
      profile: {},
    },
    model: {
      name: "",
      short_description: "",
      gender: "",
      birthday: "",
      status_marital: "",
      jobs: "",
    },
    errors: {
      name: "",
      short_description: "",
      gender: "",
      birthday: "",
      status_marital: "",
      jobs: "",
    },

    init() {
      document.title = this.title;
      Alpine.store("masagi").currentPage = "profile";

      if (cachePageData["profile"]) {
        this.data = cachePageData["profile"];
        this.prepareModel();
      } else {
        fetchPageData("profile/supply", {
          headers: {
            Authorization: `Bearer ` + Alpine.store("masagi").sessionToken,
          },
        }).then((data) => {
          this.data = data;
          cachePageData["profile"] = this.data;
          this.prepareModel();
        });
      }
    },

    prepareModel() {
        // Prepare data model
        this.model.name = this.data.profile.name;
        this.model.short_description = this.data.profile.short_description;
        this.model.gender = 'l';
        this.model.birthday = this.data.profile.birthday;
        this.model.status_marital = this.data.profile.status_marital;
        this.model.jobs = this.data.profile.jobs;
    },

    save() {
      this.errors = {
        name: "",
        short_description: "",
        gender: "",
        birthday: "",
        status_marital: "",
        jobs: "",
      };

      // Check login using axios post
      postPageData("/profile/edit_info", this.model)
      .then((response) => {
        if (response.success == 1) {
          toastr('Data info berhasil diperbaharui', 'success', 'bottom');
        } else {
          this.errors = response.errors;
        }
      });
    },
  };
};
