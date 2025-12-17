<script>
  Alpine.data("courseIntro", function(course_id) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/courses/intro/data/${course_id}`,
      meta: {
        expandDesc: false,
        graduate: false,
        isValidEmail: false,
        videoTeaser: null
      }
    })

    return {
      ...base,
      title: "course intro",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
          // if (!value.is_enrolled) {
          //   alert("Kamu belum terdaftar di kelas. Silahkan daftar terlebih dahulu.")
          //   window.location.replace(`https://www.ruangai.id/registration`)
          // }
        });

        const token = localStorage.getItem('heroic_token');
        if (token) {
          try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            this.meta.isValidEmail = +payload.isValidEmail === 1 ? true : false;
          } catch (e) {
            console.error("Failed to parse JWT payload", e);
          }

          // Listen to global dispatched event so that when a lesson is completed elsewhere
          // we refresh the intro's data (so getTargetLessonId will return updated next)
          window.addEventListener('ruangai:lesson-completed', (e) => {
            try {
              if (e.detail && String(e.detail.course_id) === String(course_id)) {
                // Invalidate caches and refetch
                $heroicHelper.cached[`/courses/intro/lessons/data/${course_id}`] = null;
                $heroicHelper.cached[`/courses/intro/data/${course_id}`] = null;
                this.loadPage(`/courses/intro/data/${course_id}`);
              }
            } catch (err) {
              console.error('Error handling ruangai:lesson-completed', err);
            }
          });
        }
      },

      async navigateToTargetLesson() {
        try {
          // First, get intro data to find starting lesson
          const introRes = await $heroicHelper.fetch(`/courses/intro/data/${course_id}`);
          const introData = introRes.data;
          
          if (!introData || !introData.course) {
            const slug = this.data.course?.slug || '';
            this.$router.navigate(`/courses/intro/${course_id}/${slug}/lessons`);
            return;
          }

          // Determine starting lesson: last_progress or first lesson
          let startLessonId = null;
          
          if (introData.last_progress_lesson_id) {
            startLessonId = introData.last_progress_lesson_id;
          } else {
            // Get first lesson from grouped structure
            const lessons = introData.course?.lessons;
            if (lessons && typeof lessons === 'object') {
              for (const topic in lessons) {
                if (Array.isArray(lessons[topic]) && lessons[topic].length > 0) {
                  startLessonId = lessons[topic][0].id;
                  break;
                }
              }
            }
          }

          if (!startLessonId) {
            const slug = introData.course?.slug || '';
            this.$router.navigate(`/courses/intro/${course_id}/${slug}/lessons`);
            return;
          }

          // Fetch lesson detail to get complete lesson structure with is_completed flags
          const lessonRes = await $heroicHelper.fetch(`/courses/lesson/data/${course_id}/${startLessonId}`);
          const lessonData = lessonRes.data;

          if (!lessonData || !lessonData.course || !lessonData.course.lessons) {
            // Fallback: just navigate to the starting lesson
            this.$router.navigate(`/courses/${course_id}/lesson/${startLessonId}`);
            return;
          }

          // Find next uncompleted lesson from lesson data structure
          const allLessons = lessonData.course.lessons;
          const nextLesson = allLessons.find(l => !l.is_completed);
          
          if (nextLesson) {
            this.$router.navigate(`/courses/${course_id}/lesson/${nextLesson.id}`);
            return;
          }

          // If all completed, use last_progress or first lesson
          const targetId = lessonData.course.last_progress_lesson_id || startLessonId;
          this.$router.navigate(`/courses/${course_id}/lesson/${targetId}`);

        } catch (err) {
          console.error('navigateToTargetLesson error', err);
          const slug = this.data.course?.slug || '';
          this.$router.navigate(`/courses/intro/${course_id}/${slug}/lessons`);
        }
      },

      claimCertificate() {
        if (!this.meta.isValidEmail) {
          $heroicHelper.toastr("Kamu belum melakukan verifikasi email nih, silahkan lakukan verifikasi email terlebih dahulu untuk klaim sertifikat.", "warning", "bottom");
          return
        }

        if (this.data.course_completed) {
          if (!this.data.certificate_id) {
            this.$router.navigate(`/courses/claim_certificate/${this.data.course.id}`)
          } else {
            window.location.href = `/certificate`;
          }
        } else {
          $heroicHelper.toastr("Kamu belum menyelesaikan kelas ini. Silahkan selesaikan kelas terlebih dahulu.", "warning", "bottom");
        }
      },

      claimReward() {
        this.$router.navigate(`/courses/reward`)
      },

      heregister() {
        $heroicHelper.post(`/courses/intro/heregister`, {
          course_id: this.data.course.id
        }).then((response) => {
          if (response.data.response_code == 200) {
            $heroicHelper.toastr("Anda telah terdaftar di program Chapter 3! Selamat melanjukan belajar.", 'success', 'bottom')
            this.data.is_expire = false
          }
        })
      },

      setVideoTeaser(url) {
        this.meta.videoTeaser = url;
      },

      // Find next uncompleted lesson id from lessonsCompleted
      nextLessonFromCompleted(lessonsCompleted) {
        if (!lessonsCompleted || !Array.isArray(lessonsCompleted)) return null;
        // Use !item.completed to handle boolean/0/'0'/false robustly
        const nextItem = lessonsCompleted.find(item => !item.completed);
        return nextItem ? nextItem.id : null;
      },

      // Get first lesson id from grouped course lessons
      getFirstLessonId() {
        try {
          if (!this.data.course || !this.data.course.lessons) return null;
          const topics = Object.keys(this.data.course.lessons);
          if (topics.length === 0) return null;
          const firstTopic = topics[0];
          const firstLessons = this.data.course.lessons[firstTopic];
          if (!firstLessons || !firstLessons.length) return null;
          return firstLessons[0].id;
        } catch (e) {
          return null;
        }
      },

      // Compute target lesson id: prefer next uncompleted, else last progress (if any), else first lesson
      getTargetLessonId() {
        const next = this.nextLessonFromCompleted(this.data.lessonsCompleted || []);
        if (next) return next;
        if (this.data.last_progress_lesson_id) return this.data.last_progress_lesson_id;
        return this.getFirstLessonId();
      }
    };
  });
</script>