<script>
    Alpine.data("sesiLive", function(course_id) {
        let base = $heroic({
            title: `<?= $page_title ?>`,
            url: `courses/intro/live_session/data/${course_id}`,
            meta: {
                expandDesc: false,
                graduate: false,
                isValidEmail: false,
                videoTeaser: null
            }
        })

        return {
            ...base,
            currentFeedbackMeeting: {
                id: '',
                title: ''
            },

            checkingStatus: false,

            init() {
                base.init.call(this);
                this.$watch('data', (value) => {
                    // if (value?.is_mentee_comentor && !value?.is_reference_followup && value?.student.graduate != 1) {
                    //     alert(`Maaf, kamu tidak dapat akses halaman live session. Silakan ikuti live session dari Co-Mentor ${value.comentor}.`);
                    //     const base_url = window.location.origin;
                    //     window.location.replace(`${base_url}/courses/intro/1/dasar-dan-penggunaan-generative-ai/`);
                    // } 
                    if (value?.program != Alpine.store('core').activeProgram && !value?.is_comentor && !value?.is_mentor) {
                        alert('Maaf, kamu belum terdaftar sebagai peserta program RuangAI Chapter ini. Silakan daftar ulang ya!');
                        const base_url = window.location.origin;
                        window.location.replace(`${base_url}`);
                    } else if(value?.is_participating_other_ai_program && value?.student.graduate == 1) {
                        alert('Anda sudah dinyatakan lulus program ini. Anda tetap dapat mengakses materi pembelajaran lainnya di RuangAI.');
                        const base_url = window.location.origin;
                        window.location.replace(`${base_url}`);
                    }
                });
            },

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

            isMeetingOver30Min(meetingTime) {
                // Parse dari backend ke Date JS
                let mt = new Date(meetingTime);
                let now = new Date();
                // Tambahkan 30 menit ke meeting time
                mt.setMinutes(mt.getMinutes() + 30);
                // true kalau sekarang >= meeting_time + 30 menit
                return now >= mt;
            },

            checkAttendedStatus(meetingIndex) {
                let meetingID = this.data.attended[meetingIndex].live_meeting_id;
                console.log(meetingID, meetingIndex, this.data.attended);
                $heroicHelper.post(`/courses/intro/live_session/checkAttendedStatus`, {
                        meeting_id: meetingID
                    })
                    .then((response) => {
                        if (response.data.status == 'success') {
                            this.data.attended[meetingIndex].status = 1;
                            $heroicHelper.toastr(`Anda telah mengikuti sesi ${this.data.attended[meetingIndex].title}`, 'success', 'bottom');
                            return;
                        }

                        $heroicHelper.toastr(`Feedback untuk sesi ${this.data.attended[meetingIndex].title} belum terkirim`, 'warning', 'bottom');
                    })
            },
        }
    });
</script>