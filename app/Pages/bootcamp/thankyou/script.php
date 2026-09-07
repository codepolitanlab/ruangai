<script>
    Alpine.data('bootcamp_thankyou', function (checkoutCode) {
        let base = $heroic({
            title: 'Thank You - Bootcamp',
            url: `/bootcamp/thankyou/data/${checkoutCode}`,
        });

        return {
            ...base,
            checkoutCode,
            copied: false,

            init() {
                base.init.call(this);
            },

            async copyCode() {
                const code = (this.data && this.data.voucher_code) || '';
                if (!code) return;

                try {
                    await navigator.clipboard.writeText(code);
                    this.copied = true;
                    $heroicHelper.toastr('Kode voucher disalin.', 'success', 'bottom');
                    setTimeout(() => { this.copied = false; }, 2000);
                } catch (e) {
                    // Fallback utk browser tanpa clipboard API
                    const ta = document.createElement('textarea');
                    ta.value = code;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    try {
                        document.execCommand('copy');
                        this.copied = true;
                        $heroicHelper.toastr('Kode voucher disalin.', 'success', 'bottom');
                        setTimeout(() => { this.copied = false; }, 2000);
                    } catch (e2) {
                        $heroicHelper.toastr('Gagal menyalin otomatis. Salin manual: ' + code, 'warning', 'bottom');
                    }
                    document.body.removeChild(ta);
                }
            },

            // Belum diklaim -> halaman Klaim Voucher (/voucher, login di-handle di sana).
            // Sudah diklaim -> langsung ke intro kelas.
            goRedeem() {
                if (this.data && this.data.claimed) {
                    this.$router.navigate(`/bootcamp/classes/${this.data.class_id}/intro`);
                    return;
                }
                this.$router.navigate((this.data && this.data.claim_url) || '/voucher');
            },

            goBootcamp() {
                this.$router.navigate((this.data && this.data.bootcamp_url) || '/bootcamp');
            },
        }
    })
</script>
