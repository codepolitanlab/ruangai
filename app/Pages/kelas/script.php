<script>
    Alpine.data('kelas', function () {
        let base = $heroic({
            title: 'Kelas Saya',
            url: '/kelas/data',
        });

        return {
            ...base,
            // Modal kode akses kelas bootcamp
            showModal: false,
            code: '',
            redeeming: false,

            init() {
                base.init.call(this);
            },

            // Navigasi SPA ke halaman kelas (intro bootcamp / intro course)
            goCourse(course) {
                if (!course || !course.url) return;
                this.$router.navigate(course.url);
            },

            openRedeem() {
                this.code = '';
                this.showModal = true;
            },

            // Daftar bootcamp: pakai endpoint redeem yang sama dengan halaman /bootcamp
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
                        // Muat ulang daftar kelas — kelas baru pindah ke "Kelas Saya"
                        $heroicHelper.clearCache('/kelas/data');
                        this.loadPage('/kelas/data');
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
