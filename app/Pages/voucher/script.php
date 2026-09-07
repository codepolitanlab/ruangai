<script>
    Alpine.data('voucher', function(){
        return {
            title: "Klaim Voucher",
            data: { module: "voucher" },
            code: '',
            loading: false,

            async redeem(){
                const code = (this.code || '').trim();
                if (!code) {
                    $heroicHelper.toastr('Masukkan kode voucher terlebih dahulu.', 'warning', 'bottom');
                    return;
                }

                this.loading = true;

                $heroicHelper.post('/voucher/redeem', { code })
                    .then(response => {
                        if (response.data.status == 'success') {
                            $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                            this.code = '';
                            const redirect = response.data.redirect || '/courses';
                            setTimeout(() => {
                                window.location.href = redirect;
                            }, 1200);
                        } else {
                            $heroicHelper.toastr(response.data.message || 'Gagal menukarkan voucher.', 'danger', 'bottom');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        }
    })
</script>
