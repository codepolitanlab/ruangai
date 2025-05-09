<div
    id="webpush"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        getUrl: `webpush/data`
        })">

    <div class="appHeader">
        <div class="left">
            <a native href="javascript:void()" @click="$history.back()" class="headerButton">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>
        <div class="pageTitle">Notifikasi</div>
        <div class="right">
        </div>
    </div>

    <div id="appCapsule" class="bg-white">
		<div class="appContent px-3" style="min-height:90vh">

			<section class="mb-5 pt-3">
                <h4>🔔 Ingin Dapat Notifikasi?</h4>
                <p>Kami hanya akan mengirimkan info penting dan kabar terbaru langsung ke perangkatmu.</p>
                <p>Klik tombol di bawah lalu pilih <strong>“Izinkan”</strong> pada popup yang muncul.</p>

                <button class="btn btn-primary" onclick="subscribeToPush()">Aktifkan</button>
                
            </section>

            <section class="mb-5 pt-3">
                <h4>🚫 Nonaktifkan Notifikasi</h4>
                <p>Tidak ingin menerima notifikasi lagi? Kamu bisa menonaktifkannya kapan saja.</p>
                <button class="btn btn-warning" onclick="unsubscribeFromPush()">Nonaktifkan Notifikasi</button>
            </section>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>

</div>
