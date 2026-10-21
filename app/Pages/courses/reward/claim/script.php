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
            // 'course' = kelas khusus (courses), 'live' = kelas live (cls_classes)
            selectedType: null,
            courseSlug: null,
            errorMessage: null,
            loading: false,

            init() {
                base.init.call(this);
            },

            // Total kelas yang masih bisa diklaim (kelas live + kelas khusus)
            get totalClaimable() {
                return (this.data?.live_classes?.length ?? 0) + (this.data?.premium_courses?.length ?? 0);
            },

            // Dipakai untuk highlight kartu; id course & class bisa sama, jadi type ikut dibandingkan
            isSelected(type, id) {
                return this.selected === id && this.selectedType === type;
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

                const isLive = this.selectedType === 'live'
                const selectedId = this.selected
                const slug = this.courseSlug

                const endpoint = isLive ? `/courses/reward/claim/class` : `/courses/reward/claim`
                const payload = isLive ? { class_id: selectedId } : { course_id: selectedId }
                const redirectUrl = isLive
                    ? `/bootcamp/classes/${selectedId}/intro`
                    : `/courses/intro/${selectedId}/${slug}`

                $heroicHelper.post(endpoint, payload)
                .then((response) => {
                    if(response.data.status == "success"){
                        this.selected = null
                        this.selectedType = null
                        $heroicHelper.toastr(response.data.message, "success", "bottom");

                        setTimeout(() => {
                            window.location.replace(redirectUrl)
                        }, 2000)
                    } else {
                        $heroicHelper.toastr(response.data.message, "danger", "bottom");
                    }
                    this.loading = false
                })
                .catch((error) => {
                    this.loading = false
                    $heroicHelper.toastr("Kelas gagal diklaim.", "error", "bottom");
                })
            }
        };
    });
</script>