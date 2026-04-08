<script>
  Alpine.data("courses", function() {
    let base = $heroic({
      title: `<?= $page_title ?>`,
      url: `/courses/data`,
      meta: {
        expandDesc: false,
        graduate: false,
        videoTeaser: null
      }
    })

    return {
      ...base,
      title: "courses",
      errorMessage: null,

      init() {
        base.init.call(this);
        this.$watch('data', (value) => {
          // console.log('okok')
        });
      },

      setVideoTeaser(url) {
        this.meta.videoTeaser = url;
      },

      async navigateToTargetLesson(course_id, slug) {
        try {
          const introRes = await $heroicHelper.fetch(`/courses/intro/data/${course_id}`);
          const introData = introRes.data;

          if (!introData || !introData.course) {
            this.$router.navigate(`/courses/intro/${course_id}/${slug}/lessons`);
            return;
          }

          let startLessonId = null;

          if (introData.last_progress_lesson_id) {
            startLessonId = introData.last_progress_lesson_id;
          } else {
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
            this.$router.navigate(`/courses/intro/${course_id}/${slug}/lessons`);
            return;
          }

          const lessonRes = await $heroicHelper.fetch(`/courses/lesson/data/${course_id}/${startLessonId}`);
          const lessonData = lessonRes.data;

          if (!lessonData || !lessonData.course || !lessonData.course.lessons) {
            this.$router.navigate(`/courses/${course_id}/lesson/${startLessonId}`);
            return;
          }

          const allLessons = lessonData.course.lessons;
          const nextLesson = allLessons.find(l => !l.is_completed);

          if (nextLesson) {
            this.$router.navigate(`/courses/${course_id}/lesson/${nextLesson.id}`);
            return;
          }

          const targetId = lessonData.course.last_progress_lesson_id || startLessonId;
          this.$router.navigate(`/courses/${course_id}/lesson/${targetId}`);

        } catch (err) {
          console.error('navigateToTargetLesson error', err);
          this.$router.navigate(`/courses/intro/${course_id}/${slug}/lessons`);
        }
      }

    };
  });
</script>