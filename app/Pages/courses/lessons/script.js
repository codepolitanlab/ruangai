// Page Lessons
document.addEventListener("alpine:init", () => {
  Alpine.data("lesson_detail", (id) => ({
    title: "Detail Lessons Test Sample",
    ui: {
      loading: false,
      process: false,
    },
    data: {
      lesson: {},
      course: {},
    },
    init() {
      document.title = this.title;
      Alpine.store("core").currentPage = "courses";

      // Get cache if exists
      this.data = cachePageData[`courses/lessons/detail/${id}`] ?? {};
      if (Object.keys(this.data).length == 0) {
        fetchPageData(`courses/lessons/detail/${id}`)
        .then((response) => {
          if(response.status == 'success') {
            this.data.lesson = response.data.lesson;
            this.data.course = response.data.course;
            cachePageData[`courses/lessons/detail/${id}`] = response.data;
          } else {
            toastr(response.message, 'warning');
          }
        });
      }
    },
  }));
});
