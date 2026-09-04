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

        /* Produk kelas tersedia */
        #bootcamp .bc-products {
            margin: 6px 0 8px;
            padding: 6px 16px 0;
        }
        #bootcamp .bc-products-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--rd-text);
        }
        #bootcamp .bc-products-sub {
            font-size: 0.85rem;
            color: var(--rd-text-muted);
            margin: 2px 0 14px;
        }
        #bootcamp .bc-product-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        #bootcamp .bc-product-card {
            display: flex;
            align-items: stretch;
            background: var(--rd-surface-2);
            border: 1px solid var(--rd-border);
            border-radius: 18px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        }
        #bootcamp .bc-product-thumb {
            position: relative;
            width: 125px; /* +30% dari 96px */
            flex: 0 0 125px;
            background-size: cover;
            background-position: center;
            background-color: #e8eef3;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9aa5b1;
            font-size: 1.6rem;
            overflow: hidden;
        }
        #bootcamp .bc-product-date {
            position: absolute;
            left: 6px;
            right: 6px;
            bottom: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            background: rgba(15, 23, 42, 0.72);
            color: #fff;
            font-size: 0.66rem;
            font-weight: 600;
            line-height: 1.2;
            padding: 3px 6px;
            border-radius: 999px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #bootcamp .bc-product-thumb--lg {
            width: 100%;
            min-height: 160px;
            border-radius: 14px;
            font-size: 2.4rem;
            margin-bottom: 14px;
        }
        #bootcamp .bc-product-body {
            flex: 1;
            padding: 12px 14px 12px;
            min-width: 0;
        }
        #bootcamp .bc-product-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--rd-text);
            line-height: 1.25;
        }
        #bootcamp .bc-product-sub {
            font-size: 0.8rem;
            color: var(--rd-text-muted);
            margin-top: 2px;
        }
        #bootcamp .bc-product-price-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-top: 8px;
        }
        #bootcamp .bc-product-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--rd-primary);
        }
        #bootcamp .bc-product-price-old {
            font-size: 1rem;
            color: var(--rd-text-muted);
            text-decoration: line-through;
        }
        #bootcamp .bc-modal-sheet--tall {
            max-height: 84vh;
            overflow-y: auto;
        }
        #bootcamp .bc-modal-overlay--center {
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        #bootcamp .bc-modal-overlay--center .bc-modal-sheet {
            border-radius: 5px;
        }
        #bootcamp .bc-pd-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #1c2733;
            line-height: 1.3;
        }
        #bootcamp .bc-pd-sub {
            font-size: 0.9rem;
            color: #6b7683;
            margin-top: 2px;
        }
        #bootcamp .bc-pd-meta {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 16px 0;
            padding: 14px;
            background: #f6f8fa;
            border-radius: 14px;
        }
        #bootcamp .bc-pd-meta-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #bootcamp .bc-pd-meta-item > i {
            font-size: 1.2rem;
            color: var(--rd-primary);
            width: 22px;
            text-align: center;
        }
        #bootcamp .bc-pd-meta-label {
            font-size: 0.72rem;
            color: #9aa5b1;
        }
        #bootcamp .bc-pd-meta-value {
            font-size: 0.92rem;
            font-weight: 600;
            color: #1c2733;
        }
        #bootcamp .bc-pd-desc {
            margin: 4px 0 14px;
        }
        #bootcamp .bc-pd-desc-title {
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #9aa5b1;
            margin-bottom: 4px;
        }
        #bootcamp .bc-pd-desc-text {
            font-size: 0.92rem;
            color: #1c2733;
            line-height: 1.55;
            white-space: pre-line;
        }
        #bootcamp .bc-pd-price-box {
            display: flex;
            flex-direction: column;
            margin: 6px 0 4px;
            padding: 14px 0 6px;
            border-top: 1px dashed #e6eaef;
        }
        #bootcamp .bc-pd-price-label {
            font-size: 1rem;
            color: #6b7683;
        }
        #bootcamp .bc-pd-price-line {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-top: 2px;
        }
        #bootcamp .bc-pd-price-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1c2733;
        }
        #bootcamp .bc-pd-save {
            font-size: 0.78rem;
            font-weight: 700;
            color: #0a9a4b;
            background: rgba(10, 154, 75, 0.12);
            padding: 4px 8px;
            border-radius: 999px;
            white-space: nowrap;
        }
    </style>

    <!-- Heading -->
    <div class="bc-heading">
        <div class="bc-title">Bootcamp</div>
        <!-- <button type="button" class="bc-code-btn" @click="openModal">
            <i class="bi bi-key"></i> Kode Akses Kelas
        </button> -->
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
                    <div style="font-weight:700;font-size:1.1rem;color:var(--rd-text)">Belum ada kelas yang Anda ikuti</div>
                    <p style="margin:8px 0 0;font-size:0.9rem">
                        Masukkan kode akses untuk bergabung, atau pilih program bootcamp tersedia di bawah.
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

            <!-- Produk kelas aktif yang bisa dibeli -->
            <template x-if="data.products && data.products.length > 0">
                <div class="bc-products">
                    <div class="bc-products-title">Bootcamp Tersedia</div>
                    <div class="bc-products-sub">Klik program untuk melihat detail kelas &amp; mendaftar.</div>

                    <div class="bc-product-list">
                        <template x-for="(prod, i) in data.products" :key="prod.id">
                            <div class="bc-product-card" @click="openProduct(prod)">
                                <div class="bc-product-thumb" :style="prod.class_thumbnail ? `background-image:url('${prod.class_thumbnail}')` : ''">
                                    <i class="bi bi-mortarboard" x-show="!prod.class_thumbnail"></i>
                                    <span class="bc-product-date" x-show="prod.class_start_date">
                                        <i class="bi bi-calendar3"></i>
                                        <span x-text="$heroicHelper.formatDate(prod.class_start_date)"></span>
                                    </span>
                                </div>
                                <div class="bc-product-body">
                                    <div class="bc-product-title" x-text="prod.title || ''"></div>
                                    <div class="bc-product-sub" x-text="prod.subtitle || ''"></div>
                                    <div class="bc-product-price-row">
                                        <template x-if="prod.normal_price > prod.price">
                                            <span class="bc-product-price-old" x-text="'Rp' + $heroicHelper.currency(prod.normal_price)"></span>
                                        </template>
                                        <span class="bc-product-price" x-text="'Rp' + $heroicHelper.currency(prod.price)"></span>
                                    </div>
                                    <button type="button" class="bc-learn-btn" @click.stop="openProduct(prod)">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
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

    <!-- Modal Detail Produk Kelas -->
    <div class="bc-modal-overlay bc-modal-overlay--center" x-show="productModal" x-cloak @click="closeProduct()" @keydown.escape="closeProduct()">
        <div class="bc-modal-sheet bc-modal-sheet--tall" @click.stop>
            <template x-if="selectedProduct">
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                        <!-- <div style="font-size:1.15rem;font-weight:700;color:#1c2733" x-text="selectedProduct.title || 'Detail Bootcamp'"></div> -->
                        <button type="button" style="border:none;background:none;font-size:1.4rem;color:#9aa5b1" @click="closeProduct()">&times;</button>
                    </div>

                    <div class="bc-product-thumb bc-product-thumb--lg"
                         :style="selectedProduct.class_thumbnail ? `background-image:url('${selectedProduct.class_thumbnail}')` : ''">
                        <i class="bi bi-mortarboard" x-show="!selectedProduct.class_thumbnail"></i>
                    </div>

                    <div class="bc-pd-title" x-text="selectedProduct.title || ''"></div>
                    <div class="bc-pd-sub" x-text="selectedProduct.subtitle || ''"></div>

                    <div class="bc-pd-price-box">
                        <div>
                            <div class="bc-pd-price-label">Harga Program</div>
                            <div class="bc-pd-price-line">
                                <template x-if="selectedProduct.normal_price > selectedProduct.price">
                                    <span class="bc-product-price-old" x-text="'Rp' + $heroicHelper.currency(selectedProduct.normal_price)"></span>
                                </template>
                            </div>
                        </div>
                        <div>
                            <span class="bc-pd-price-value" x-text="'Rp' + $heroicHelper.currency(selectedProduct.price)"></span>
                            <span class="bc-pd-save" x-show="selectedProduct.discount > 0" x-text="`Hemat Rp${$heroicHelper.currency(selectedProduct.discount)}`"></span>
                        </div>
                    </div>

                    <button type="button" class="bc-submit-btn" :disabled="checkingOut" @click="checkout()">
                        <span x-show="checkingOut" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <i x-show="!checkingOut" class="bi bi-credit-card"></i>
                        Daftar Program
                    </button>

                    <div class="bc-pd-meta">
                        <div class="bc-pd-meta-item">
                            <i class="bi bi-easel"></i>
                            <div>
                                <div class="bc-pd-meta-label">Kelas</div>
                                <div class="bc-pd-meta-value" x-text="selectedProduct.class_name || '-' "></div>
                            </div>
                        </div>
                        <div class="bc-pd-meta-item" x-show="selectedProduct.syllabus_name">
                            <i class="bi bi-journal-text"></i>
                            <div>
                                <div class="bc-pd-meta-label">Program / Silabus</div>
                                <div class="bc-pd-meta-value" x-text="selectedProduct.syllabus_name"></div>
                            </div>
                        </div>
                        <div class="bc-pd-meta-item" x-show="selectedProduct.class_start_date">
                            <i class="bi bi-calendar3"></i>
                            <div>
                                <div class="bc-pd-meta-label">Mulai</div>
                                <div class="bc-pd-meta-value" x-text="$heroicHelper.formatDate(selectedProduct.class_start_date)"></div>
                            </div>
                        </div>
                        <div class="bc-pd-meta-item" x-show="selectedProduct.material_count">
                            <i class="bi bi-collection-play"></i>
                            <div>
                                <div class="bc-pd-meta-label">Jumlah Materi</div>
                                <div class="bc-pd-meta-value" x-text="`${selectedProduct.material_count} pertemuan`"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bc-pd-desc" x-show="selectedProduct.description || selectedProduct.class_description">
                        <div class="bc-pd-desc-title">Deskripsi</div>
                        <div class="bc-pd-desc-text" x-text="selectedProduct.description || selectedProduct.class_description || ''"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('bootcamp/script') ?>
