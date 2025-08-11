<script>
    function registerLiveSession() {
        return {
            registering: false,

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
    }
</script>