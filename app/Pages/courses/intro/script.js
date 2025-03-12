// Page courses
document.addEventListener("alpine:init", () => {
  Alpine.data("course_intro", (id, slug) => ({
    title: "Courses",
    ui: {
      loading: false,
      process: false,
    },
    data: {
      course: {},
    },

    init() {
      document.title = this.title;
      Alpine.store("core").currentPage = "courses";

      // Get cache if exists
      this.data.course = cachePageData[`courses/intro/course/${id}`] ?? {};
      if (Object.keys(this.data.course).length == 0) {
        fetchPageData(`courses/intro/course/${id}`)
        .then((response) => {
          if(response.status == 'success') {
            this.data.course = response.data.course;
            cachePageData[`courses/intro/course/${id}`] = response.data.course;
          } else {
            toastr(response.message, 'warning');
          }
        });
      }
    },
  }));
});
