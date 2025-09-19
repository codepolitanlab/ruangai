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
      title: "Homepage",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.initSwiperNotif();

      },
    };
  });
</script>