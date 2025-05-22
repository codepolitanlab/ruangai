<script>
Alpine.data("lesson", function () {
  return {
    title: "Lesson",
    showButtonPaham: false,
    waitToShowButtonPaham: 1000 * 30,
    errorMessage: null,
    buttonSubmitting: false,
    sanboxLogin: {},

    async init() {
      // Show button saya sudah paham setelah n detik
      setTimeout(() => this.showButtonPaham = true, this.waitToShowButtonPaham)
    },

    markAsComplete(lessonId, nextLessonId) {
      console.log(lessonId);
      // With form data
      const formData = new FormData();
      formData.append("lesson_id", lessonId);
      axios
        .post("/courses/lesson/", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
            "Authorization": localStorage.getItem("heroic_token"),
          },
        })
        .then((response) => {
          if (response.data.status == "success") {
            alert(response.data.message);
            if (!nextLessonId) {
              let courseId = response.data.course.course_id;
              let courseSlug = response.data.course.course_slug;
              window.location.replace("/courses/intro/" + courseId + "/" + courseSlug + "/lessons");
            } else {
              window.location.replace("/courses/lesson/" + nextLessonId);
            }
          } else {
            alert(response.data.message);
          }
        });
    },

  };
});
</script>