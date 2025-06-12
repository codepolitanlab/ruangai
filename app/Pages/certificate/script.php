<script>
  Alpine.data("certificate", function(id) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/certificate/data/${id}`,

      data: {
        comment: "",
        rating: null,
      },
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
      },

      submitFeedback() {

        if(!this.data.comment || !this.data.rating) {
          alert("Silahkan isi komentar dan rating terlebih dahulu.")
          return
        }
        $heroicHelper.post(`/certificate/feedback`, {
            comment: this.data.comment,
            rating: this.data.rating,
          })
          .then((response) => {
            if (response.data.status == 'success') {
              alert("Feedback berhasil dikirim.")
              window.location.reload()
            }
          })
          .catch((error) => {
            alert("Terjadi kesalahan saat mengirim feedback.")
          });
      }

    };
  });
</script>