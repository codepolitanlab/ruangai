<script>
  Alpine.data("scholarship", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/scholarship/data`,
      meta: {
        expandDesc: false,
        graduate: false,
        videoTeaser: null
      }
    })

    return {
      ...base,
      title: "scholarship",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
          console.log('okok')
        });
      },
    };
  });
</script>