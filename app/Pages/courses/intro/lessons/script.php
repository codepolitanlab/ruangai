<script>
    Alpine.data('listLesson', () => ({
        init() {
            // Make sure nested components can respond to lesson completion events
            window.addEventListener('ruangai:lesson-completed', (e) => {
                try {
                    if (e.detail && this.$root && this.$root.data && this.$root.data.course && String(this.$root.data.course.id) === String(e.detail.course_id)) {
                        // Invalidate cache and reload the parent $heroic data (lessons list)
                        $heroicHelper.cached[`/courses/intro/lessons/data/${e.detail.course_id}`] = null;
                        if (this.$root && typeof this.$root.loadPage === 'function') {
                            this.$root.loadPage(`/courses/intro/lessons/data/${e.detail.course_id}`);
                        }
                    }
                } catch (err) {
                    console.error('Error handling ruangai:lesson-completed in listLesson', err);
                }
            });
        },
        // Method untuk mengecek apakah semua lesson dalam topic sudah selesai
        isTopicCompleted(topicTitle, lessons) {
            const topicLessons = Object.values(lessons[topicTitle]);
            return topicLessons.every(lesson => lesson.is_completed);
        },

        isLessonCompleted(lessonID, lessonsCompleted) {
            const found = lessonsCompleted.find(item => item.id === lessonID);
            return found ? found.completed === true : false;
        },

        nextLesson(lessonsCompleted) {
            // Cari lesson mandatory yang belum completed
            const nextItem = lessonsCompleted.find(item => item.mandatory == 1 && item.completed === false);
            return nextItem ? nextItem.id : null;
        },

        // Method untuk mengecek apakah lesson bisa diakses
        canAccessLesson(lesson_id, lessonsCompleted) {
            const found = lessonsCompleted.find(item => item.id === lesson_id);
            
            // Lesson non-mandatory selalu bisa diakses
            if (found && found.mandatory != 1) {
                return true;
            }

            // Cek apakah lesson_id sudah di-complete
            if (found && found.completed === true) {
                return true;
            }

            // Cari lesson selanjutnya yang belum completed
            const next = this.nextLesson(lessonsCompleted);
            if (lesson_id === next) {
                return true;
            }

            return false;
        },

        countPercentageCompleteness(numCompleted, lessonsCompleted) {
            // Hitung hanya lesson mandatory
            const mandatoryCount = lessonsCompleted.filter(l => l.mandatory == 1).length;
            return mandatoryCount > 0 ? Math.round(numCompleted / mandatoryCount * 100) : 0;
        }
        ,
        async navigateToTargetLesson() {
            try {
                const courseId = this.$root?.data?.course?.id;
                if (!courseId) return;
                const res = await $heroicHelper.fetch(`/courses/intro/data/${courseId}`);
                const fresh = res.data;
                if (!fresh) {
                    this.$root?.$router?.navigate(`/courses/intro/${courseId}/${this.$root?.data?.course?.slug}/lessons`);
                    return;
                }
                const lessonsCompleted = fresh.lessonsCompleted || [];
                const nextItem = lessonsCompleted.find(item => !item.completed);
                if (nextItem) {
                    this.$root.$router.navigate(`/courses/${fresh.course.id}/lesson/${nextItem.id}`);
                    return;
                }
                if (fresh.last_progress_lesson_id) {
                    this.$root.$router.navigate(`/courses/${fresh.course.id}/lesson/${fresh.last_progress_lesson_id}`);
                    return;
                }
                if (fresh.course?.lessons && Object.keys(fresh.course.lessons).length > 0) {
                    const firstTopic = Object.keys(fresh.course.lessons)[0];
                    const firstItem = fresh.course.lessons[firstTopic][0];
                    if (firstItem) {
                        this.$root.$router.navigate(`/courses/${fresh.course.id}/lesson/${firstItem.id}`);
                        return;
                    }
                }
                this.$root.$router.navigate(`/courses/intro/${courseId}/${this.$root?.data?.course?.slug}/lessons`);
            } catch (err) {
                console.error('navigateToTargetLesson in listLesson error', err);
            }
        }
    }));
</script>