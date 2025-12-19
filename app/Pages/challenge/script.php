<script>
  Alpine.data("challenge", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/challenge/data/`,
    })

    return {
      ...base,
      title: "Challenge",

      init() {
        base.init.call(this);
      },

      handleUnverifiedClick(event) {
        event.preventDefault();
        $heroicHelper.toastr('Silakan verifikasi email Anda terlebih dahulu', 'warning', 'bottom');
      }
    };
  });
</script>
