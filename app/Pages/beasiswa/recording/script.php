<script>
    Alpine.data("liveRecording", function(meeting_id) {
        let base = $heroic({
            title: `<?= $page_title ?>`,
            url: `courses/recording/data/${meeting_id}`,
            meta: {}
        })

        return {
            ...base,

            title: "Rekaman Live Session",
            errorMessage: null,

            init() {
                base.init.call(this);

                this.$watch('data', (value) => {
                    // Check access
                    if (value?.response_code && value.response_code !== 200) {
                        console.log('Access denied or error:', value.response_message);
                    }
                });
            },

            getVideoUrl(recording_link, bunny_collection_id) {
                if (!recording_link) return '';
                
                // Default collection ID jika tidak ada di courses
                const collectionId = bunny_collection_id || '431005';
                
                // Format URL Bunny CDN sesuai embed resmi dari Bunny
                return `https://iframe.mediadelivery.net/embed/${collectionId}/${recording_link}?autoplay=false&loop=false&muted=false&preload=true&responsive=true`;
            }
        };
    });
