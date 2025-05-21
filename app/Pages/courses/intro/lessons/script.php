<script>
    Alpine.data('listLesson', () => ({
        // Method untuk mengecek apakah semua lesson dalam topic sudah selesai
        isTopicCompleted(topicTitle, lessons) {
            const topicLessons = Object.values(lessons[topicTitle]);
            return topicLessons.every(lesson => lesson.is_completed);
        },

        // Method untuk mendapatkan index topic dari lesson
        getTopicIndex(lesson, lessons) {
            const topics = Object.keys(lessons);
            for (let i = 0; i < topics.length; i++) {
                const topicLessons = Object.values(lessons[topics[i]]);
                if (topicLessons.some(l => l.id === lesson.id)) {
                    return i;
                }
            }
            return -1;
        },

        // Method untuk mengecek apakah semua topic sebelumnya sudah selesai
        arePreviousTopicsCompleted(currentTopicIndex, lessons) {
            const topics = Object.keys(lessons);
            for (let i = 0; i < currentTopicIndex; i++) {
                if (!this.isTopicCompleted(topics[i], lessons)) {
                    return false;
                }
            }
            return true;
        },

        // Method untuk mengecek apakah lesson bisa diakses
        canAccessLesson(lesson, index, topicLessons, allLessons) {
            const currentTopicIndex = this.getTopicIndex(lesson, allLessons);
            
            // Jika ini topic pertama
            if (currentTopicIndex === 0) {
                // Jika ini lesson pertama di topic pertama
                if (index === 0) return true;
                
                // Untuk lesson lain di topic pertama, cek lesson sebelumnya
                const prevLesson = topicLessons[index - 1];
                return prevLesson.is_completed;
            }
            
            // Untuk topic selanjutnya, cek apakah semua topic sebelumnya sudah selesai
            if (!this.arePreviousTopicsCompleted(currentTopicIndex, allLessons)) {
                return false;
            }
            
            // Jika semua topic sebelumnya sudah selesai, cek lesson sebelumnya dalam topic ini
            if (index === 0) return true;
            const prevLesson = topicLessons[index - 1];
            return prevLesson.is_completed;
        }
    }));
</script>