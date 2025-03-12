// Page courses
document.addEventListener("alpine:init", () => {
  Alpine.data("courses", () => ({
    title: "Courses",
    data: {
      courses: [],
    },
    loading: false,
    process: false,

    init() {
      document.title = this.title;
      Alpine.store("core").currentPage = "courses";
    },
  }));
});
