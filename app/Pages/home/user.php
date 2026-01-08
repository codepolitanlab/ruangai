
<div class="appContent pt-2 pb-4" style="min-height:90vh">
    <style>
            
        /* Mobile adjustments to reduce vertical spacing */
        @media (max-width: 767.98px) {
            .menu-grid {
                row-gap: 0.25rem !important;
            }
            .menu-card {
                padding: 10px 8px;
                min-height: 82px;
                gap: 6px;
            }
            .menu-icon-wrapper {
                width: 44px;
                height: 44px;
            }
            .menu-icon {
                width: 44px;
                height: 44px;
            }
            .menu-text {
                font-size: 11px;
            }
        }

        .menu-card {
            border-radius: 16px;
            padding: 14px 10px;
            min-height: 95px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform 0.2s ease;
            background: transparent;
        }
        
        .menu-card:hover {
            transform: translateY(-2px);
            background: rgba(0, 0, 0, 0.02);
        }
        
        .menu-icon-wrapper {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-icon {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }
        
        .menu-text {
            font-size: 12px;
            font-weight: 500;
            line-height: 1.2;
            margin: 0;
        }
        
        /* Desktop styles */
        @media (min-width: 768px) {

            .menu-card {
                border-radius: 22px;
                padding: 18px 12px;
                min-height: 120px;
            }
            
            .menu-icon-wrapper {
                width: 60px;
                height: 60px;
            }
            
            .menu-icon {
                width: 60px;
                height: 60px;
            }
            
            .menu-text {
                font-size: 15px;
                font-weight: 500;
            }
        }
    </style>

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
            <template x-if="data?.student?.program == 'RuangAI2025B2' && !data?.group_comentor">
                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%208476.png" width="35%" alt="">
            </template>
            <template x-if="data?.student?.program == Alpine.store('core').activeProgram">
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

    <!-- Banner & Menu Container -->
    <div class="bg-white rounded-4 p-3 mb-3">
        <!-- Banner GenAI Video Fest -->
        <div class="mb-3">
            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%2010479.png" class="w-100 rounded-4" alt="GenAI Video Fest">
        </div>

        <!-- Pengumuman -->
        <!-- <div class="card mb-3 rounded-4 border-0" style="background: linear-gradient(135deg, #FFF5E6 0%, #FFE8CC 100%);">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-megaphone-fill text-warning" style="font-size: 24px;"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold text-warning">Pengumuman!</h6>
                    <p class="mb-0 small text-dark">Selesaikan kelas pertama sebelum tanggal 31 july 2025, supaya kamu lulus pada tahap pertama!</p>
                </div>
            </div>
        </div> -->

        <!-- Menu Grid -->
        <div class="row g-2 menu-grid">
        <div class="col-3">
            <a href="/courses" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/kelasSaya.svg') ?>" class="menu-icon" alt="Kelas Saya">
                    </div>
                    <p class="menu-text text-dark">Kelas Saya</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="https://ruangai.id" target="_blank" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Beasiswa.svg') ?>" class="menu-icon" alt="Beasiswa">
                    </div>
                    <p class="menu-text text-dark">Beasiswa</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="/challenge" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Kompetisi.svg') ?>" class="menu-icon" alt="Kompetisi">
                    </div>
                    <p class="menu-text text-dark">Kompetisi</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="/courses/reward" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Reward.svg') ?>" class="menu-icon" alt="Reward">
                    </div>
                    <p class="menu-text text-dark">Reward</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="/certificate" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Sertifikat.svg') ?>" class="menu-icon" alt="Sertifikat">
                    </div>
                    <p class="menu-text text-dark">Sertifikat</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Workshop.svg') ?>" class="menu-icon" alt="Workshop">
                    </div>
                    <p class="menu-text text-dark">Workshop</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="/prompt" target="_blank" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Prompt.svg') ?>" class="menu-icon" alt="Prompt">
                    </div>
                    <p class="menu-text text-dark">Prompt</p>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="" class="text-decoration-none">
                <div class="menu-card text-center">
                    <div class="menu-icon-wrapper">
                        <img src="<?= base_url('mobilekit/assets/icon/Lainnya.svg') ?>" class="menu-icon" alt="Lainnya">
                    </div>
                    <p class="menu-text text-dark">Lainnya</p>
                </div>
            </a>
        </div>
        </div>
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

    <!-- Tutorial -->
    <div class="p-3 mb-3 rounded-4 bg-primary d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
        <span class="text-white">Tutorial Belajar dan misi Beasiswa Ruang AI</span>
        <button @click="setVideoTutorial(videoTutorial)" type="button" class="btn bg-white rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTutorial">Lihat Tutorial <i class="bi bi-camera-video ms-2"></i></button>
    </div>

    <!-- Referral -->
    <div class="p-3 mb-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
        <span>Pengen dapet hadiah menarik?</span>
        <a href="https://ruangai.id/referral" target="_blank" class="btn btn-success rounded-pill"><i class="bi bi-coin"></i> Program Referral</a>
    </div>

    <!-- Show Expire Alert -->
    <template x-if="data?.is_scholarship_participant && data.is_expire">
        <div class="card bg-secondary rounded-4 mb-3 shadow-none">
            <div class="card-body d-flex gap-3">
                <i class="bi bi-stopwatch-fill text-white display-3"></i>
                <div>
                    <h4 class="text-white">Program Belajar Chapter 3 Sudah Ditutup</h4>
                    <p class="mb-3 text-white">Pendaftaran untuk Chapter 3 telah ditutup. Nantikan informasi untuk chapter berikutnya.</p>
                </div>
            </div>
        </div>
    </template>

</div>