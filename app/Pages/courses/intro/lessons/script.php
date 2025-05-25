<script>
    Alpine.data('listLesson', () => ({
        // Method untuk mengecek apakah semua lesson dalam topic sudah selesai
        isTopicCompleted(topicTitle, lessons) {
            const topicLessons = Object.values(lessons[topicTitle]);
            return topicLessons.every(lesson => lesson.is_completed);
        },

        nextLesson(lessonsCompleted) {
            // Step 1: Konversi key ke array number dan urutkan
            let keys = Object.keys(lessonsCompleted);

            // Step 2: Cari lesson complete terakhir
            let nextID = null;
            for (let id of keys) {
                nextID = id;
                if (lessonsCompleted[id] === false) {
                    break;
                }
            }

            return nextID;
        },

        // Method untuk mengecek apakah lesson bisa diakses
        canAccessLesson(lesson_id, lessonsCompleted) {
            if(lessonsCompleted[lesson_id] === true) {
                return true;
            }

            const nextID = this.nextLesson(lessonsCompleted);
            if(lesson_id === nextID) {
                return true;
            }

            return false;
        },

        countPercentageCompleteness(numCompleted, lessonsCompleted)
        {
            return numCompleted / Object.keys(lessonsCompleted).length * 100;
        }
    }));
</script>