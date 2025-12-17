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
    </style>

    <div id="appCapsule">
        <!-- Header -->
        <div class="appHeader bg-primary text-white">
            <div class="left">
                <a href="/challenge" class="headerButton">
                    <i class="bi bi-chevron-back-outline"></i>
                </a>
            </div>
            <div class="pageTitle">GenAI Video Fest Submission</div>
        </div>

        <!-- Alert Messages -->
        <div class="section mt-2" x-show="alert.show" x-cloak>
            <div class="alert" :class="alert.type === 'error' ? 'alert-danger' : 'alert-success'" role="alert">
                <span x-text="alert.message"></span>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="section mt-3">
            <template x-if="isEdit">
                <div class="alert bg-warning bg-opacity-10 mb-2">
                    Anda masih dapat mengedit submission sebelum batas akhir pendaftaran.
                </div>
            </template>

            <?= $this->include('challenge/submit/_profile'); ?>
            
            <?= $this->include('challenge/submit/_video'); ?>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
    <?= $this->include('challenge/submit/script') ?>
</div>