<script>
    Alpine.data('listLesson', () => ({
        setVideoTeaser(url) {
            this.meta.videoTeaser = url;
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
    }));
</script>