<script>
  Alpine.data("lesson", function() {
    return {
      title: "Lesson",
      showButtonPaham: false,
      waitToShowButtonPaham: 1000 * 3,
      errorMessage: null,
      buttonSubmitting: false,

      currentQuestion: 0,

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
              $heroicHelper.toastr(response.data.message, "success");
              if (!nextLessonId) {
                let courseId = response.data.course.course_id;
                let courseSlug = response.data.course.course_slug;
                setTimeout(() => {
                  window.location.replace("/courses/intro/" + courseId + "/" + courseSlug + "/lessons");
                }, 3000)
              } else {
                setTimeout(() => {
                  window.location.replace("/courses/lesson/" + nextLessonId);
                }, 3000)
              }
            } else {
              setTimeout(() => {
                $heroicHelper.toastr(response.data.message, "danger");
              }, 3000)
            }
          });
      },

    };
  });

  Alpine.data('lesson_quiz', function(parentQuizzes) {
    return {
      quizzes: parentQuizzes,
      quizKeys: [],
      currentIndex: 0,
      answers: {},

      init() {
        this.quizKeys = Object.keys(this.quizzes);
      },

      get currentKey() {
        return this.quizKeys[this.currentIndex];
      },
      get currentQuiz() {
        return this.quizzes[this.currentKey];
      },
      nextQuiz() {
        if (this.currentIndex < this.quizKeys.length - 1) this.currentIndex++;
      },
      prevQuiz() {
        if (this.currentIndex > 0) this.currentIndex--;
      },
      goTo(index) {
        this.currentIndex = index;
      },
      storeAnswer(key, value) {
        this.answers[key] = value;
      }
    }
  })
</script>