<script>
    Alpine.data('listLesson', () => ({
        // Method untuk mengecek apakah semua lesson dalam topic sudah selesai
        isTopicCompleted(topicTitle, lessons) {
            const topicLessons = Object.values(lessons[topicTitle]);
            return topicLessons.every(lesson => lesson.is_completed);
        },

        // Method untuk mengecek apakah lesson bisa diakses
        canAccessLesson(lesson_id, lessonsCompleted) {
            if(lessonsCompleted[lesson_id] === true) {
                return true;
            }

            // Step 1: Konversi key ke array number dan urutkan
            let keys = Object.keys(lessonsCompleted);

            // Step 2: Cari lesson complete terakhir
            let lastCompleteID = null;
            let nextID = null;
            for (let id of keys) {
                nextID = id;
                if (lessonsCompleted[id] === true) {
                    lastCompleteID = id;
                } else {
                    break;
                }
            }

            if(lesson_id === nextID) {
                return true;
            }

            return false;
        }
    }));
</script>