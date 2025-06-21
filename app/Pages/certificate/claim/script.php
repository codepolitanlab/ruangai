<script>
  Alpine.data("certificate_claim", function(course_id) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/certificate/claim/data/${course_id}`,
      meta: {
        course_id: course_id
      }
    })

    return {
      ...base,
      title: "Claim Certificate",
      errorMessage: null,
      submitting: false,

      data: {
        comment: "",
        rating: null,
      },

      init() {
        base.init.call(this);

        if (this.data?.student?.cert_code) {
          this.$router.navigate(`/certificate/${this.data.student.cert_code}`);
        }

        // Pantau fetch selesai (asumsinya base.getUrl memanggil fetch otomatis)
        this.$watch('data', (newData) => {
          if (newData?.student?.cert_code) {
            this.$router.navigate(`/certificate/${newData.student.cert_code}`);
          }
        });
      },

      async submitFeedback() {

        if (!this.data.comment || !this.data.rating) {
          await Prompts.alert("Silahkan isi komentar dan rating terlebih dahulu.");
          return
        }

        this.submitting = true;
        $heroicHelper.post(`/certificate/claim`, {
            course_id: this.meta.course_id,
            comment: this.data.comment,
            rating: this.data.rating,
            name: this.data.student.name,
          })
          .then(async (response) => {
            if (response.data.status == 'success') {
              await Prompts.alert("Feedback berhasil dikirim.")
              this.$router.navigate(`/certificate/${response.data.data.code}`)
            }
          })
          .catch(async (error) => {
            await Prompts.alert("Terjadi kesalahan saat mengirim feedback.")
            this.submitting = false;
          });
      }

    };
  });
</script>