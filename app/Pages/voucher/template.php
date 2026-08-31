<div id="voucher" x-data="voucher()" class="header-mobile-only rd-page">

    <style>
        #voucher .voucher-heading {
            padding: 18px 20px 12px;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--rd-text);
            line-height: 1.2;
        }
        #voucher .voucher-card {
            margin: 0 16px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--rd-surface-2) 0%, var(--rd-surface) 100%);
            border: 1px solid var(--rd-border);
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        #voucher .voucher-label {
            color: var(--rd-text-muted);
            font-size: 1rem;
            margin: 0;
        }
        #voucher .voucher-input {
            border: none;
            border-radius: 999px;
            padding: 14px 22px;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: #1c2733;
            background: #fff;
            width: 100%;
            outline: none;
        }
        #voucher .voucher-input::placeholder {
            color: #9aa5b1;
            letter-spacing: 0.35em;
        }
        #voucher .voucher-btn {
            border: none;
            border-radius: 999px;
            padding: 14px;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--rd-primary-contrast);
            background: var(--rd-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            width: 100%;
            transition: opacity 0.15s ease;
        }
        #voucher .voucher-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>

    <!-- Heading -->
    <div class="voucher-heading">Klaim Voucher</div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appContent py-3" style="min-height:90vh">

            <div class="voucher-card">
                <p class="voucher-label">Masukkan kode voucher Anda di sini</p>

                <input
                    type="text"
                    class="voucher-input"
                    x-model="code"
                    placeholder="XXXXXXXXX"
                    maxlength="12"
                    autocomplete="off"
                    autocapitalize="characters"
                    @keydown.enter="redeem()">

                <button type="button" class="voucher-btn" :disabled="loading" @click="redeem()">
                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <i x-show="!loading" class="bi bi-key"></i>
                    Redeem
                </button>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('voucher/script') ?>
