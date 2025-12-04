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
            if (!lessonsCompleted || lessonsCompleted.length === 0) return null;
            
            const lastProgressId = this.$root?.data?.last_progress_lesson_id;
            
            // If we have last progress, find next uncompleted after that progress
            if (lastProgressId) {
                const lastProgressIndex = lessonsCompleted.findIndex(item => item.id == lastProgressId);
                if (lastProgressIndex !== -1) {
                    // Look for next uncompleted lesson from last progress onwards
                    for (let i = lastProgressIndex; i < lessonsCompleted.length; i++) {
                        if (!lessonsCompleted[i].completed) {
                            return lessonsCompleted[i].id;
                        }
                    }
                }
            }
            
            // Fallback: return first uncompleted lesson
            const nextItem = lessonsCompleted.find(item => !item.completed);
            return nextItem ? nextItem.id : null;
        },

        // Method untuk mengecek apakah lesson bisa diakses
        canAccessLesson(lesson_id, lessonsCompleted) {
            // Cek apakah lesson_id sudah di-complete
            const found = lessonsCompleted.find(item => item.id === lesson_id);
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
            return Math.round(numCompleted / Object.keys(lessonsCompleted).length * 100);
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