<script>
  Alpine.data("lesson_detail_script", function(course_id, lesson_id, waitToShowButtonPaham = 30000) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `courses/lesson/data/${course_id}/${lesson_id}`
    });

    return {
      ...base,

      title: "Lesson",
      showButtonPaham: false,
      waitToShowButtonPaham: waitToShowButtonPaham,
      errorMessage: null,
      buttonSubmitting: false,
      selectedServer: null,

      currentQuestion: 0,

      init() {
        base.init.call(this);

        // Show button saya sudah paham setelah n detik
        this.setTimerButtonPaham();
      },

      setNativeLinks(selector = '#lesson_text_container') {
        const container = document.querySelector(selector);
        if (container) {
          const links = container.querySelectorAll('a');
          links.forEach(link => {
            link.setAttribute('native', '');
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
          });
        }
      },

      setTimerButtonPaham() {
        this.showButtonPaham = false;
        setTimeout(() => this.showButtonPaham = true, this.waitToShowButtonPaham)
      },

      getVideoUrl(type, video_id) {
        if (type == 'diupload') {
          return `https://diupload.com/embed/${video_id}`;
        } else if (type == 'bunny') {
          return `https://iframe.mediadelivery.net/embed/431005/${video_id}?autoplay=true`;
        }
      },

      switchServerVideo(server) {
        this.selectedServer = server;
        console.log(this.selectedServer);
      },

      markAsComplete(course_id, lesson_id, next_lesson_id) {
        if (!this.showButtonPaham) {
          $heroicHelper.toastr(
            `Tunggu dulu sampai tombol "Saya Sudah Paham" muncul.`,
            "warning",
            "bottom"
          );
          return;
        }

        this.buttonSubmitting = true;
        $heroicHelper
          .post(`/courses/lesson`, {
            course_id: course_id,
            lesson_id: lesson_id
          })
          .then((response) => {
            if (response.data.status == "success") {
              $heroicHelper.toastr(response.data.message, "success", 'bottom');
              // unset cache lesson list
              $heroicHelper.cached[`/courses/intro/lessons/data/${course_id}`] = null;
              if (!next_lesson_id) {
                let courseId = response.data.course.course_id;
                let courseSlug = response.data.course.course_slug;
                setTimeout(() => {
                  this.buttonSubmitting = false;
                  this.$router.navigate(`/courses/intro/${courseId}/${courseSlug}/lessons`);
                }, 3000)
              } else {
                setTimeout(() => {
                  this.buttonSubmitting = false;
                  this.$router.navigate(`/courses/${course_id}/lesson/${next_lesson_id}`);
                }, 3000)
              }
            } else {
              setTimeout(() => {
                this.buttonSubmitting = false;
                $heroicHelper.toastr(response.data.message, "danger");
              }, 3000)
            }
          });
      },

    };
  });

  Alpine.data('lesson_quiz', function(parentQuizzes, course_id, lesson_id) {
    return {
      quizzes: parentQuizzes,
      course_id,
      lesson_id,
      quizKeys: [],
      currentIndex: 0,
      answers: {},
      startQuiz: false,
      finishQuiz: false,
      result: {},

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
      },
      submitQuiz() {
        this.finishQuiz = true;
        let url = `/courses/lesson/quiz`;
        $heroicHelper.post(url, {
            answers: this.answers,
            course_id: this.course_id,
            lesson_id: this.lesson_id
          })
          .then((response) => {
            console.log(response)
            if (response.status == 200) {
              this.result = response.data;

              // Show confetti
              if (this.result.is_pass) {
                confetti({
                  particleCount: 150
                });
              }
            } else {
              $heroicHelper.toastr(response.data.message, "danger");
            }
          });
      },
      tryAgain() {
        this.finishQuiz = false;
        this.currentIndex = 0;
        this.answers = {};
        this.result = {};
        this.startQuiz = false;
      },
    }
  })
</script>