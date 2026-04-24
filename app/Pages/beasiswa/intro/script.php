<script>
  Alpine.data("beasiswaIntro", function(course_id = 1) {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/beasiswa/intro/data`,
      meta: {
        course_id: 1,
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
      registeringLiveSession: false,
      countdown: {
        days: '00',
        hours: '00',
        minutes: '00',
        seconds: '00'
      },
      countdownInterval: null,
      hasCountdownExpired: false,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
          // Check if course is scholarship course (id = 1) and user doesn't have scholarship
          if (value && value.has_scholarship === false) {
            window.location.replace('/scholarship');
          }

          this.syncCountdown(value);
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
                $heroicHelper.cached[`/beasiswa/intro/lessons/data/${meta.course_id}`] = null;
                $heroicHelper.cached[`/beasiswa/intro/data/${meta.course_id}`] = null;
                this.loadPage(`/beasiswa/intro/data/${meta.course_id}`);
              }
            } catch (err) {
              console.error('Error handling ruangai:lesson-completed', err);
            }
          });
        }

        this.$nextTick(() => {
          this.syncCountdown(this.data);
        });
      },

      shouldShowCountdown(source = this.data) {
        return !!(
          source?.is_enrolled &&
          !source?.is_expire &&
          source?.student?.countdown_end_at &&
          Number(source?.student?.graduate || 0) !== 1
        );
      },

      syncCountdown(value) {
        if (!value || !this.shouldShowCountdown(value)) {
          this.resetCountdown();
          return;
        }

        this.hasCountdownExpired = false;
        this.updateCountdown(value);

        if (this.countdownInterval) {
          clearInterval(this.countdownInterval);
        }

        this.countdownInterval = setInterval(() => {
          this.updateCountdown();
        }, 1000);
      },

      updateCountdown(source = this.data) {
        const deadline = source?.student?.countdown_end_at;

        if (!deadline) {
          this.resetCountdown();
          return;
        }

        const targetTime = new Date(deadline.replace(' ', 'T') + '+07:00').getTime();
        const now = new Date().getTime();
        const distance = targetTime - now;

        if (distance <= 0) {
          this.countdown.days = '00';
          this.countdown.hours = '00';
          this.countdown.minutes = '00';
          this.countdown.seconds = '00';

          if (!this.hasCountdownExpired) {
            this.hasCountdownExpired = true;
            this.loadPage('/beasiswa/intro/data');
          }
          return;
        }

        this.countdown.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
        this.countdown.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
        this.countdown.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
        this.countdown.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
      },

      resetCountdown() {
        if (this.countdownInterval) {
          clearInterval(this.countdownInterval);
          this.countdownInterval = null;
        }

        this.countdown.days = '00';
        this.countdown.hours = '00';
        this.countdown.minutes = '00';
        this.countdown.seconds = '00';
      },

      formatCountdownStart() {
        const start = this.data?.student?.countdown_start_at;
        if (!start) {
          return '-';
        }

        return new Intl.DateTimeFormat('id-ID', {
          day: '2-digit',
          month: 'long',
          year: 'numeric',
          timeZone: 'Asia/Jakarta'
        }).format(new Date(start.replace(' ', 'T') + '+07:00'));
      },

      formatCountdownDeadline() {
        const deadline = this.data?.student?.countdown_end_at;
        if (!deadline) {
          return '-';
        }

        return new Intl.DateTimeFormat('id-ID', {
          day: '2-digit',
          month: 'long',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          hour12: false,
          timeZone: 'Asia/Jakarta'
        }).format(new Date(deadline.replace(' ', 'T') + '+07:00')) + ' WIB';
      },

      claimCertificate() {
        if (!this.meta.isValidEmail) {
          $heroicHelper.toastr("Kamu belum melakukan verifikasi email nih, silahkan lakukan verifikasi email terlebih dahulu untuk klaim sertifikat.", "warning", "bottom");
          return
        }

        if (this.data.course_completed) {
          if (!this.data.certificate_id) {
            this.$router.navigate(`/beasiswa/claim_certificate/${this.data.course.id}`)
          } else {
            window.location.href = `/certificate`;
          }
        } else {
          $heroicHelper.toastr("Kamu belum menyelesaikan kelas ini. Silahkan selesaikan kelas terlebih dahulu.", "warning", "bottom");
        }
      },

      claimReward() {
        this.$router.navigate(`/beasiswa/reward`)
      },

      heregister() {
        $heroicHelper.post(`/beasiswa/intro/heregister`, {
          course_id: this.data.course.id
        }).then((response) => {
          if (response.data.response_code == 200) {
            $heroicHelper.toastr("Anda telah terdaftar di program Chapter 3! Selamat melanjukan belajar.", 'success', 'bottom')
            this.data.is_expire = false
          }
        })
      },

      async registerLiveSession() {
        if (this.registeringLiveSession) return;

        if (!this.data.next_live_session || !this.data.next_live_session.meeting_code) {
          return;
        }

        if (!this.data.pdf_read) {
          $heroicHelper.toastr('Silakan selesaikan modul PDF terlebih dahulu sebelum mendaftar webinar.', 'warning', 'bottom');
          return;
        }

        this.registeringLiveSession = true;
        const token = localStorage.getItem('heroic_token');

        axios.post('/beasiswa/zoom/register',
          {
            meeting_code: this.data.next_live_session.meeting_code
          },
          {
            headers: {
              Authorization: `${token}`
            }
          }
        )
        .then((response) => {
          if (response.data.status === 'success') {
            this.data.next_live_session.is_registered = true;
            this.data.next_live_session.zoom_join_link =
              response.data.zoom_join_link || this.data.next_live_session.zoom_join_link;

            $heroicHelper.toastr(
              'Berhasil daftar webinar. Link Zoom telah disiapkan.',
              'success',
              'bottom'
            );
          } else {
            $heroicHelper.toastr(
              response.data.message || 'Gagal mendaftar webinar.',
              'error',
              'bottom'
            );
          }
        })
        .catch((err) => {
          console.error(err);
          $heroicHelper.toastr(
            'Gagal mendaftar webinar, silakan coba lagi.',
            'error',
            'bottom'
          );
        })
        .finally(() => {
          this.registeringLiveSession = false;
        });
      },

      setVideoTeaser(url) {
        this.meta.videoTeaser = url;
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

      navigateToPdf() {
        this.$router.navigate('/beasiswa/intro/pdf_viewer/');
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