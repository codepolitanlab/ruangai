<script>
  Alpine.data("courses", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/courses/data`,
      meta: {
        expandDesc: false,
        graduate: false,
        videoTeaser: null
      }
    })

    return {
      ...base,
      title: "courses",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
          // console.log('okok')
        });
      },

      setVideoTeaser(url) {
        this.meta.videoTeaser = url;
      }

    };
  });
</script>