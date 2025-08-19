<!-- Reload alert after idle n minutes (Alpine.js) -->
<div
    x-data="reloadAlert()"
    x-init="init()"
    x-cloak
    class="relative">
    <div
        id="reloadAlert"
        x-show="ready && Alpine.store('core').showReloadAlert"
        x-transition
        x-cloak
        @click="reload()"
        class="alert alert-warning fade show rounded-0 py-3"
        style="position: fixed; bottom:57px; width:480px; margin:0 auto; font-size:15px; z-index:9999;">
        <div class="d-flex gap-3 align-items-center">
            <span class="bi bi-info-circle fs-3"></span>
            <span style="line-height:20px">Klik untuk memuat ulang/refresh halaman dan mendapatkan pembaharuan data.</span>
        </div>
    </div>
</div>

<script>
    function reloadAlert() {
        return {
            // state
            ready: false,
            idleTime: 30 * 60 * 1000, // 30 menit

            init() {
                // mulai timer; setelah 30 menit belum refresh -> tampilkan alert
                setTimeout(() => {
                    this.ready = true;
                }, this.idleTime);
            },

            reload() {
                // pakai true kalau ingin bypass cache: location.reload(true)
                location.reload();
            }
        }
    }
</script>

<style>
    /* cegah FOUC untuk x-cloak */
    [x-cloak] {
        display: none !important;
    }
</style>