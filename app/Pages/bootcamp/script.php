<script>
    Alpine.data('bootcamp', function () {
        let base = $heroic({
            title: 'Bootcamp',
            url: '/bootcamp/data',
        });

        return {
            ...base,
            title: 'Bootcamp',
            code: '',
            showModal: false,
            redeeming: false,

            init() {
                base.init.call(this);
            },

            openModal() {
                this.code = '';
                this.showModal = true;
            },

            goLearn(classId) {
                // Alur: Kelas Saya -> Intro Bootcamp -> Belajar
                this.$router.navigate(`/bootcamp/classes/${classId}/intro`);
            },

            async redeem() {
                const code = (this.code || '').trim();
                if (!code) {
                    $heroicHelper.toastr('Masukkan kode akses terlebih dahulu.', 'warning', 'bottom');
                    return;
                }

                this.redeeming = true;
                try {
                    const response = await $heroicHelper.post('/bootcamp/redeem', { code });
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                        this.showModal = false;
                        this.code = '';
                        // Muat ulang daftar kelas
                        $heroicHelper.clearCache('/bootcamp/data');
                        this.loadPage('/bootcamp/data');
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal memakai kode akses.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.redeeming = false;
                }
            }
        }
    })
</script>
