<div
    id="bootcamp-intro"
    class="header-mobile-only rd-page"
    x-data="bootcamp_intro($params.id)"
    x-cloak>

    <style>
        #bootcamp-intro .bi-hero { margin: 0 20px; height: 180px; object-fit: cover; background: linear-gradient(135deg, var(--rd-primary-soft,#eef4fb), var(--rd-surface)); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 16px; border: 1px solid var(--rd-border); display: flex; align-items: center; justify-content: center; color: var(--rd-primary); font-size: 3rem; }
        #bootcamp-intro .bi-body { padding: 18px 20px 110px; }
        #bootcamp-intro .bi-title { font-size: 1.5rem; font-weight: 800; color: var(--rd-text); line-height: 1.2; }
        #bootcamp-intro .bi-sub { font-size: 0.9rem; color: var(--rd-text-muted); margin-top: 4px; }
        #bootcamp-intro .bi-desc { font-size: 0.9rem; color: var(--rd-text-muted); margin-top: 12px; line-height: 1.6; }
        #bootcamp-intro .bi-card { background: var(--rd-surface); border: 1px solid var(--rd-border); border-radius: 16px; padding: 14px 16px; margin-top: 14px; }
        #bootcamp-intro .bi-progress-track { height: 10px; background: var(--rd-border); border-radius: 999px; overflow: hidden; }
        #bootcamp-intro .bi-progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--rd-primary), var(--rd-accent,#4a90e2)); }
        #bootcamp-intro .bi-chip { display: flex; align-items: center; gap: 10px; padding: 12px 0; border-bottom: 1px solid var(--rd-border); }
        #bootcamp-intro .bi-chip:last-child { border-bottom: none; }
        #bootcamp-intro .bi-chip-icon { width: 38px; height: 38px; border-radius: 12px; background: var(--rd-primary-soft,#eef4fb); color: var(--rd-primary); display: flex; align-items: center; justify-content: center; flex: none; }
        #bootcamp-intro .bi-chip-name { font-weight: 600; font-size: 0.92rem; color: var(--rd-text); flex: 1; }
        #bootcamp-intro .bi-badge { border-radius: 999px; padding: 3px 9px; font-size: 0.7rem; font-weight: 700; flex: none; }
        #bootcamp-intro .bi-badge.done { background: #e6f6ec; color: #1a7f4b; }
        #bootcamp-intro .bi-badge.locked { background: #f3f4f6; color: #6b7280; }
        #bootcamp-intro .bi-badge.ongoing { background: #eef4fb; color: #2563eb; }
        #bootcamp-intro .bi-cta { border: none; border-radius: 999px; padding: 15px; font-size: 1.05rem; font-weight: 700; width: 100%; margin-top: 18px; color: var(--rd-primary-contrast,#fff); background: var(--rd-primary); display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; }
        #bootcamp-intro .bi-cta:disabled { opacity: 0.7; cursor: not-allowed; }

        /* Tombol kembali — disamakan dgn halaman beasiswa/intro */
        #bootcamp-intro .btn-white.bg-white {
            background-color: var(--rd-primary-soft) !important;
            color: var(--rd-primary) !important;
        }
        #bootcamp-intro .btn-white.bg-white .bi {
            color: var(--rd-primary) !important;
        }
    </style>

    <div id="appCapsule">

    <!-- Hero -->
    <template x-if="data.class">
        <div>
            <div style="display:flex;align-items:center;gap:10px;padding:12px 20px 0">
                <button type="button" class="btn rounded-4 px-2 btn-white bg-white text-primary" @click="history.back()" aria-label="Kembali">
                    <h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
                </button>
            </div>

            <div class="bi-hero" :style="data.class.thumbnail ? `background-image:url('${data.class.thumbnail}')` : ''">
                <i class="bi bi-mortarboard" x-show="!data.class.thumbnail"></i>
            </div>

            <div class="bi-body">
                <div class="bi-title" x-text="data.class.name"></div>
                <div class="bi-sub" x-text="data.syllabus?.name || ''"></div>
                <div class="bi-sub" x-show="data.class.start_date" x-text="'Mulai: ' + $heroicHelper.formatDate(data.class.start_date)"></div>
                <div class="bi-desc" x-show="data.class.description" x-text="data.class.description"></div>

                <!-- Progres -->
                <div class="bi-card">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                        <span style="font-weight:700;color:var(--rd-text)" x-text="`${data.total_completed}/${data.total_required} tugas selesai`"></span>
                        <span style="font-weight:700;color:var(--rd-text)" x-text="data.progress_percent + '%'"></span>
                    </div>
                    <div class="bi-progress-track">
                        <div class="bi-progress-fill" :style="`width:${data.progress_percent}%`"></div>
                    </div>
                </div>

                <!-- Materi -->
                <div class="bi-card" style="padding-top:6px">
                    <div style="font-weight:700;color:var(--rd-text);margin:6px 0 4px">Materi Kelas</div>
                    <template x-for="m in data.materials" :key="m.id">
                        <div class="bi-chip">
                            <div class="bi-chip-icon"><i class="bi bi-collection"></i></div>
                            <div class="bi-chip-name" x-text="m.material_title"></div>
                            <span class="bi-badge" :class="m.is_open != 1 ? 'locked' : (m.progress_percent===100 ? 'done' : 'ongoing')"
                                  x-text="m.is_open != 1 ? 'Terkunci' : (m.progress_percent + '%')"></span>
                        </div>
                    </template>
                </div>

                <button type="button" class="bi-cta" @click="goLearn()">
                    <i class="bi" :class="data.progress_percent > 0 ? 'bi-arrow-repeat' : 'bi-play-fill'"></i>
                    <span x-text="data.progress_percent > 0 ? 'Lanjut Belajar' : 'Mulai Belajar'"></span>
                </button>
            </div>
        </div>
    </template>

    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('bootcamp/intro/script') ?>
