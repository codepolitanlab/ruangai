<script>
  Alpine.data("certificate", function(id) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/certificate/data/${id}`,
      meta: {
        expandDesc: false,
        graduate: false
      }
    })

    return {
      ...base,
      title: "Certificate",
      errorMessage: null,

      init() {
        base.init.call(this);
        // this.$watch('data', (value) => {
        //     if (!value.is_enrolled) {
        //         alert("Kamu belum terdaftar di kelas. Silahkan daftar terlebih dahulu.")
        //         window.location.replace(`https://www.ruangai.id/registration`)
        //     }
        // });
      },

    };
  });
</script>
