<script>
    Alpine.data('sesiLive', () => ({
        currentFeedbackMeeting: {
            id: '',
            title: ''
        },

        checkingStatus: false,

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
                return {
                    text: 'Akan Datang',
                    class: 'bg-warning text-dark'
                };
            } else if (sessionDate.getTime() === today.getTime()) {
                return {
                    text: 'Sedang Berlangsung',
                    class: 'bg-primary'
                };
            } else {
                return {
                    text: 'Selesai',
                    class: 'bg-success'
                };
            }
        },

        // Method untuk mengecek apakah sesi sedang berlangsung
        isOnGoing(live_session) {
            const sessionDate = new Date(live_session.date);
            const today = new Date();
            sessionDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);
            return sessionDate.getTime() === today.getTime();
        },

        checkEmailIsVerified(meetingIndex, eventStatus) {
            const token = localStorage.getItem('heroic_token');
            let emailVerified = false;

            if (!this.data.live_sessions[eventStatus][meetingIndex].meeting_code) return; // jika link kosong, jangan lanjutkan

            if (token) {
                try {
                    const payload = JSON.parse(atob(token.split('.')[1]));
                    emailVerified = +payload.isValidEmail === 1;

                    if (emailVerified) {
                        // Email terverifikasi, redirect ke pendaftaran
                        this.$router.navigate(`/courses/zoom/${this.data.live_sessions[eventStatus][meetingIndex].meeting_code}`)
                    } else {
                        // Tampilkan toast jika email belum diverifikasi
                        $heroicHelper.toastr('Silakan verifikasi email Anda terlebih dahulu.', 'warning', 'bottom');
                    }
                } catch (e) {
                    console.error("Gagal mem-parsing token JWT", e);
                    $heroicHelper.toastr('Terjadi kesalahan autentikasi.', 'error', 'bottom');
                }
            } else {
                $heroicHelper.toastr('Anda belum login.', 'error', 'bottom');
            }
        },

        setCurrentFeedbackMeeting(meetingIndex) {
            this.currentFeedbackMeeting.id = this.data.live_sessions.ongoing[meetingIndex].id;
            this.currentFeedbackMeeting.title = this.data.live_sessions.ongoing[meetingIndex].subtitle;
        },

        checkAttendedStatus(meetingIndex) {
            let meetingID = this.data.attended[meetingIndex].live_meeting_id;
            console.log(meetingID, meetingIndex, this.data.attended);
            $heroicHelper.post(`/courses/intro/live_session/checkAttendedStatus`, {meeting_id: meetingID})
            .then((response) => {
                if(response.data.status == 'success') {
                    this.data.attended[meetingIndex].status = 1;
                    $heroicHelper.toastr(`Anda telah mengikuti sesi ${this.data.attended[meetingIndex].title}`, 'success', 'bottom');
                    return;
                }
                
                $heroicHelper.toastr(`Feedback untuk sesi ${this.data.attended[meetingIndex].title} belum terkirim`, 'warning', 'bottom');
            })
        },

    }));
</script>