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
                    if (value?.is_mentee_comentor && value?.student.graduate != 1) {
                        alert(`Maaf, kamu tidak terdaftar sebagai peserta Chapter ini. Silakan ikuti live session dari Co-Mentor ${value.comentor}.`);
                        const base_url = window.location.origin;
                        window.location.replace(`${base_url}/courses/intro/1/dasar-dan-penggunaan-generative-ai/`);
                    } else if (value?.program != Alpine.store('core').activeProgram && !value?.is_comentor && !value?.is_mentor) {
                        alert('Maaf, kamu belum terdaftar sebagai peserta program RuangAI Chapter ini. Silakan daftar ulang ya!');
                        const base_url = window.location.origin;
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