<script>
    Alpine.data('kelas', function () {
        let base = $heroic({
            title: 'Kelas Saya',
            url: '/kelas/data',
        });

        return {
            ...base,

            init() {
                base.init.call(this);
            },

            // Navigasi SPA ke halaman kelas (intro bootcamp / intro course)
            goCourse(course) {
                if (!course || !course.url) return;
                this.$router.navigate(course.url);
            }
        }
    })
</script>
