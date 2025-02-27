<div id="course_detail" x-data="course_detail()">
    <div id="app-header" class="appHeader main glassmorph">
        <div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
        <div class="pageTitle"><span>Detail Lessons</span></div>
    </div>

    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh">
            <style>
                .accordion-body {
                    padding: 0 .25rem;
                }

                .list-group-item {
                    border: 0;
                }

                .accordion-body,
                .accordion-body .list-group-item {
                    background: #fff !important;
                }

                .hovered:hover {
                    background: #eee !important;
                }

                .cover {
                    object-fit: cover;
                    width: 100%;
                    height: 100%;
                }

                .progress,
                .progress-bar {
                    height: 22px;
                }

                .lessons a {
                    color: #009688;
                    font-weight: 400;
                    font-size: 1rem;
                }

                .author img {
                    width: 80px;
                }
            </style>
            <div class="ratio ratio-16x9">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/LPu_sxQWmpo?si=7uHLovsFWRIqe-CB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <h1 class="h5 px-2 mt-2 mb-3">Selamat Datang</h1>
            <div class="course-action mt-3 border-top pt-3 mx-3 d-flex justify-content-end" id="next-action" data-hash="d4a6e60951884541301404ad73ac8b8d" data-current="1" data-cid="1" data-next="2"><button class="btn btn-outline-primary btn" id="button-next" onclick="nextLesson()">Berikutnya &nbsp;<i class="bi bi-arrow-right"></i></button></div>
            <div class="container mt-5">
                <h5 class="mb-0" id="listMateriLabel">List Materi</h5>
                <div class="text-secondary small mb-2 fw-bold">Pengenalan</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between bg-primary text-light" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/1/1"><i class="bi bi-check-circle-fill text-light"></i>
                    <div class="mx-2" style="width:100%" id="lesson_1" data-url="courses/learn/ngonten-sakti-dengan-ai/1/1">Selamat Datang</div><span class="ms-auto">(03:29)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/1/2"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_2" data-url="courses/learn/ngonten-sakti-dengan-ai/1/2">Kontrak Belajar</div><span class="ms-auto">(02:27)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">02 - AI dan Perkembangannya</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/2/3"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_3" data-url="courses/learn/ngonten-sakti-dengan-ai/2/3">Mengenal Artificial Intelligence</div><span class="ms-auto">(04:05)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/2/4"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_4" data-url="courses/learn/ngonten-sakti-dengan-ai/2/4">Sejarah Artificial Intelligence</div><span class="ms-auto">(05:16)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/2/5"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_5" data-url="courses/learn/ngonten-sakti-dengan-ai/2/5">AI dalam Teknologi Saat Ini</div><span class="ms-auto">(08:13)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/2/6"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_6" data-url="courses/learn/ngonten-sakti-dengan-ai/2/6">Potensi dan Tantangan AI</div><span class="ms-auto">(09:26)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/2/7"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_7" data-url="courses/learn/ngonten-sakti-dengan-ai/2/7">Prinsip Kreasi Konten dengan AI</div><span class="ms-auto">(6:57)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/2/8"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_8" data-url="courses/learn/ngonten-sakti-dengan-ai/2/8">ChatGPT dan Midjourney</div><span class="ms-auto">(01:35)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Mengenal ChatGPT</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/9"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_9" data-url="courses/learn/ngonten-sakti-dengan-ai/3/9">Berkenalan dengan ChatGPT</div><span class="ms-auto">(02:51)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/10"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_10" data-url="courses/learn/ngonten-sakti-dengan-ai/3/10">Cara Kerja ChatGPT</div><span class="ms-auto">(03:16)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/11"><i class="bi bi-check-circle-fill text-success"></i>
                    <div class="mx-2" style="width:100%" id="lesson_11" data-url="courses/learn/ngonten-sakti-dengan-ai/3/11">Kemampuan ChatGPT</div><span class="ms-auto">(02:29)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/12"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_12" data-url="courses/learn/ngonten-sakti-dengan-ai/3/12">Keterbatasan ChatGPT</div><span class="ms-auto">(03:13)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/13"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_13" data-url="courses/learn/ngonten-sakti-dengan-ai/3/13">Membuat Akun ChatGPT</div><span class="ms-auto">(02:58)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/14"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_14" data-url="courses/learn/ngonten-sakti-dengan-ai/3/14">Prompt ChatGPT</div><span class="ms-auto">(12:34)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/3/15"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_15" data-url="courses/learn/ngonten-sakti-dengan-ai/3/15">ChatGPT Plus</div><span class="ms-auto">(05:23)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Praktik Menggunakan ChatGPT</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/16"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_16" data-url="courses/learn/ngonten-sakti-dengan-ai/4/16">ChatGPT Sebagai Teman Virtual</div><span class="ms-auto">(10:57)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/17"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_17" data-url="courses/learn/ngonten-sakti-dengan-ai/4/17">ChatGPT Sebagai Teman Brainstorming</div><span class="ms-auto">(10:57)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/18"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_18" data-url="courses/learn/ngonten-sakti-dengan-ai/4/18">ChatGPT Sebagai Alat Menulis</div><span class="ms-auto">(10:42)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/19"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_19" data-url="courses/learn/ngonten-sakti-dengan-ai/4/19">ChatGPT Sebagai Bantuan Belajar</div><span class="ms-auto">(10:44)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/20"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_20" data-url="courses/learn/ngonten-sakti-dengan-ai/4/20">ChatGPT Sebagai Penerjemah Bahasa</div><span class="ms-auto">(04:41)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/21"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_21" data-url="courses/learn/ngonten-sakti-dengan-ai/4/21">ChatGPT Sebagai Pembuat Kode Program</div><span class="ms-auto">(06:33)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/22"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_22" data-url="courses/learn/ngonten-sakti-dengan-ai/4/22">ChatGPT Sebagai Penyedia Informasi</div><span class="ms-auto">(05:48)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/4/23"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_23" data-url="courses/learn/ngonten-sakti-dengan-ai/4/23">ChatGPT Sebagai Pembuat Rangkuman</div><span class="ms-auto">(03:07)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Mengenal Midjourney</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/24"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_24" data-url="courses/learn/ngonten-sakti-dengan-ai/5/24">Berkenalan dengan Midjourney</div><span class="ms-auto">(05:04)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/25"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_25" data-url="courses/learn/ngonten-sakti-dengan-ai/5/25">Cara Kerja Midjourney</div><span class="ms-auto">(05:13)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/26"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_26" data-url="courses/learn/ngonten-sakti-dengan-ai/5/26">Keuntungan Menggunakan Midjourney</div><span class="ms-auto">(02:41)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/27"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_27" data-url="courses/learn/ngonten-sakti-dengan-ai/5/27">Kemampuan Midjourney</div><span class="ms-auto">(02:26)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/28"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_28" data-url="courses/learn/ngonten-sakti-dengan-ai/5/28">Keterbatasan Midjourney</div><span class="ms-auto">(02:30)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/29"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_29" data-url="courses/learn/ngonten-sakti-dengan-ai/5/29">Membuat Akun Midjourney</div><span class="ms-auto">(05:06)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/30"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_30" data-url="courses/learn/ngonten-sakti-dengan-ai/5/30">Berlangganan Midjourney</div><span class="ms-auto">(03:50)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/31"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_31" data-url="courses/learn/ngonten-sakti-dengan-ai/5/31">Prompt Midjourney</div><span class="ms-auto">(09:00)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/32"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_32" data-url="courses/learn/ngonten-sakti-dengan-ai/5/32">Menjelajah Website Midjourney</div><span class="ms-auto">(07:32)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/5/33"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_33" data-url="courses/learn/ngonten-sakti-dengan-ai/5/33">Server Discord Midjourney</div><span class="ms-auto">(05:56)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Praktik Menggunakan Midjourney</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/6/34"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_34" data-url="courses/learn/ngonten-sakti-dengan-ai/6/34">Demo Membuat Ilustrasi Buku Cerita Anak</div><span class="ms-auto">(11:44)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/6/35"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_35" data-url="courses/learn/ngonten-sakti-dengan-ai/6/35">Demo Membuat Gambar Imajinasi</div><span class="ms-auto">(07:21)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/6/36"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_36" data-url="courses/learn/ngonten-sakti-dengan-ai/6/36">Demo Membuat Avatar 3D</div><span class="ms-auto">(08:13)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/6/37"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_37" data-url="courses/learn/ngonten-sakti-dengan-ai/6/37">Membuat Formula Midjourney Prompt dengan ChatGPT</div><span class="ms-auto">(05:48)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Studi Kasus Kreasi Konten dengan AI</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/38"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_38" data-url="courses/learn/ngonten-sakti-dengan-ai/7/38">Studi Kasus Ngonten dengan AI</div><span class="ms-auto">(00:46)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/39"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_39" data-url="courses/learn/ngonten-sakti-dengan-ai/7/39">Merancang Strategi Konten</div><span class="ms-auto">(16:18)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/40"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_40" data-url="courses/learn/ngonten-sakti-dengan-ai/7/40">Menentukan Branding</div><span class="ms-auto">(09:47)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/41"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_41" data-url="courses/learn/ngonten-sakti-dengan-ai/7/41">Membuat Logo</div><span class="ms-auto">(07:46)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/42"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_42" data-url="courses/learn/ngonten-sakti-dengan-ai/7/42">Membuat Daftar Ide Konten</div><span class="ms-auto">(07:07)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/43"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_43" data-url="courses/learn/ngonten-sakti-dengan-ai/7/43">Membuat Postingan Instagram</div><span class="ms-auto">(10:49)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/44"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_44" data-url="courses/learn/ngonten-sakti-dengan-ai/7/44">Membuat Naskah Konten Video</div><span class="ms-auto">(10:31)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/45"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_45" data-url="courses/learn/ngonten-sakti-dengan-ai/7/45">Mengubah Naskah ke Bahasa Lain</div><span class="ms-auto">(02:26)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/46"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_46" data-url="courses/learn/ngonten-sakti-dengan-ai/7/46">Membuat Cover Gambar untuk Youtube</div><span class="ms-auto">(13:16)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/7/47"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_47" data-url="courses/learn/ngonten-sakti-dengan-ai/7/47">Membuat Konten dari Artikel Bahasa Asing</div><span class="ms-auto">(07:28)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Penutup</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/8/48"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_48" data-url="courses/learn/ngonten-sakti-dengan-ai/8/48">Langkah Selanjutnya</div><span class="ms-auto">(02:27)</span>
                </a>
                <div class="text-secondary small mb-2 fw-bold">Rekaman Sesi Live Zoom</div><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/9/49"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_49" data-url="courses/learn/ngonten-sakti-dengan-ai/9/49">Rekaman Sesi Live Zoom Hari Pertama Batch 1</div><span class="ms-auto">(113:0)</span>
                </a><a class="d-flex shadow-sm align-items-center gap-3 p-2 px-3 mb-2 rounded-3 justify-content-between text-primary" href="https://madrasahdigital.id/courses/learn/ngonten-sakti-dengan-ai/9/50"><i class="bi bi-play-circle text-primary"></i>
                    <div class="mx-2" style="width:100%" id="lesson_50" data-url="courses/learn/ngonten-sakti-dengan-ai/9/50">Rekaman Sesi Live Zoom Hari Kedua Batch 1</div><span class="ms-auto">(113:5)</span>
                </a>
            </div>
        </div>
    </div>
</div>