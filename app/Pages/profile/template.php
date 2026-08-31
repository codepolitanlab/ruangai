<div id="profile" x-data="profile()" class="header-mobile-only rd-page">

    <style>
        #profile .account-heading {
            padding: 18px 20px 12px;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--rd-text);
            line-height: 1.2;
        }
        #profile .account-hero {
            position: relative;
            margin: 0 16px;
            z-index: 1;
        }
        #profile .account-hero::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -30px;
            transform: translateX(-50%);
            width: 160px;
            height: 60px;
            border-radius: 50%;
            background: var(--rd-surface);
            z-index: 1;
        }
        #profile .account-hero-inner {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--rd-surface-2) 0%, var(--rd-surface) 100%);
            border: 1px solid var(--rd-border);
            color: var(--rd-text);
            padding: 26px 20px 46px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        #profile .account-hero-inner::before {
            content: "";
            position: absolute;
            right: -40px;
            top: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--rd-primary-soft) 0%, transparent 70%);
            pointer-events: none;
        }
        #profile .account-avatar {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: var(--rd-primary);
            color: #fff;
            font-weight: 800;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            letter-spacing: 0.5px;
        }
        #profile .account-name {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--rd-text);
        }
        #profile .account-bio {
            font-size: 0.9rem;
            color: var(--rd-text-muted);
            margin-top: 2px;
        }
        #profile .account-card {
            position: relative;
            z-index: 2;
            margin: -18px 14px 0;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            border-radius: 24px 24px 0 0;
            padding: 26px 18px 60px;
        }
        #profile .account-list-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--rd-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin: 0 8px 8px;
        }
        #profile .account-list-title span {
            float: right;
            text-transform: none;
            font-weight: 500;
            color: var(--rd-text-muted);
        }
        #profile .account-menu {
            list-style: none;
            margin: 0 0 18px;
            padding: 0;
        }
        #profile .account-menu li {
            border-top: 1px solid var(--rd-border);
        }
        #profile .account-menu li:first-child {
            border-top: none;
        }
        #profile .account-menu .item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 8px;
            color: var(--rd-text);
            text-decoration: none;
            font-size: 1rem;
        }
        #profile .account-menu .item > i:first-child {
            width: 22px;
            text-align: center;
            font-size: 1.15rem;
            color: var(--rd-primary);
        }
        #profile .account-menu .item span {
            flex: 1;
        }
        #profile .account-menu .item > i:last-child {
            color: var(--rd-text-muted);
        }
    </style>

    <!-- Heading Akun -->
    <div class="account-heading">Akun</div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appContent px-0" style="min-height:90vh">

            <!-- Banner identitas -->
            <div class="account-hero">
                <div class="account-hero-inner">
                    <div class="account-avatar" x-text="initials(data?.profile?.user?.name)"></div>
                    <div>
                        <div class="account-name" x-text="data?.profile?.user?.name || 'Undefined'"></div>
                        <div class="account-bio">Belum ada bio</div>
                    </div>
                </div>
            </div>

            <!-- Kartu menu -->
            <div class="account-card">
                <div class="account-list-title">Personalisasi Akun</div>
                <ul class="account-menu">
                    <li>
                        <a href="/profile/edit_info" class="item">
                            <i class="bi bi-pencil"></i>
                            <span>Edit Profil</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>

                <div class="account-list-title mt-4">
                    Aplikasi RuangAI
                    <span>v<?= $version; ?></span>
                </div>
                <ul class="account-menu">
                    <li>
                        <a href="/page/about-app" class="item">
                            <i class="bi bi-info-circle"></i>
                            <span>Tentang Aplikasi</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/page/contact-us" class="item">
                            <i class="bi bi-telephone"></i>
                            <span>Kontak Kami</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/page/tnc" class="item">
                            <i class="bi bi-file-earmark-ruled"></i>
                            <span>Syarat dan Ketentuan</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/page/privacy" class="item">
                            <i class="bi bi-shield-exclamation"></i>
                            <span>Kebijakan Privasi</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>

                <ul class="account-menu">
                    <li>
                        <a native href="javascript:void(0)" x-on:click="logout" class="item">
                            <i class="bi bi-lock text-danger"></i>
                            <span class="text-danger">Keluar</span>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('profile/script') ?>