<!-- Tambahkan JSZip dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- Tambahkan FileSaver.js dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
  Alpine.data("certificate", function(code) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/certificate/data/${code}`,
    })

    return {
      ...base,
      title: "Certificate",
      errorMessage: null,

      data: {
        comment: "",
        rating: null,
      },

      init() {
        base.init.call(this);
      },

      async submitFeedback() {

<<<<<<< HEAD
        if (!this.data.comment || !this.data.rating) {
=======
        if(!this.data.comment || !this.data.rating) {
>>>>>>> 4990ba3e (Generate certificate)
          await Prompts.alert("Silahkan isi komentar dan rating terlebih dahulu.");
          return
        }
        $heroicHelper.post(`/certificate/feedback`, {
            comment: this.data.comment,
            rating: this.data.rating,
            name: this.data.student.name,
          })
          .then(async (response) => {
            if (response.data.status == 'success') {
              await Prompts.alert("Feedback berhasil dikirim.")
              window.location.reload()
            }
          })
          .catch(async (error) => {
            await Prompts.alert("Terjadi kesalahan saat mengirim feedback.")
          });
      },

      async downloadImagesAsZip() {
        const zip = new JSZip();
        const folder = zip.folder("sertifikat"); // buat folder dalam ZIP

        const imageUrls = [
          {
            'filepath': this.data.student.cert_url[1],
            'filename': 'id.jpg'
          },
          {
            'filepath': this.data.student.cert_url[2],
            'filename': 'en.jpg'
          },
          {
            'filepath': this.data.student.cert_url[3],
            'filename': 'transcript.jpg'
          },
        ];

        for (let i = 0; i < imageUrls.length; i++) {
          const url = imageUrls[i].filepath;
          const filename = imageUrls[i].filename;

          try {
            const response = await fetch(url);
            const blob = await response.blob();

            folder.file(filename, blob);
          } catch (err) {
            console.error(`Gagal mengunduh ${url}:`, err);
          }
        }

        const zipBlob = await zip.generateAsync({
          type: "blob"
        });
        saveAs(zipBlob, "sertifikat.zip");
      }

    };
  });
</script>