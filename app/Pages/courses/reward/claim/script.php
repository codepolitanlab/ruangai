<script>
    Alpine.data("claimReward", function() {
        let base = $heroic({
            title: `<?= $page_title ?>`,
            url: `/courses/reward/claim/data`,
            meta: {
                expandDesc: false,
                graduate: false,
            }
        })

        return {
            ...base,
            selected: null,
            courseSlug: null,
            errorMessage: null,
            loading: false,

            init() {
                base.init.call(this);
            },
            claim() {
                // Confirm alert
                if (!confirm("Apakah Anda yakin ingin mengklaim reward kelas ini?")) {
                    return
                }

                if (!this.selected) {
                    $heroicHelper.toastr("Silahkan pilih kelas terlebih dahulu.", "warning", "bottom");
                    return
                }

                this.loading = true
                const course_id = this.selected

                $heroicHelper.post(`/courses/reward/claim`, {course_id})
                .then((response) => {
                    if(response.data.status == "success"){
                        this.selected = null
                        $heroicHelper.toastr(response.data.message, "success", "bottom");

                        setTimeout(() => {
                            window.location.replace(`/courses/intro/${course_id}/${this.courseSlug}`)
                        }, 2000)
                    } else {
                        $heroicHelper.toastr(response.data.message, "danger", "bottom");
                    }
                    this.loading = false
                })
                .catch((error) => {
                    this.loading = false
                    $heroicHelper.toastr("Kelas Spesial gagal diklaim.", "error", "bottom");
                })
            }
        };
    });
</script>