<div id="course_detail" x-data="course_detail()">
    <div id="app-header" class="appHeader main glassmorph border-0">
        <div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
        <div class="pageTitle"><span>Detail Kelas</span></div>
        <div class="right"><a class="headerButton" role="button" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas"><i class="bi bi-share-fill me-1"></i></a></div>
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
            <div class="row pt-xs-0 pt-sm-4 px-xs-0 px-sm-3">
                <div class="col-md-6 mb-3 px-0"><img src="https://course.taeyangkulture.com//uploads/taeyang/sources/Gambar%20Cover/Learning%20Option-ENGLISH-BEGINNER%201.png" class="img-fluid mb-2"></div>
                <div class="col-md-6 px-3">
                    <h1 class="h4 title">Inggris - Beginner Book 1</h1>
                    <div class="">
                        <p class="text-secondary mt-2"><i class="bi bi-clock me-2"></i> Durasi 7 jam
                            3 menit <br><i class="bi bi-book me-2"></i> 32 modul materi <br></p>
                        <div><del id="strike-price-label" class="h5 text-danger text-nowrap d-none"></del>
                            <div id="price-label" class="h2 text-primary mb-0 me-2">Rp 222.000</div>
                        </div>
                        <div class="product-course-options mt-2"><button type="button" class="btn btn-check-label btn-sm me-1 active" data-id="5" data-price="222000" data-strike-price="0">1 Bulan</button><button type="button" class="btn btn-check-label btn-sm me-1 text-muted" data-id="7" data-price="599000" data-strike-price="0">3 Bulan</button></div>
                    </div>
                </div>
                <div class="px-3 mt-5 mb-3">
                    <h3 class="h5 title">Deskripsi Singkat</h3>
                    <p class="text-secondary lead mb-0">Mau upgrade skill &amp; pengetahuan Bahasa Inggris kamu? E-learning aja! 2 Pilihan asyik ini hanya untuk kamu, paket bulanan &amp; paket bundling untuk 3 bulan! Yuk, checkout sekarang juga!</p>
                </div>
            </div>
            <div class="row pt-xs-0 pt-4 px-xs-0 px-sm-3">
                <div class="col-12 px-3">
                    <h3 class="h5 title">Apa yang akan dipelajari</h3>
                    <div class="lessons my-4">
                        <h5>Bab 1: Introduction</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div><a href="/courses/lessons/1" class="text-primary text-decoration-none">CHAPTER 1 - INTRODUCING YOURSELF</a></div><span class="text-muted ms-auto">(08:40)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 2 - TALKING ABOUT YOURSELF</div><span class="text-muted ms-auto">(15:16)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 3 - THINGS YOU HAVE</div><span class="text-muted ms-auto">(09:21)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 4 - USING APOSTROPHES</div><span class="text-muted ms-auto">(07:24)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div><a href="/courses/quiz/1" class="text-primary text-decoration-none">CHAPTER 5 - QUIZ</a></div><span class="text-muted ms-auto">(13:04)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="lessons my-4">
                        <h5>Bab 2: Jobs &amp; Routines</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 6 - JOBS</div><span class="text-muted ms-auto">(17:20)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 7 - DAILY ROUTINES</div><span class="text-muted ms-auto">(11:24)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 8 - DESCRIBING YOUR DAY</div><span class="text-muted ms-auto">(07:04)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 9 - DESCRIBING YOUR WEEK</div><span class="text-muted ms-auto">(09:17)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="lessons my-4">
                        <h5>Bab 3: Clarification &amp; Confirmation</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 10 - NEGATIVES</div><span class="text-muted ms-auto">(13:58)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 11 - SIMPLE QUESTIONS</div><span class="text-muted ms-auto">(11:26)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 12 - OPEN QUESTIONS</div><span class="text-muted ms-auto">(12:03)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="lessons my-4">
                        <h5>Bab 4: Town &amp; City</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 13 - MY TOWN</div><span class="text-muted ms-auto">(18:29)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 14 - USING "A" AND "THE"</div><span class="text-muted ms-auto">(15:30)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 15 - ORDERS AND DIRECTIONS</div><span class="text-muted ms-auto">(13:14)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 16 - JOINING SENCENTES</div><span class="text-muted ms-auto">(11:49)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 17 - DESCRIBING PLACES</div><span class="text-muted ms-auto">(12:17)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 18 - QUANTITY PHRASES</div><span class="text-muted ms-auto">(11:47)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="lessons my-4">
                        <h5>Bab 5: What We Have</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 19 - THE THINGS I HAVE</div><span class="text-muted ms-auto">(09:35)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 20 - WHAT DO YOU HAVE?</div><span class="text-muted ms-auto">(10:16)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 21 - COUNTING</div><span class="text-muted ms-auto">(17:05)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 22 - MEASURING</div><span class="text-muted ms-auto">(07:41)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 23 - AT THE SHOP</div><span class="text-muted ms-auto">(12:49)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 24 - DESCRIBING THINGS</div><span class="text-muted ms-auto">(09:13)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="lessons my-4">
                        <h5>Bab 6: Hobbies &amp; Interests</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 25 - TALKING ABOUT SPORT</div><span class="text-muted ms-auto">(21:15)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 26 - FREE TIME</div><span class="text-muted ms-auto">(25:00)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 27 - LIKES AND DISLIKES</div><span class="text-muted ms-auto">(11:02)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 28 - EXPRESSING PREFERENCE</div><span class="text-muted ms-auto">(22:05)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="lessons my-4">
                        <h5>Bab 7: Ability &amp; Learning</h5>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 29 - WHAT YOU CAN AND CAN'T DO</div><span class="text-muted ms-auto">(15:17)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 30 - DESCRIBING ACTIONS</div><span class="text-muted ms-auto">(13:01)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 31 - DESCRIBING ABILITY</div><span class="text-muted ms-auto">(17:06)</span><i class="bi bi-lock"></i>
                        </div>
                        <div class="d-flex shadow-sm background align-items-center gap-3 p-2 px-3 mb-2"><i class="bi bi-camera-reels"></i>
                            <div>CHAPTER 32 - ACADEMIC SUBJECT</div><span class="text-muted ms-auto">(11:41)</span><i class="bi bi-lock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small"></div>
    </div>
</div>