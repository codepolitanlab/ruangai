<script>
    Alpine.data('feedback', () => ({
        isMeetingOver30Min(meetingTime) {
            // Parse dari backend ke Date JS
            let mt = new Date(meetingTime);
            let now = new Date();
            // Tambahkan 30 menit ke meeting time
            mt.setMinutes(mt.getMinutes() + 30);
            // true kalau sekarang >= meeting_time + 30 menit
            return now >= mt;
        },
    }));
</script>