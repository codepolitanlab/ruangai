<div class="appContent pt-2 pb-4" style="min-height:90vh">

    <!-- Header -->
    <div class="p-4 px-3 mb-3 bg-white rounded-4 position-relative" style="min-height:110px">
        <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 99; position: absolute !important; bottom: 10px;">
            <div class="avatar">
                <img :src="data?.user?.avatar && data?.user?.avatar != '' ? data?.user?.avatar : `https://ui-avatars.com/api/?name=${data?.name ?? 'El'}&background=79B2CD&color=FFF`" alt="avatar" class="imaged w48 rounded-circle">
            </div>
            <div>
                <h4 class="mb-0 text-muted fw-normal">Selamat Belajar,</h4>
                <h5 class="mb-0" x-text="data?.name"></h5>
            </div>
        </div>
        <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206633.png" class="position-absolute bottom-0 end-0 w-25" alt="">
        <div
            class="d-flex justify-content-between align-items-start position-absolute px-3"
            style="top: 10px; left: 0; right: 0;">
            <template x-if="data?.student?.program == 'RuangAI2025B2'">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%208476.png" width="35%" alt="">
            </template>
            <template x-if="data?.student?.program == 'RuangAI2025B3'">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%209476.png?updatedAt=1760359599371" width="35%" alt="">
            </template>
            <!-- <div class="d-flex flex-column ms-2">
						<div class="mb-2">Berakhir dalam</div>
						<div class="d-flex gap-4 justify-content-center text-center">
							<div>
								<div class="fs-4 fw-bold text-warning" x-text="countdownParts.days"></div>
								<div class="small">Hari</div>
							</div>
							<div>
								<div class="fs-4 fw-bold text-warning" x-text="countdownParts.hours"></div>
								<div class="small">Jam</div>
							</div>
							<div>
								<div class="fs-4 fw-bold text-warning" x-text="countdownParts.minutes"></div>
								<div class="small">Menit</div>
							</div>
							<div>
								<div class="fs-4 fw-bold text-warning" x-text="countdownParts.seconds"></div>
								<div class="small">Detik</div>
							</div>
						</div>

					</div> -->
        </div>

    </div>

    <!-- Pengumuman -->
    <?= $this->include('home/pengumuman'); ?>

    <!-- Tutorial -->
    <div class="p-3 mb-3 rounded-4 bg-primary d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
        <span class="text-white">Tutorial Belajar dan misi Beasiswa Ruang AI</span>
        <button @click="setVideoTutorial(videoTutorial)" type="button" class="btn bg-white rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTutorial">Lihat Tutorial <i class="bi bi-camera-video ms-2"></i></button>
    </div>

    <div x-show="!meta.isValidEmail" class="rounded-20 p-3 py-4 bg-white my-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h5 class="m-0">Kamu belum melakukan verifikasi email nih, silahkan lakukan verifikasi email terlebih dahulu.</h5>
                <button x-show="!meta.loading" type="button" x-on:click="showPopupVerification()" class="btn btn-primary rounded-pill px-4 my-3 fw-bold">Verifikasi Email Sekarang</button>
                <button x-show="meta.loading" type="button" disabled class="btn btn-primary rounded-pill px-4 my-3 fw-bold">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Sedang mengirim OTP...
                </button>
            </div>
        </div>
    </div>

    <!-- Show Expire Alert -->
    <template x-if="data.is_expire">
        <div class="card bg-warning-2 rounded-4 mb-3 shadow-none">
            <div class="card-body d-flex gap-3">
                <i class="bi bi-stopwatch-fill text-white display-3 shaky-icon"></i>
                <div>
                    <h4 class="text-white">Program Belajar Chapter 3 Sudah Dibuka!</h4>
                    <p class="mb-3 text-white">Kamu dapat melanjutkan belajar dengan bergabung di Chapter 3 dengan mengklik tombol di bawah ini untuk mendaftar ulang.</p>
                    <button class="btn btn-light" @click="heregister"><i class="bi bi-file-earmark-arrow-up"></i> Daftar Ulang ke Chapter 3</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Card Kelas -->
    <div class="mb-3">
        <div class="bg-white p-4 rounded-4 g-3 mb-4">
            <h5 class="fw-semibold">Progres Belajar</h5>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <a href="/courses">
                        <div class="class-card h-100 p-3 d-flex flex-column justify-content-between position-relative" style="min-height: 220px;">
                            <div class="me-3 bg-white text-dark rounded p-2 d-flex align-items-center  justify-content-center" style="width: 50px;height: 50px">
                                <img src="<?= base_url('mobilekit/assets/img/ruangai/module.svg') ?>" width="20" alt="">
                            </div>
                            <div class="d-flex align-items-end gap-2 mt-4 mb-2 text-dark">
                                <h1 class="mb-0 display-6 fw-bold" x-text="data?.courses ?? 0"></h1>
                                <p class="mb-1">kelas yang kamu miliki</p>
                            </div>
                            <a href="/courses" class="btn btn-primary hover rounded-pill p-1">Lihat kelas saya</a>
                            <img src="https://ik.imagekit.io/56xwze9cy/jagoansiber/Vector%20(1).png" class="position-absolute end-0" style="top: 12px;opacity: .1;" width="70" alt="">
                        </div>
                    </a>
                </div>

                <!-- Lanjutkan Belajar -->
                <div class="col-md-6">
                    <div class="card text-white bg-primary position-relative" style="min-height: 200px; border-radius: 18px; overflow: hidden; z-index: 1">
                        <img src="https://ik.imagekit.io/56xwze9cy/ruangai/card%20class.png" class="w-100 position-relative" alt="Kelas AI" style="z-index: 1">
                        <div class="p-3 d-flex flex-column justify-content-end position-relative" style="background: linear-gradient(to top, #79B2CD 50%, rgba(255, 255, 255, 0));height: 100%;margin-top: -50px;z-index: 1000">
                            <h5
                                class="card-title text-white mb-1 mt-3"
                                style="font-size: 1.1rem; font-weight: 500;"
                                x-text="data?.last_course.title"></h5>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-play-fill fs-3 me-2"></i>
                                <div class="progress flex-grow-1 me-2" style="height: 5px;">
                                    <div class="progress-bar bg-warning" role="progressbar" :style="`width: ${Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100)}%`"></div>
                                </div>
                                <span x-text="Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100)"></span>%
                            </div>
                            <a x-show="Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100) < 100 || data?.total_live_session == 0" :href="`/courses/intro/${data?.last_course.id}/${data?.last_course?.slug}/lessons`" class="btn bg-white rounded-pill p-1 text-secondary hover">Mulai Belajar</a>
                            <a x-show="Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100) >= 100 && data?.total_live_session > 0" :href="`/courses/intro/${data?.last_course.id}/${data?.last_course?.slug}`" class="btn bg-white rounded-pill p-1 text-success hover">Klaim Sertifikat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Join Grup -->
        <div class="p-3 mb-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
            <span>Belum gabung Komunitas RuangAI?</span>
            <a href="https://t.me/codepolitan/102492" target="_blank" class="btn btn-primary rounded-pill"><i class="bi bi-telegram"></i> Gabung Grup</a>
        </div>

        <!-- Referral -->
        <div class="p-3 mb-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
            <span>Pengen dapet hadiah menarik?</span>
            <a href="https://ruangai.id/referral" target="_blank" class="btn btn-success rounded-pill"><i class="bi bi-coin"></i> Program Referral</a>
        </div>

    </div>
</div>