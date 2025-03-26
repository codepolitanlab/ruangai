<div id="detail_live_session">
    <div id="app-header" class="appHeader main glassmorph border-0">
        <div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
        <div class="pageTitle"><span><?= $page_title ?></span></div>
        <div class="right"><a class="headerButton" role="button" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas"><i class="bi bi-share-fill me-1"></i></a></div>
    </div>

    <div id="appCapsule" class="shadow">
        <div class="appContent" style="min-height:90vh">

            <style>
                .cover {
                    object-fit: cover;
                    width: 100%;
                    height: 100%;
                }
            </style>

            <section>
                <div class="container px-4">
                    <div class="ratio ratio-16x9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/i5j7ZnyUOPE?si=9_750eBqXXHCQcEI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="mt-3">
                        <div class="badge bg-pink mb-2 p-2">
                            <i class="bi bi-cast h6 m-0"></i>
                            <div>Live</div>
                        </div>

                        <h3 class="text-white">Tips Memanfaatkan AI di Dunia Industri 4.3</h3>
                        <p class="text-white">Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>

                        <button class="btn bg-grey text-white rounded-pill px-4 mb-5" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas">
                            <i class="bi bi-share-fill me-2"></i>
                            Bagikan
                        </button>

                        <div class="mb-4">
                            <h4 class="text-white mb-3">Rekaman Live Sebelumnya</h4>

                            <!-- Previous Live Session Card -->
                            <div class="card bg-dark rounded-20 p-3">
                                <div class="d-flex gap-3">
                                    <div style="width: 200px; height: 130px">
                                        <img src="https://plus.unsplash.com/premium_photo-1661766386981-1140b7b37193?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cHJvZmVzaW9uYWx8ZW58MHx8MHx8fDA%3D" class="rounded-3 cover" alt="Live Session 1">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex gap-3 mb-1 align-items-center">
                                            <h5 class="text-pink m-0">Live Session 1</h5>
                                            <div class="badge btn-primary px-2">Rekaman</div>
                                        </div>
                                        <h4 class="text-white mb-3">Mengenal Lebih Dalam Peran AI di Kehidupan Sehari-hari</h4>
                                        <div class="d-flex gap-3 text-secondary">
                                            <div><i class="bi bi-clock"></i> 50:22</div>
                                            <div><i class="bi bi-people"></i> 120 Siswa</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slice here -->
                </div>
            </section>

        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small"></div>
    </div>
</div>