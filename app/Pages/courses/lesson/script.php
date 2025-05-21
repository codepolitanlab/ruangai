<script>
Alpine.data("lesson", function () {
  return {
    title: "Lesson",
    showPwd: false,
    errorMessage: null,
    buttonSubmitting: false,
    sanboxLogin: {},

    async init() {
      console.log('init');
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

    login() {
      this.errorMessage = "";
      this.buttonSubmitting = true;

      // Check login using axios post
      const formData = new FormData();
      formData.append("username", this.data.username);
      formData.append("password", this.data.password);
      axios
        .post("/login", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.found == 1) {
            localStorage.setItem("heroic_token", response.data.jwt);
            Alpine.store('core').sessionToken = localStorage.getItem("heroic_token");

            setTimeout(() => {
              window.location.replace("/");
            }, 500);
          } else {
            this.buttonSubmitting = false;
            this.errorMessage = "Password tidak cocok atau akun belum terdaftar";
            setTimeout(() => (this.errorMessage = ""), 10000);
          }
        });
    },

  };
});
</script>