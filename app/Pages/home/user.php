
<?php
/**
 * Kartu kelas di Beranda — STATIS, dipakai untuk jualan.
 *
 * Ganti `url` dengan link checkout produk (boleh URL dari platform lain).
 * Selama `url` masih '#' / kosong, kartu tampil tapi belum bisa diklik.
 * Kartu pertama otomatis tampil lebar (full width), sisanya 2 kolom.
 * Warna aksen mengikuti urutan: oranye, teal, ungu.
 */
$kelasTerbaru = [
    ['title' => 'Mastery Class Generative AI', 'batch' => 'Batch 1', 'pertemuan' => 9, 'url' => '#'],
    ['title' => 'Advance VibeCoding',          'batch' => 'Batch 1', 'pertemuan' => 9, 'url' => '#'],
    ['title' => 'Advance Agentic AI',          'batch' => 'Batch 1', 'pertemuan' => 9, 'url' => '#'],
];
?>
<div class="appContent py-4 rd-dashboard" style="min-height:90vh">

    <!-- ===== Hero sambutan ===== -->
    <section class="rd-hero">
        <img
            class="rd-hero-avatar"
            :src="data?.user?.avatar && data?.user?.avatar != '' ? data?.user?.avatar : `https://ui-avatars.com/api/?name=${data?.name ?? 'El'}&background=1A2840&color=FFF`"
            alt="avatar">
        <div>
            <p class="rd-hero-greet">Selamat Belajar,</p>
            <h2 class="rd-hero-name" x-text="data?.name"></h2>
        </div>
    </section>

    
    <!-- ===== Kelas Terbaru + kartu promo ===== -->
    <section class="rd-section-card">
        <!-- ===== Kartu promo ===== -->
        <section class="rd-promo">
            <div class="rd-promo-content">
                <h3 class="rd-promo-title"><span class="text-white">Mastery Class</span><br>Generative AI</h3>
                <p class="rd-promo-sub">Bangun website portfolio personal yang profesional</p>
                <div>
                    <a href="/" class="rd-btn rd-btn-primary">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </section>
        <h3 class="rd-section-title mt-4">Kelas Terbaru</h3>
        <div class="rd-course-grid">
            <?php foreach ($kelasTerbaru as $i => $kelas): ?>
                <?php $placeholder = in_array(trim((string) $kelas['url']), ['', '#'], true); ?>
                <a class="rd-course<?= $i === 0 ? ' rd-course-wide' : '' ?> rd-course-<?= ($i % 3) + 1 ?>"
                   href="<?= esc($placeholder ? '#' : $kelas['url'], 'attr') ?>"
                   <?= $placeholder ? '@click.prevent.stop' : '' ?>>
                    <div class="rd-course-star"><i class="bi bi-stars"></i></div>
                    <div class="rd-course-body">
                        <div class="rd-course-badges">
                            <span class="rd-badge rd-badge-solid"><i class="bi bi-camera-video"></i> Live Class</span>
                            <span class="rd-badge rd-badge-outline"><?= esc($kelas['batch']) ?></span>
                        </div>
                        <h4 class="rd-course-title"><?= esc($kelas['title']) ?></h4>
                        <div class="rd-course-meta">
                            <i class="bi bi-play-fill"></i>
                            <span><?= (int) $kelas['pertemuan'] ?> Pertemuan</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ===== Voucher ===== -->
    <section class="rd-voucher">
        <p class="rd-voucher-text">Sudah punya voucher kelas?</p>
        <a href="/voucher" class="rd-btn rd-btn-primary">Klaim Voucher Disini</a>
    </section>

    <!-- ===== Verifikasi email ===== -->
    <section x-show="!meta.isValidEmail" class="rd-verify my-1">
        <div class="d-flex gap-3 align-items-start w-100">
            <div class="rd-verify-icon"><i class="bi bi-envelope-exclamation"></i></div>
            <div style="min-width:0">
                <h5 class="m-0">Kamu belum memverifikasi email nih!</h5>
                <p class="mb-0">Segera lakukan verifikasi email agar semua fitur bisa diakses.</p>
            </div>
        </div>
        <button x-show="!meta.loading" type="button" x-on:click="showPopupVerification()" class="rd-btn rd-btn-primary my-3">Verifikasi Email Sekarang</button>
        <button x-show="meta.loading" type="button" disabled class="rd-btn rd-btn-primary my-3">
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Sedang mengirim OTP...
        </button>
    </section>

    <!-- ===== Tutorial ===== -->
    <!-- <section class="rd-verify d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
        <span>Butuh bantuan memulai? Tonton tutorial singkat berikut.</span>
        <button @click="setVideoTutorial(videoTutorial)" type="button" class="rd-btn rd-btn-primary" data-bs-toggle="modal" data-bs-target="#modalTutorial">Lihat Tutorial <i class="bi bi-camera-video ms-2"></i></button>
    </section> -->

</div>