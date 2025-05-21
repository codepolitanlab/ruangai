<script>
    Alpine.data("live_session", () => ({
        title: `<?= $page_title ?>`,
        url: `courses/intro/live_session/data/${$params.course_id}`,
        
        // Method untuk mendapatkan status sesi
        getSessionStatus(live_session) {
            const sessionDate = new Date(live_session.date);
            const today = new Date();
            sessionDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);
    
            if (live_session.is_followed) {
                return 'followed';
            } else if (sessionDate.getTime() > today.getTime()) {
                return 'upcoming';
            } else if (sessionDate.getTime() === today.getTime()) {
                return 'on-going';
            } else {
                return 'finished';
            }
        },
    
        // Method untuk mendapatkan badge status
        getStatusBadge(live_session) {
            const sessionDate = new Date(live_session.date);
            const today = new Date();
            sessionDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);
    
            if (sessionDate.getTime() > today.getTime()) {
                return { text: 'Akan Datang', class: 'bg-warning text-dark' };
            } else if (sessionDate.getTime() === today.getTime()) {
                return { text: 'Sedang Berlangsung', class: 'bg-primary' };
            } else {
                return { text: 'Selesai', class: 'bg-success' };
            }
        },
    
        // Method untuk mengecek apakah sesi sedang berlangsung
        isOnGoing(live_session) {
            const sessionDate = new Date(live_session.date);
            const today = new Date();
            sessionDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);
            return sessionDate.getTime() === today.getTime();
        }
    }));
</script>