<script>
    Alpine.data('bootcamp_intro', function (classId) {
        let base = $heroic({
            title: 'Intro Bootcamp',
            url: `/bootcamp/intro/data/${classId}`,
        });

        return {
            ...base,
            classId,

            init() {
                base.init.call(this);
            },

            goLearn() {
                this.$router.navigate(`/bootcamp/classes/${this.classId}/learn`);
            },
        }
    })
</script>
