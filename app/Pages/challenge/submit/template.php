<div
    class="container-large"
    id="challenge-submit"
    x-data="challengeSubmit()"
    x-init="init()">

    <style>
        .accordion .accordion-header .btn, .accordion .accordion-header .accordion-button-green,
        .accordion .accordion-header .btn, .accordion .accordion-header .accordion-button-green:focus {
            background: #0f957c !important;
            border-radius: 1rem !important;
            color: white;
        }
        .accordion .accordion-header .btn, .accordion .accordion-header .accordion-button-green:after {
            background: url("data:image/svg+xml,%0A%3Csvg width='10px' height='16px' viewBox='0 0 10 16' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd' stroke-linecap='round' stroke-linejoin='round'%3E%3Cg id='Listview' transform='translate(-112.000000, -120.000000)' stroke='%23ffffff' stroke-width='2.178'%3E%3Cpolyline id='Path' points='114 122 120 128 114 134'%3E%3C/polyline%3E%3C/g%3E%3C/g%3E%3C/svg%3E") no-repeat center center !important;
            opacity: .8;
        }
        .form-label {
            font-weight: 500;
        }
        [x-cloak] { display: none !important; }
        #appCapsule {
            max-width: 100%;
        }
        .appContent {
            margin: 0 auto;
            padding: 0;;
        }
        .stepper-nav {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .stepper-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #6c757d;
            font-weight: 600;
            transition: all 0.2s;
        }
        .stepper-item.active {
            border-color: #0f957c;
            color: #0f957c;
            box-shadow: 0 6px 18px rgba(15, 149, 124, 0.15);
        }
        .stepper-item.completed {
            border-color: #198754;
            color: #198754;
        }
        .stepper-item.locked {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .step-number {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f8f9fa;
            font-weight: 700;
        }
        .stepper-item.active .step-number {
            background: #0f957c;
            color: #fff;
        }
        .stepper-item.completed .step-number {
            background: #198754;
            color: #fff;
        }
        .status-pill {
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status-review { background: #e7f1ff; color: #0b5ed7; }
        .status-approved { background: #e7f6ef; color: #198754; }
        .status-rejected { background: #fdecec; color: #dc3545; }
        .status-pending { background: #fff3cd; color: #856404; }
        .countdown-wrapper {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 1rem;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            display: inline-block;
            min-width: 280px;
        }
        .countdown-main {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            line-height: 1.2;
            margin-bottom: 0.5rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .countdown-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        @media (max-width: 576px) {
            .countdown-wrapper {
                padding: 1.25rem 1.5rem;
                min-width: 240px;
            }
            .countdown-main {
                font-size: 1.5rem;
            }
            .countdown-subtitle {
                font-size: 0.875rem;
                letter-spacing: 1.5px;
            }
            .card-body h5 {
                font-size: 1rem !important;
            }
            .card-body small {
                font-size: 0.7rem !important;
            }
        }
        @media (max-width: 380px) {
            .countdown-wrapper {
                padding: 1rem 1.25rem;
                min-width: 200px;
            }
            .countdown-main {
                font-size: 1.25rem;
            }
            .countdown-subtitle {
                font-size: 0.75rem;
                letter-spacing: 1px;
            }
        }
    </style>

    <div id="appCapsule" class="appCapsule-lg" style="padding-top: 0;">
        <div class="container-fluid px-0 px-lg-3" style="max-width: 1150px;">
            <div class="appContent py-4">
            <div class="mb-3 d-flex align-items-center gap-3">
                <button @click="window.location.href='/challenge'" class="btn rounded-4 px-2 btn-white bg-white text-primary">
                    <h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
                </button>
                <div>
                    <h4 class="m-0 fw-bold">Dashboard Kompetisi GenAI</h4>
                    <small class="text-muted">GenAI Video Fest Submission</small>
                </div>
                <div class="ms-auto" x-show="hasSubmission" x-cloak>
                    <span class="status-pill" :class="statusClass()" x-text="statusLabel()"></span>
                </div>
            </div>

            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center">
                    <div>
                        <h5 class="mb-2 fw-bold">GenAI Video Fest</h5>
                        <p class="text-muted mb-2">Ikuti lomba dalam 3 langkah mudah: lengkapi profil, submit karya, dan pantau status review hingga hasil diumumkan.</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark">Satu akun satu submission</span>
                            <span class="badge bg-light text-dark">Wajib WAN Model Studio / WAN Video AI</span>
                            <span class="badge bg-light text-dark">Status real-time</span>
                        </div>
                    </div>
                    <div class="ms-lg-auto text-center text-lg-end">
                        <h6 class="fw-bold text-primary mb-2">Waktu Tersisa</h6>
                        <div class="d-flex justify-content-center justify-content-lg-end" x-data="countdown()">
                            <div class="countdown-wrapper text-center">
                                <div class="countdown-main">
                                    <span x-text="days">00</span> Hari : <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                                </div>
                                <div class="countdown-subtitle">Tersisa</div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">Batas akhir: 13 Maret 2026, 23:59 WIB</small>
                    </div>
                </div>
            </div>

            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <div class="stepper-nav">
                        <button type="button" class="stepper-item" :class="stepClass(1)" @click="goToStep(1)" :disabled="isStepLocked(1)">
                            <span class="step-number">1</span>
                            <span>Lengkapi Data Diri</span>
                        </button>
                        <button type="button" class="stepper-item" :class="stepClass(2)" @click="goToStep(2)" :disabled="isStepLocked(2)">
                            <span class="step-number">2</span>
                            <span>Submit Karya</span>
                        </button>
                        <button type="button" class="stepper-item" :class="stepClass(3)" @click="goToStep(3)" :disabled="isStepLocked(3)">
                            <span class="step-number">3</span>
                            <span>Review / Selesai</span>
                        </button>
                    </div>
                    <div class="alert alert-warning mt-3 mb-0" x-show="currentStep === 1 && !isProfileComplete()" x-cloak>
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Step 2 dan 3 akan terbuka setelah data diri Anda lengkap.
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div class="mt-2" x-show="alert.show" x-cloak>
                <div class="alert" :class="alert.type === 'error' ? 'alert-danger' : 'alert-success'" role="alert">
                    <span x-text="alert.message"></span>
                </div>
            </div>

            <!-- Step Content -->
            <div class="mt-3">
                <template x-if="isEdit">
                    <div class="alert bg-warning bg-opacity-10 mb-2">
                        Anda masih dapat mengedit submission sebelum batas akhir pendaftaran.
                    </div>
                </template>

                <div x-show="currentStep === 1" x-cloak>
                    <?= $this->include('challenge/submit/_profile'); ?>
                </div>

                <div x-show="currentStep === 2" x-cloak>
                    <div class="alert alert-warning" x-show="hasSubmission && !canEditSubmission" x-cloak>
                        Submission Anda sudah final dan tidak dapat diubah.
                    </div>
                    <?= $this->include('challenge/submit/_video'); ?>
                </div>

                <div x-show="currentStep === 3" x-cloak>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-2">Status Submission</h5>
                            <p class="text-muted mb-4">Pantau proses review dan update karya bila status masih review.</p>

                            <template x-if="!hasSubmission">
                                <div class="alert alert-warning mb-0">
                                    Anda belum mengirimkan karya. Silakan selesaikan Step 2 terlebih dahulu.
                                </div>
                            </template>

                            <template x-if="hasSubmission && normalizedStatus() === 'review'">
                                <div class="alert alert-success">
                                    <strong>Sedang Direview</strong><br>
                                    Tim kami sedang meninjau karya Anda. Anda masih bisa memperbarui submission di Step 2.
                                </div>
                            </template>

                            <template x-if="hasSubmission && normalizedStatus() === 'rejected'">
                                <div class="alert alert-danger">
                                    <strong>Submission Ditolak</strong><br>
                                    <span x-text="submissionNotes || 'Tidak ada catatan tambahan.'"></span>
                                </div>
                            </template>

                            <template x-if="hasSubmission && normalizedStatus() === 'approved'">
                                <div>
                                    <div class="alert alert-success">
                                        <strong>Submission Disetujui</strong><br>
                                        Selamat! Anda berhak mendapatkan sertifikat keikutsertaan.
                                    </div>
                                    <div class="card border-0 shadow-sm">
                                        <img src="https://placehold.co/1200x720/png" alt="Sertifikat" class="w-100 rounded-4">
                                        <div class="card-body text-end">
                                            <a class="btn btn-primary" href="https://www.codepolitan.com/c/FTVJ30Q/" target="_blank">Klaim Sertifikat</a>
                                        </div>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
    <?= $this->include('challenge/submit/script') ?>
</div>