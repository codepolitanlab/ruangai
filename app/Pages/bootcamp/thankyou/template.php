<div
    id="bootcamp-thankyou"
    class="header-mobile-only rd-page"
    x-data="bootcamp_thankyou($params.checkout_code)"
    x-cloak>

    <style>
        #bootcamp-thankyou { --ty-radius: 18px; }
        #bootcamp-thankyou .ty-body { padding: 22px 20px 40px; }
        #bootcamp-thankyou .ty-hero { text-align: center; padding: 10px 0 6px; }
        #bootcamp-thankyou .ty-hero-icon {
            width: 84px; height: 84px; border-radius: 50%;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, var(--rd-primary), var(--rd-accent, #4a90e2));
            color: var(--rd-primary-contrast, #fff);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.4rem;
        }
        #bootcamp-thankyou .ty-hero h1 {
            font-size: 1.45rem; font-weight: 800; color: var(--rd-text);
            line-height: 1.3; margin: 0;
        }
        #bootcamp-thankyou .ty-hero p { font-size: .92rem; color: var(--rd-text-muted); margin: 8px 0 0; }
        #bootcamp-thankyou .ty-card {
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            border-radius: var(--ty-radius);
            padding: 16px;
            margin-top: 14px;
        }
        #bootcamp-thankyou .ty-card p { margin: 6px 0 0; color: var(--rd-text-muted); font-size: .92rem; line-height: 1.55; }
        #bootcamp-thankyou .ty-greet { font-weight: 700; color: var(--rd-text); }
        #bootcamp-thankyou .ty-code-label {
            font-size: .78rem; font-weight: 700; letter-spacing: .4px;
            text-transform: uppercase; color: var(--rd-text-muted); margin-bottom: 8px;
        }
        #bootcamp-thankyou .ty-code {
            background: var(--rd-primary);
            color: var(--rd-primary-contrast, #fff);
            border-radius: 12px;
            padding: 16px 10px;
            text-align: center;
            font-size: 1.5rem; font-weight: 800; letter-spacing: 5px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            margin-bottom: 10px;
        }
        #bootcamp-thankyou .ty-steps-title { font-weight: 800; color: var(--rd-text); font-size: 1.05rem; }
        #bootcamp-thankyou .ty-steps { margin: 10px 0 0; padding-left: 20px; }
        #bootcamp-thankyou .ty-steps li { color: var(--rd-text-muted); font-size: .9rem; line-height: 1.6; margin-bottom: 8px; }
        #bootcamp-thankyou .ty-steps b { color: var(--rd-text); }
        #bootcamp-thankyou .ty-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; border: none; border-radius: 999px;
            padding: 15px; font-size: 1rem; font-weight: 700;
            margin-top: 14px; cursor: pointer;
        }
        #bootcamp-thankyou .ty-btn-primary { background: var(--rd-primary); color: var(--rd-primary-contrast, #fff); }
        #bootcamp-thankyou .ty-btn-ghost { background: var(--rd-primary-soft, #eef4fb); color: var(--rd-primary); }
        #bootcamp-thankyou .ty-state { text-align: center; padding: 40px 10px; }
        #bootcamp-thankyou .ty-state-icon {
            width: 72px; height: 72px; border-radius: 50%;
            margin: 0 auto 14px; background: #f3f4f6; color: #9aa5b1;
            display: flex; align-items: center; justify-content: center; font-size: 2rem;
        }
        #bootcamp-thankyou .ty-spinner {
            width: 46px; height: 46px;
            border: 4px solid var(--rd-border); border-top-color: var(--rd-primary);
            border-radius: 50%; margin: 60px auto 16px;
            animation: ty-spin 1s linear infinite;
        }
        @keyframes ty-spin { to { transform: rotate(360deg); } }
    </style>

    <div id="appCapsule">
        <div class="ty-body">

            <!-- Loading -->
            <div x-show="ui.loading" class="ty-state">
                <div class="ty-spinner"></div>
                <p class="mb-0" style="color:var(--rd-text-muted);font-size:.9rem">Menyiapkan halaman…</p>
            </div>

            <!-- Transaksi tidak ditemukan (HTTP 404) -->
            <template x-if="ui.error">
                <div>
                    <div class="ty-state">
                        <div class="ty-state-icon"><i class="bi bi-search"></i></div>
                        <h2 class="h5 mb-1" style="color:var(--rd-text);font-weight:800">Transaksi tidak ditemukan</h2>
                        <p style="color:var(--rd-text-muted);font-size:.9rem;margin:6px 0 0">
                            Kode checkout tidak valid atau pembayaran belum selesai diproses.
                            Kode akses juga dikirim ke email kamu setelah pembayaran berhasil.
                        </p>
                    </div>
                    <button type="button" class="ty-btn ty-btn-ghost" @click="goBootcamp()">
                        <i class="bi bi-arrow-left"></i> Kembali ke Bootcamp
                    </button>
                </div>
            </template>

            <!-- Sukses -->
            <template x-if="!ui.loading && !ui.error && data && data.voucher_code">
                <div>
                    <div class="ty-hero">
                        <div class="ty-hero-icon"><i class="bi bi-check-lg"></i></div>
                        <h1>Terima kasih sudah mendaftar program bootcamp!</h1>
                        <p>Pembayaranmu berhasil kami terima.</p>
                    </div>

                    <div class="ty-card">
                        <div class="ty-greet">Halo <span x-text="data.name || 'Peserta'"></span>,</div>
                        <p>Terima kasih atas pembelian kelas bootcamp <strong x-text="data.product_title"></strong> di RuangAI.</p>
                        <p style="margin-top:10px">Berikut adalah <strong>Kode Voucher untuk enroll ke bootcamp</strong>:</p>
                    </div>

                    <div class="ty-card">
                        <div class="ty-code-label">Kode Voucher</div>
                        <div class="ty-code" x-text="data.voucher_code"></div>
                        <button type="button" class="ty-btn ty-btn-ghost" style="margin-top:0" @click="copyCode()">
                            <i class="bi" :class="copied ? 'bi-check-lg' : 'bi-clipboard'"></i>
                            <span x-text="copied ? 'Kode disalin!' : 'Salin Kode'"></span>
                        </button>
                    </div>

                    <template x-if="data.claimed">
                        <div class="ty-card" style="background:#e6f6ec;border-color:transparent">
                            <p style="color:#1a7f4b;font-weight:600">
                                <i class="bi bi-check-circle-fill"></i> Kode sudah kamu gunakan — kamu sudah terdaftar sebagai peserta kelas ini.
                            </p>
                        </div>
                    </template>

                    <div class="ty-card">
                        <div class="ty-steps-title">Langkah Selanjutnya</div>
                        <ol class="ty-steps">
                            <li>Login ke akun RuangAI kamu. <b>Registrasi terlebih dahulu</b> bila belum punya akun di RuangAI.</li>
                            <li>Buka halaman <b>Klaim Voucher</b>, lalu masukkan kode di atas.</li>
                            <li>Kamu akan otomatis terdaftar sebagai peserta kelas bootcamp <b x-text="data.product_title"></b>.</li>
                        </ol>
                    </div>

                    <button type="button" class="ty-btn ty-btn-primary" @click="goRedeem()">
                        <i class="bi" :class="data.claimed ? 'bi-mortarboard' : 'bi-ticket'"></i>
                        <span x-text="data.claimed ? 'Buka Kelas Saya' : 'Klaim Voucher Sekarang'"></span>
                    </button>
                </div>
            </template>

        </div>
    </div>
</div>

<?= $this->include('bootcamp/thankyou/script') ?>
