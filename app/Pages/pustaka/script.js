// Page pustaka
document.addEventListener("alpine:init", () => {
  Alpine.data("pustaka", () => ({
    title: "Pustaka",
    data: {
      pustaka: [],
    },
    loading: false,
    process: false,

    init() {
      document.title = this.title;
      Alpine.store("core").currentPage = "pustaka";
    },
  }));
});
