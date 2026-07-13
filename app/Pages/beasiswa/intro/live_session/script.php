<script>
    Alpine.data("sesiLive", function(course_id) {
        let base = $heroic({
            title: `<?= $page_title ?>`,
            url: `beasiswa/intro/live_session/data/${course_id}`,
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
                    const base_url = window.location.origin;
                    
                    // Cek apakah user memiliki akses ke live session
                    // if (value?.program != Alpine.store('core').activeProgram && !value?.is_comentor && !value?.is_mentor && !value?.is_reference_followup && !value?.is_followup && !value?.is_mentee_comentor) {
                    //     alert('Maaf, kamu belum terdaftar sebagai peserta program RuangAI Chapter ini. Silakan daftar ulang ya!');
                    //     window.location.replace(`${base_url}`);
                    // } else 
                    if(value?.is_participating_other_ai_program && value?.student?.graduate == 1) {
                        alert('Kamu sudah dinyatakan lulus program ini. Anda tetap dapat mengakses materi pembelajaran lainnya di RuangAI.');
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

            async registerLiveSession(meetingCode) {
                if (!meetingCode) return;

                const token = localStorage.getItem('heroic_token');
                if (!token) {
                    $heroicHelper.toastr('Anda belum login.', 'error', 'bottom');
                    return;
                }

                // Cek verifikasi email dari JWT
                try {
                    const payload = JSON.parse(atob(token.split('.')[1]));
                    const emailVerified = +payload.isValidEmail === 1;

                    if (!emailVerified) {
                        $heroicHelper.toastr('Silakan verifikasi email Anda terlebih dahulu.', 'warning', 'bottom');
                        return;
                    }
                } catch (e) {
                    console.error('Gagal mem-parsing token', e);
                }

                try {
                    const response = await axios.post('/beasiswa/zoom/register',
                        { meeting_code: meetingCode },
                        { headers: { Authorization: token } }
                    );

                    if (response.data.status === 'success') {
                        // Update UI langsung: set is_registered = true + zoom_join_link
                        const zoomJoinLink = response.data.zoom_join_link || null;
                        this.updateSessionAfterRegister(meetingCode, zoomJoinLink);
                        $heroicHelper.toastr('Pendaftaran berhasil!', 'success', 'bottom');
                    } else if (response.data.status === 'already_registered') {
                        $heroicHelper.toastr('Kamu sudah terdaftar di sesi ini.', 'info', 'bottom');
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal mendaftar.', 'danger', 'bottom');
                        return;
                    }

                    // Refresh data dari server
                    setTimeout(() => {
                        this.loadPage(`beasiswa/intro/live_session/data/${course_id}`);
                    }, 500);
                } catch (e) {
                    console.error('Gagal mendaftar live session', e);
                }
            },

            // Update status session di local data agar tombol langsung berubah tanpa nunggu refresh
            updateSessionAfterRegister(meetingCode, zoomJoinLink) {
                ['scheduled', 'ongoing', 'completed'].forEach(group => {
                    const sessions = this.data?.live_sessions?.[group];
                    if (!sessions) return;
                    for (let i = 0; i < sessions.length; i++) {
                        if (sessions[i].meeting_code === meetingCode) {
                            this.data.live_sessions[group][i].is_registered = true;
                            if (zoomJoinLink) {
                                this.data.live_sessions[group][i].zoom_join_link = zoomJoinLink;
                            }
                            break;
                        }
                    }
                });
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
                $heroicHelper.post(`/beasiswa/intro/live_session/checkAttendedStatus`, {
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