<script>
  Alpine.data("profile_edit_info", () => ({
    title: "Edit Info Profil",
    data: {
      profile: {},
    },
    model: {
      name: "",
      gender: "",
      birthday: "",
      occupation: "",
    },
    errors: {
      name: "",
      gender: "",
      birthday: "",
      occupation: "",
    },
    saving: false,

    init() {
      document.title = this.title;
      Alpine.store('core').currentPage = "profile";
      this.load();
    },

    load() {
      $heroicHelper.fetch('profile/edit_info/supply')
        .then((response) => {
          this.data = response.data || {};
          this.prepareModel();
        })
        .catch((error) => {
          console.error(error);
        });
    },

    prepareModel() {
      const p = this.data.profile || {};
      this.model.name = p.name || "";
      this.model.gender = p.gender || "";
      this.model.birthday = p.birthday || "";
      this.model.occupation = p.occupation || "";
    },

    save() {
      this.errors = { name: "", gender: "", birthday: "", occupation: "" };
      this.saving = true;

      $heroicHelper.post('/profile/edit_info', this.model)
        .then((response) => {
          const res = response.data || {};
          if (res.success == 1) {
            $heroicHelper.toastr(res.message || "Profil berhasil diperbarui.", "success", "bottom");
            this.prepareModel();
          } else if (res.errors) {
            Object.assign(this.errors, res.errors);
            $heroicHelper.toastr("Periksa kembali isian formulir.", "danger", "bottom");
          } else {
            $heroicHelper.toastr(res.message || "Gagal memperbarui profil.", "danger", "bottom");
          }
        })
        .catch((error) => {
          console.error(error);
          $heroicHelper.toastr("Terjadi kesalahan. Silakan coba lagi.", "danger", "bottom");
        })
        .finally(() => {
          this.saving = false;
        });
    },
  }));
</script>