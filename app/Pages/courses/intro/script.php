<script>
  Alpine.data("courseIntro", function(course_id) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/courses/intro/data/${course_id}`,
      meta: {
        expandDesc: false,
        graduate: false
      }
    })

    return {
      ...base,
      title: "course intro",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
            if (!value.is_enrolled) {
                alert("Kamu belum terdaftar di kelas. Silahkan daftar terlebih dahulu.")
                window.location.replace(`https://www.ruangai.id/registration`)
            }
        });
      },

    };
  });
</script>