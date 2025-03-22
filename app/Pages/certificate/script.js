// Page courses
document.addEventListener("alpine:init", () => {
  Alpine.data("certificate", () => ({
    title: "Certificate",
    data: {
      certificate: [],
    },
    loading: false,
    process: false,

    init() {
      document.title = this.title;
      Alpine.store("core").currentPage = "certificate";
    },
  }));
});
