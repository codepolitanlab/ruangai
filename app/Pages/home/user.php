
<div class="appContent py-4 rd-dashboard" style="min-height:90vh">

    <!-- ===== Hero sambutan ===== -->
    <section class="rd-hero">
        <img
            class="rd-hero-avatar"
            :src="data?.user?.avatar && data?.user?.avatar != '' ? data?.user?.avatar : `https://ui-avatars.com/api/?name=${data?.name ?? 'El'}&background=79B2CD&color=FFF`"
            alt="avatar">
        <div>
            <p class="rd-hero-greet">Selamat Belajar,</p>
            <h2 class="rd-hero-name" x-text="data?.name"></h2>
        </div>
    </section>

    
    <!-- ===== Kelas yang kamu miliki ===== -->
    <section class="rd-section-card">
        <!-- ===== Kartu promo ===== -->
        <section class="rd-promo">
            <div class="rd-promo-content">
                <h3 class="rd-promo-title"><span class="text-white">Mastery Class</span><br>Generative AI</h3>
                <p class="rd-promo-sub">Bangun website portfolio personal yang profesional</p>
                <div>
                    <a href="/courses" class="rd-btn rd-btn-primary">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </section>
        <h3 class="rd-section-title mt-4">Kelas yang kamu miliki</h3>
        <div class="rd-course-grid">
            <template x-for="(course, index) in data?.my_courses" :key="course.id">
                <a class="rd-course"
                   :class="(index === 0 ? 'rd-course-wide ' : '') + 'rd-course-' + ((index % 3) + 1)"
                   :href="'/courses/intro/' + course.id + '/' + (course.slug || '')">
                    <div class="rd-course-star"><i class="bi bi-stars"></i></div>
                    <div class="rd-course-body">
                        <div class="rd-course-badges">
                            <span class="rd-badge rd-badge-solid">Live Class</span>
                            <span class="rd-badge rd-badge-outline" x-text="course.batch_name || 'Batch 1'"></span>
                        </div>
                        <h4 class="rd-course-title" x-text="course.course_title"></h4>
                        <div class="rd-course-meta">
                            <i class="bi bi-arrow-right"></i>
                            <span x-text="(course.total_meetings || 9) + ' Pertemuan'"></span>
                        </div>
                    </div>
                </a>
            </template>

            <template x-if="!data?.my_courses || data?.my_courses.length === 0">
                <div class="rd-course rd-course-1" style="grid-column: 1 / -1;">
                    <div class="rd-course-star"><i class="bi bi-book"></i></div>
                    <h4 class="rd-course-title">Kamu belum memiliki kelas</h4>
                    <div class="rd-course-meta" style="margin-top:0"><span>Yuk daftar kelas sekarang!</span></div>
                </div>
            </template>
        </div>
    </section>

    <!-- ===== Voucher ===== -->
    <section class="rd-voucher">
        <p class="rd-voucher-text">Sudah punya voucher kelas?</p>
        <a href="/voucher" class="rd-btn rd-btn-primary">Klaim Voucher Disini</a>
    </section>

    <!-- ===== Verifikasi email ===== -->
    <section x-show="!meta.isValidEmail" class="rd-verify my-1">
        <h5 class="m-0">Kamu belum melakukan verifikasi email nih, silahkan lakukan verifikasi email terlebih dahulu.</h5>
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