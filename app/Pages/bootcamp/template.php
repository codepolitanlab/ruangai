<div id="bootcamp" x-data="bootcamp()" class="header-mobile-only rd-page">

    <style>
        #bootcamp .bc-heading {
            padding: 18px 20px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        #bootcamp .appContent { padding-bottom: 110px; }
        #bootcamp .bc-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--rd-text);
            line-height: 1.2;
        }
        #bootcamp .bc-code-btn {
            border: none;
            border-radius: 999px;
            padding: 10px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--rd-primary-contrast, #fff);
            background: var(--rd-primary);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            white-space: nowrap;
        }
        #bootcamp .bc-card {
            border-radius: 20px;
            overflow: hidden;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            margin: 0 16px 16px;
            display: block;
            text-decoration: none;
            color: inherit;
        }
        #bootcamp .bc-thumb {
            width: 100%;
            height: 150px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background: #e8eef3;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9aa5b1;
            font-size: 2rem;
        }
        #bootcamp .bc-card-body {
            padding: 14px 16px 16px;
        }
        #bootcamp .bc-class-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--rd-text);
            line-height: 1.25;
        }
        #bootcamp .bc-class-sub {
            font-size: 0.82rem;
            color: var(--rd-text-muted);
            margin-top: 2px;
        }
        #bootcamp .bc-progress-track {
            height: 8px;
            background: var(--rd-border);
            border-radius: 999px;
            overflow: hidden;
            margin: 12px 0 6px;
        }
        #bootcamp .bc-progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--rd-primary), var(--rd-accent, #4a90e2));
        }
        #bootcamp .bc-learn-btn {
            border: none;
            border-radius: 999px;
            padding: 9px 0;
            width: 100%;
            margin-top: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--rd-primary-contrast, #fff);
            background: var(--rd-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
        }
        #bootcamp .bc-empty {
            text-align: center;
            padding: 60px 24px;
            color: var(--rd-text-muted);
        }
        #bootcamp .bc-empty i { font-size: 2.6rem; display: block; margin-bottom: 12px; opacity: 0.6; }
        /* Modal */
        #bootcamp .bc-modal-overlay {
            position: fixed; inset: 0; z-index: 1050;
            background: rgba(15, 23, 42, 0.55);
            display: flex; align-items: flex-end; justify-content: center;
        }
        #bootcamp .bc-modal-sheet {
            width: 100%; max-width: 480px;
            background: #fff;
            border-radius: 22px 22px 0 0;
            padding: 20px 20px 28px;
        }
        #bootcamp .bc-code-input {
            border: 1.5px solid var(--rd-border);
            border-radius: 999px;
            padding: 14px 20px;
            font-size: 1.05rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            width: 100%;
            outline: none;
        }
        #bootcamp .bc-code-input:focus { border-color: var(--rd-primary); }
        #bootcamp .bc-submit-btn {
            border: none; border-radius: 999px; padding: 14px;
            font-size: 1rem; font-weight: 700; width: 100%; margin-top: 14px;
            color: var(--rd-primary-contrast, #fff); background: var(--rd-primary);
            display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;
        }
        #bootcamp .bc-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    </style>

    <!-- Heading -->
    <div class="bc-heading">
        <div class="bc-title">Bootcamp</div>
        <button type="button" class="bc-code-btn" @click="openModal">
            <i class="bi bi-key"></i> Kode Akses Kelas
        </button>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appContent py-3" style="min-height:90vh">

            <!-- Skeleton -->
            <template x-if="ui.loading && !data.classes">
                <div class="bc-card">
                    <div class="bc-thumb"><i class="bi bi-image"></i></div>
                    <div class="bc-card-body">
                        <div style="height:14px;width:60%;background:#eef2f6;border-radius:8px;margin-bottom:10px"></div>
                        <div style="height:12px;width:40%;background:#f2f5f8;border-radius:8px"></div>
                    </div>
                </div>
            </template>

            <!-- Empty state -->
            <template x-if="!ui.loading && data.classes && data.classes.length === 0">
                <div class="bc-empty">
                    <i class="bi bi-mortarboard"></i>
                    <div style="font-weight:700;font-size:1.1rem;color:var(--rd-text)">Belum ada kelas</div>
                    <p style="margin:8px 0 0;font-size:0.9rem">
                        Masukkan kode akses untuk bergabung ke kelas bootcamp.
                    </p>
                </div>
            </template>

            <!-- Daftar kelas -->
            <template x-for="(cls, i) in (data.classes || [])" :key="cls.id">
                <a class="bc-card" :href="`/bootcamp/classes/${cls.id}/learn`" @click.prevent="goLearn(cls.id)">
                    <div class="bc-thumb" :style="cls.thumbnail ? `background-image:url('${cls.thumbnail}')` : ''">
                        <i class="bi bi-mortarboard" x-show="!cls.thumbnail"></i>
                    </div>
                    <div class="bc-card-body">
                        <div class="bc-class-name" x-text="cls.name"></div>
                        <div class="bc-class-sub" x-text="cls.syllabus_name || ''"></div>
                        <div class="bc-class-sub" x-show="cls.start_date" x-text="'Mulai: ' + $heroicHelper.formatDate(cls.start_date)"></div>

                        <div class="bc-progress-track">
                            <div class="bc-progress-fill" :style="`width:${cls.progress.percent}%`"></div>
                        </div>
                        <div class="bc-class-sub" x-text="`${cls.progress.completed}/${cls.progress.total} tugas selesai (${cls.progress.percent}%)`"></div>

                        <button type="button" class="bc-learn-btn">
                            <i class="bi bi-play-fill"></i> Mulai Belajar
                        </button>
                    </div>
                </a>
            </template>

        </div>
    </div>
    <!-- * App Capsule -->

    <!-- Modal Kode Akses -->
    <div class="bc-modal-overlay" x-show="showModal" x-cloak x-transition.opacity @keydown.escape="showModal=false">
        <div class="bc-modal-sheet" @click.stop>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <div style="font-size:1.2rem;font-weight:700;color:#1c2733">Kode Akses Kelas</div>
                <button type="button" style="border:none;background:none;font-size:1.4rem;color:#9aa5b1" @click="showModal=false">&times;</button>
            </div>
            <p style="margin:0 0 14px;color:#6b7683;font-size:0.92rem">
                Masukkan kode akses yang Anda terima untuk bergabung ke kelas bootcamp.
            </p>
            <input type="text" class="bc-code-input" x-model="code" placeholder="XXXX-XXXX" maxlength="20"
                   autocomplete="off" autocapitalize="characters" @keydown.enter="redeem()">
            <button type="button" class="bc-submit-btn" :disabled="redeeming" @click="redeem()">
                <span x-show="redeeming" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <i x-show="!redeeming" class="bi bi-check2-circle"></i>
                Gunakan Kode
            </button>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('bootcamp/script') ?>
