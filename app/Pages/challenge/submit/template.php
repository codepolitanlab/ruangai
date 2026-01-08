<div
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
            max-width: 740px;
        }
        .appContent {
            margin: 0 auto;
            padding: 0;;
        }
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

    <div id="appCapsule">
        <div class="appContent py-4">
            <div class="mb-3 d-flex align-items-center gap-3">
                <button @click="window.location.href='/challenge'" class="btn rounded-4 px-2 btn-white bg-white text-primary">
                    <h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
                </button>
                <h4 class="m-0 fw-bold">GenAI Video Fest Submission</h4>
            </div>

            <!-- Countdown Timer -->
            <div class="card mb-3">
                <div class="card-body text-center px-2 py-3">
                    <h5 class="mb-3 fw-bold text-primary">Waktu Tersisa Untuk Submit</h5>
                    <div class="d-flex justify-content-center" x-data="countdown()">
                        <div class="countdown-wrapper text-center">
                            <div class="countdown-main">
                                <span x-text="days">00</span> Hari : <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                            </div>
                            <div class="countdown-subtitle">Tersisa</div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0"><small>Batas akhir: 31 Januari 2026, 23:59 WIB</small></p>
                </div>
            </div>

            <!-- Alert Messages -->
            <div class="mt-2" x-show="alert.show" x-cloak>
                <div class="alert" :class="alert.type === 'error' ? 'alert-danger' : 'alert-success'" role="alert">
                    <span x-text="alert.message"></span>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="mt-3">
                <template x-if="isEdit">
                    <div class="alert bg-warning bg-opacity-10 mb-2">
                        Anda masih dapat mengedit submission sebelum batas akhir pendaftaran.
                    </div>
                </template>

                <?= $this->include('challenge/submit/_profile'); ?>
                
                <?= $this->include('challenge/submit/_video'); ?>
            </div>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
    <?= $this->include('challenge/submit/script') ?>
</div>