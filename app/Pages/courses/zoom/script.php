<script>
    Alpine.data("registerLiveSession", function(meeting_code) {
        let base = $heroic({
            title: `<?= $page_title ?>`,
            url: `courses/zoom/data/${meeting_code}`,
            meta: {
                expandDesc: false,
                graduate: false,
                isValidEmail: false,
                videoTeaser: null
            }
        })
        return {
            ...base,
            registering: false,

            init() {
                base.init.call(this);
                this.$watch('data', (value) => {
                    const base_url = window.location.origin;
                    // if (value?.is_mentee_comentor && !value?.is_reference_followup && value?.student.graduate != 1) {
                    //     alert(`Maaf, kamu tidak dapat akses halaman live session. Silakan ikuti live session dari Co-Mentor ${value.comentor}.`);
                    //     window.location.replace(`${base_url}/courses/intro/1/dasar-dan-penggunaan-generative-ai/`);
                    // }
                    
                    // Cek apakah peserta B4 (program atau prev_chapter)
                    const isPesertaB4 = value?.program === 'RuangAI2025B4' || value?.prev_chapter === 'RuangAI2025B4';
                    
                    // Cek apakah user memiliki akses ke live session
                    const hasAccess = (value?.is_reference_followup && value?.student.graduate == '0') || 
                                    [1,3].includes(+value?.user?.role_id) || 
                                    isPesertaB4 || 
                                    value?.is_followup || 
                                    value?.is_mentee_comentor ||
                                    value?.is_comentor ||
                                    value?.is_mentor;
                    
                    if (value?.program != Alpine.store('core').activeProgram && !value?.is_comentor && !value?.is_mentor && !(value?.is_reference_followup && value?.student.graduate == '0') && !value?.is_followup && !value?.is_mentee_comentor && !isPesertaB4) {
                        alert('Maaf, kamu belum terdaftar sebagai peserta program RuangAI Chapter ini. Silakan daftar ulang ya!');
                        window.location.replace(`${base_url}`);
                    } else if(value?.is_participating_other_ai_program && value?.student.graduate == 1) {
                        alert('Anda sudah dinyatakan lulus program ini. Anda tetap dapat mengakses materi pembelajaran lainnya di RuangAI.');
                        window.location.replace(`${base_url}`);
                    } else if(!hasAccess) {
                        alert('Maaf, Anda tidak memiliki akses ke halaman live session ini.');
                        window.location.replace(`${base_url}`);
                    }
                });
            },

            register() {
                this.registering = true;
                $heroicHelper.post('/courses/zoom/register', {
                    meeting_code: this.data.meeting_code
                })
                .then((response) => {
                    if (response.data.status == 'success') {
                        this.data.zoom_join_link = response.data.zoom_join_link;
                    }
                });
            }
        }
    });
</script>