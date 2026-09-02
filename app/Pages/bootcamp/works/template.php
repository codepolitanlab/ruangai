<div id="bootcamp-works" x-data="bootcamp_works()" class="header-mobile-only rd-page">

    <style>
        #bootcamp-works .wk-heading { padding: 18px 20px 10px; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        #bootcamp-works .appContent { padding-bottom: 110px; }
        #bootcamp-works .wk-title { font-size: 1.7rem; font-weight: 700; color: var(--rd-text); line-height: 1.2; }
        #bootcamp-works .wk-create-btn { border: none; border-radius: 999px; padding: 10px 16px; font-size: 0.9rem; font-weight: 600; color: var(--rd-primary-contrast,#fff); background: var(--rd-primary); display: inline-flex; align-items: center; gap: 6px; cursor: pointer; white-space: nowrap; }
        #bootcamp-works .wk-filters { display: flex; gap: 8px; padding: 8px 16px 4px; overflow-x: auto; }
        #bootcamp-works .wk-filter { border: 1.5px solid var(--rd-border); background: none; border-radius: 999px; padding: 7px 14px; font-size: 0.82rem; font-weight: 600; color: var(--rd-text-muted); cursor: pointer; white-space: nowrap; }
        #bootcamp-works .wk-filter.active { background: var(--rd-primary); border-color: var(--rd-primary); color: var(--rd-primary-contrast,#fff); }
        #bootcamp-works .wk-card { border-radius: 18px; overflow: hidden; background: var(--rd-surface); border: 1px solid var(--rd-border); margin: 12px 16px; }
        #bootcamp-works .wk-thumb { width: 100%; height: 150px; background-size: cover; background-position: center; background-repeat: no-repeat; background: #e8eef3; display: flex; align-items: center; justify-content: center; color: #9aa5b1; font-size: 2rem; }
        #bootcamp-works .wk-body { padding: 13px 16px 16px; }
        #bootcamp-works .wk-name { font-weight: 700; color: var(--rd-text); font-size: 1rem; }
        #bootcamp-works .wk-short { font-size: 0.85rem; color: var(--rd-text-muted); margin-top: 4px; }
        #bootcamp-works .wk-badge { border-radius: 999px; padding: 3px 10px; font-size: 0.72rem; font-weight: 700; }
        #bootcamp-works .wk-badge.pending { background: #fff6e6; color: #b26a00; }
        #bootcamp-works .wk-badge.published { background: #e6f6ec; color: #1a7f4b; }
        #bootcamp-works .wk-badge.rejected { background: #fdecec; color: #c0392b; }
        #bootcamp-works .wk-empty { text-align: center; padding: 60px 24px; color: var(--rd-text-muted); }
        #bootcamp-works .wk-empty i { font-size: 2.6rem; display: block; margin-bottom: 12px; opacity: 0.6; }
        #bootcamp-works .wk-action { border: none; background: none; color: var(--rd-text-muted); font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; }
        #bootcamp-works .wk-action:hover { color: var(--rd-primary); }
        #bootcamp-works .wk-modal-overlay { position: fixed; inset: 0; z-index: 1050; background: rgba(15,23,42,0.55); display: flex; align-items: flex-end; justify-content: center; }
        #bootcamp-works .wk-modal-sheet { width: 100%; max-width: 480px; max-height: 92vh; overflow-y: auto; background: #fff; border-radius: 22px 22px 0 0; padding: 20px 20px 28px; }
        #bootcamp-works .wk-field { width: 100%; border: 1.5px solid var(--rd-border); border-radius: 12px; padding: 11px 14px; font-size: 0.9rem; outline: none; margin-top: 6px; background: #fff; }
        #bootcamp-works .wk-field:focus { border-color: var(--rd-primary); }
        #bootcamp-works .wk-label { font-size: 0.82rem; color: var(--rd-text-muted); margin-top: 12px; display: block; }
        #bootcamp-works .wk-save { border: none; border-radius: 999px; padding: 13px; font-size: 1rem; font-weight: 700; width: 100%; margin-top: 18px; color: var(--rd-primary-contrast,#fff); background: var(--rd-primary); cursor: pointer; }
        #bootcamp-works .wk-save:disabled { opacity: 0.7; cursor: not-allowed; }
    </style>

    <!-- Heading -->
    <div class="wk-heading">
        <div class="wk-title">Karya Saya</div>
        <button type="button" class="wk-create-btn" @click="openCreate()">
            <i class="bi bi-plus-lg"></i> Buat Karya
        </button>
    </div>

    <!-- Filter -->
    <div class="wk-filters">
        <button type="button" class="wk-filter" :class="{active: filter===''}" @click="setFilter('')">Semua</button>
        <button type="button" class="wk-filter" :class="{active: filter==='pending'}" @click="setFilter('pending')">Pending</button>
        <button type="button" class="wk-filter" :class="{active: filter==='published'}" @click="setFilter('published')">Published</button>
        <button type="button" class="wk-filter" :class="{active: filter==='rejected'}" @click="setFilter('rejected')">Rejected</button>
    </div>

    <div id="appCapsule">
        <div class="appContent py-2" style="min-height:90vh">

            <!-- Empty -->
            <div class="wk-empty" x-show="!ui.loading && data.works && data.works.length===0">
                <i class="bi bi-images"></i>
                <div style="font-weight:700;font-size:1.1rem;color:var(--rd-text)">Belum ada karya</div>
                <p style="margin:8px 0 0;font-size:0.9rem">Bagikan hasil karya bootcamp Anda di sini.</p>
            </div>

            <!-- List karya -->
            <template x-for="w in (data.works || [])" :key="w.id">
                <div class="wk-card">
                    <div class="wk-thumb" :style="w.thumbnail ? `background-image:url('${w.thumbnail}')` : ''">
                        <i class="bi bi-image" x-show="!w.thumbnail"></i>
                    </div>
                    <div class="wk-body">
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
                            <div style="flex:1;min-width:0">
                                <div class="wk-name" x-text="w.title"></div>
                                <div class="wk-short" x-show="w.short_description" x-text="w.short_description"></div>
                            </div>
                            <span class="wk-badge" :class="w.status" x-text="w.status"></span>
                        </div>
                        <div style="display:flex;gap:14px;margin-top:12px;border-top:1px solid var(--rd-border);padding-top:10px">
                            <a class="wk-action" x-show="w.url_project" :href="w.url_project" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right"></i> Lihat</a>
                            <button type="button" class="wk-action" x-show="w.status==='pending'" @click="openEdit(w)"><i class="bi bi-pencil"></i> Edit</button>
                            <button type="button" class="wk-action" @click="remove(w)"><i class="bi bi-trash"></i> Hapus</button>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>

    <!-- Modal form -->
    <div class="wk-modal-overlay" x-show="showModal" x-cloak x-transition.opacity @keydown.escape="showModal=false">
        <div class="wk-modal-sheet" @click.stop>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
                <div style="font-size:1.2rem;font-weight:700;color:#1c2733" x-text="editing ? 'Edit Karya' : 'Buat Karya'"></div>
                <button type="button" style="border:none;background:none;font-size:1.4rem;color:#9aa5b1" @click="showModal=false">&times;</button>
            </div>
            <p style="margin:0 0 6px;color:#6b7683;font-size:0.85rem">Karya akan masuk status <b>Pending</b> dan menunggu moderasi admin.</p>

            <label class="wk-label">Judul Karya *</label>
            <input type="text" class="wk-field" x-model="form.title" placeholder="cth: Landing Page Portofolio">

            <label class="wk-label">Deskripsi Singkat (maks. 500)</label>
            <textarea class="wk-field" rows="2" maxlength="500" x-model="form.short_description" placeholder="Ringkasan singkat karya Anda"></textarea>

            <label class="wk-label">Deskripsi Lengkap</label>
            <textarea class="wk-field" rows="3" x-model="form.description" placeholder="Ceritakan detail karya Anda"></textarea>

            <label class="wk-label">URL Thumbnail</label>
            <input type="url" class="wk-field" x-model="form.thumbnail" placeholder="https://...">

            <label class="wk-label">Galeri (URL gambar, bisa lebih dari satu)</label>
            <template x-for="(photo, idx) in form.photos" :key="idx">
                <div style="display:flex;gap:6px;align-items:center">
                    <input type="url" class="wk-field" x-model="form.photos[idx]" :placeholder="'Foto ' + (idx+1) + ' (URL)'">
                    <button type="button" style="border:none;background:none;color:#c0392b;font-size:1.2rem" @click="form.photos.splice(idx,1)">&times;</button>
                </div>
            </template>
            <button type="button" class="wk-action" style="margin-top:8px" @click="form.photos.push('')"><i class="bi bi-plus-circle"></i> Tambah Foto</button>

            <label class="wk-label">URL Project</label>
            <input type="url" class="wk-field" x-model="form.url_project" placeholder="https://github.com/... atau link deploy">

            <button type="button" class="wk-save" :disabled="saving" @click="save()">
                <span x-show="saving" class="spinner-border spinner-border-sm" role="status"></span>
                <span x-show="!saving"><i class="bi bi-check2-circle"></i> Simpan Karya</span>
            </button>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('bootcamp/works/script') ?>
