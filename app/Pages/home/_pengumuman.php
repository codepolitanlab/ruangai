<div class="container pengumuman-home mb-5" x-show="pengumumanRead.includes(data.pengumuman?.id) == false">
    <div class="d-flex align-items-stretch justify-content-center">
        <div class="rounded-4 bg-brand-2 d-flex align-items-center justify-content-center" style="min-width: 70px; border-right:1px dashed white;">
            <img src="<?= $themeURL ?>assets/img/icon/pengumuman-home.png" style="width:36px;opacity:.6">
        </div>
        <div class="rounded-4 bg-brand-2">
            <div class="p-2">
                <a href="/pengumuman" class="item rounded-top-5 bg-brand-2 d-flex">
                    <div class="text-light">
                        <h3 class="text-white mb-1" style="font-size: 1rem;">Pengumuman Baru</h3>
                        <div style="font-size: 15px; line-height: 1.3rem;" x-text="data.pengumuman?.title"></div>
                    </div>
                    <div class="text-white-50 d-flex align-items-center justify-content-center">
                        <i class="bi bi-chevron-right fs-1"></i></div>
                </a>
            </div>
        </div>
    </div>
</div>
