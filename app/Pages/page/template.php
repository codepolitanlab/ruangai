<div id="page" x-data="page($params.slug)" class="header-mobile-only rd-page" x-cloak>

    <style>
        #page { min-height: 100vh; color: var(--rd-text); }
        #page .page-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            max-width: 630px;
            margin: 0 auto;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--rd-bg);
        }
        #page .page-header .back-btn {
            color: var(--rd-text);
            font-size: 1.3rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            flex-shrink: 0;
        }
        #page .page-header .page-title { font-size: 1.15rem; font-weight: 700; color: var(--rd-text); }
        #page .page-body { padding: 8px 18px 80px; max-width: 630px; margin: 0 auto; }
        #page .page-content { color: var(--rd-text-muted); font-size: 0.95rem; line-height: 1.75; }
        #page .page-content h1, #page .page-content h2, #page .page-content h3, #page .page-content h4 { color: var(--rd-text); margin: 22px 0 10px; font-weight: 700; }
        #page .page-content h2 { font-size: 1.3rem; }
        #page .page-content h3 { font-size: 1.05rem; }
        #page .page-content p { margin: 0 0 12px; }
        #page .page-content ul, #page .page-content ol { margin: 0 0 12px; padding-left: 20px; }
        #page .page-content li { margin-bottom: 6px; }
        #page .page-content b, #page .page-content strong { color: var(--rd-text); }
        #page .page-content .contact-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 10px;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            border-radius: 14px;
        }
        #page .page-content .contact-row i { font-size: 1.3rem; color: var(--rd-primary); width: 22px; text-align: center; flex-shrink: 0; }
        #page .page-content .contact-row b { display: block; color: var(--rd-text); font-size: 0.9rem; }
        #page .page-content .contact-row span { color: var(--rd-text-muted); font-size: 0.88rem; word-break: break-word; }
        #page .page-notfound { text-align: center; padding: 60px 24px; color: var(--rd-text-muted); }
    </style>

    <!-- Header -->
    <div class="page-header">
        <a href="javascript:void(0)" onclick="history.back()" class="back-btn">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div class="page-title" x-text="title"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="page-body">
            <div x-show="!notFound && page.content" class="page-content" x-html="page.content"></div>
            <div x-show="notFound" class="page-notfound">
                <i class="bi bi-file-earmark-x" style="font-size:2.6rem;display:block;margin-bottom:12px;opacity:.6"></i>
                <div style="font-weight:700;font-size:1.05rem;color:var(--rd-text)">Halaman tidak ditemukan</div>
                <p style="margin:6px 0 0;font-size:0.9rem">Halaman yang Anda cari tidak tersedia.</p>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
</div>

<?= $this->include('page/script') ?>