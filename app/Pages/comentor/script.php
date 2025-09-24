<script>
  Alpine.data("comentor", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/comentor/data/`,
      meta: {
        expandDesc: false,
        graduate: false,
        email: '',
        isValidEmail: false,
        loading: false,
        videoTutorial: null
      }
    })

    return {
      ...base,
      title: "Co-Mentor",
      errorMessage: null,
      search: "",          // keyword pencarian
      filteredMembers: [], // hasil filter

      init() {
        base.init.call(this);

        // awalnya tampilkan semua data
        this.$watch("data", (val) => {
          if (val?.members) {
            console.log(val.members)
            this.filteredMembers = val.members;
          }
        });

        // auto filter saat ketik
        this.$watch("search", (val) => {
          this.filterMembers(val);
        });
        console.log(this.filteredMembers)
      },

      filterMembers(keyword) {
        if (!keyword) {
          this.filteredMembers = this.data?.members ?? [];
        } else {
          let lower = keyword.toLowerCase();
          this.filteredMembers = this.data?.members?.filter(m =>
            m.fullname.toLowerCase().includes(lower) ||
            m.email.toLowerCase().includes(lower) ||
            (m.whatsapp || "").toLowerCase().includes(lower)
          ) ?? [];
        }
      },

      copyToClipboard(text) {
        navigator.clipboard.writeText(`https://ruangai.id/cmref/${text}`);
        $heroicHelper.toastr("Link referral berhasil disalin ke clipboard", "success");
      }
    };
  });
</script>
