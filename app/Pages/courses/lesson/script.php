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
      sidebarVisible: true,

      currentQuestion: 0,

      init() {
        base.init.call(this);

        this.$watch('data', (value) => {
          // Check access
          if (value.response_code == 405) {
            if(alert) alert(value.response_message);
            this.$router.navigate(`/`);
          }
        });

        // Show button saya sudah paham setelah n detik
        this.setTimerButtonPaham();

        // Listen to global lesson completed events to update local course data without full reload
        window.addEventListener('ruangai:lesson-completed', (e) => {
          try {
            if (e.detail && this.data && this.data.lesson && String(this.data.lesson.course_id) === String(e.detail.course_id)) {
              // mark lesson in course.lessons as completed
              if (this.data.course && Array.isArray(this.data.course.lessons)) {
                const idx = this.data.course.lessons.findIndex(l => String(l.id) === String(e.detail.lesson_id));
                if (idx !== -1) {
                  this.data.course.lessons[idx].is_completed = true;
                }
              }
              // if lessons_grouped present, update that too
              if (this.data.course && this.data.course.lessons_grouped) {
                for (let topic in this.data.course.lessons_grouped) {
                  this.data.course.lessons_grouped[topic].forEach(l => {
                    if (String(l.id) === String(e.detail.lesson_id)) l.is_completed = true;
                  });
                }
              }
              // Update last_progress_lesson_id to the most recent completed lesson
              if (this.data.course) {
                this.data.course.last_progress_lesson_id = e.detail.lesson_id;
              }
            }
          } catch (err) {
            console.error('Error handling ruangai:lesson-completed in lesson_detail', err);
          }
        });
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

      getNextLessonIdFromCourse() {
        if (!this.data.course || !this.data.course.lessons) return null;
        
        const lastProgressId = this.data.course.last_progress_lesson_id;
        
        // If we have last progress, find the next uncompleted lesson AFTER that progress
        if (lastProgressId) {
          const lastProgressIndex = this.data.course.lessons.findIndex(l => l.id == lastProgressId);
          if (lastProgressIndex !== -1) {
            // Look for the next uncompleted lesson starting from last progress
            for (let i = lastProgressIndex; i < this.data.course.lessons.length; i++) {
              if (!this.data.course.lessons[i].is_completed) {
                return this.data.course.lessons[i].id;
              }
            }
          }
        }
        
        // Fallback: find first uncompleted lesson
        const nextLesson = this.data.course.lessons.find(l => !l.is_completed);
        return nextLesson ? nextLesson.id : null;
      },

      canAccessLessonById(lessonId) {
        if (!this.data.course || !this.data.course.lessons) return false;
        // If lesson is completed -> accessible
        const found = this.data.course.lessons.find(l => l.id === lessonId);
        if (!found) return false;
        if (found.is_completed) return true;
        // If it's the next uncompleted lesson, allow access
        const nextId = this.getNextLessonIdFromCourse();
        if (lessonId === nextId) return true;
        // If lesson is free allow access
        if (found.free && +found.free === 1) return true;
        return false;
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
                // Also invalidate intro page data so getTargetLessonId will use updated progress
                $heroicHelper.cached[`/courses/intro/data/${course_id}`] = null;
                // Dispatch a global event to inform other components (intro pages) to refresh/update
                try {
                  window.dispatchEvent(new CustomEvent('ruangai:lesson-completed', { detail: { course_id: course_id, lesson_id: lesson_id, next_lesson_id: next_lesson_id } }));
                } catch (e) {
                  // ignore if dispatch fails
                  console.error('Failed to dispatch event', e);
                }
                // Also fetch the updated intro data and update local / cached values to reduce race condition
                try {
                  $heroicHelper.fetch(`/courses/intro/data/${course_id}`)
                    .then((r) => {
                      if (r && r.data) $heroicHelper.setCache(`/courses/intro/data/${course_id}`, r.data);
                    })
                    .catch((e) => console.error('Failed to prefetch intro data after progress', e));
                } catch (e) {
                  console.error('prefetch intro data error', e);
                }
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
        try {
          this.quizKeys = this.quizzes && typeof this.quizzes === 'object' ? Object.keys(this.quizzes) : [];
        } catch (e) {
          this.quizKeys = [];
        }
        // If quizzes come later (when data loads), watch and update keys
        this.$watch('quizzes', (value) => {
          try {
            this.quizKeys = value && typeof value === 'object' ? Object.keys(value) : [];
            this.currentIndex = 0;
          } catch (err) {
            this.quizKeys = [];
          }
        });
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