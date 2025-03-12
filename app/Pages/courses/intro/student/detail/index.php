<div id="student_detail" x-data="student_detail()">
    <div id="app-header" class="appHeader bg-dark main glassmorph border-0">
        <div class="left"><a class="headerButton" href="/courses/intro/inggris-beginner-book-1/student"><i class="bi bi-chevron-left"></i></a></div>
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
                .progress {
                    height: 8px;
                    background: #434343 !important;
                }
                .progress-bar {
                    background: #AEAEAE;
                }
            </style>
            <section>
                <div class="container px-3">
                    
                    <!-- Profile Section -->
                    <div class="text-center mb-4 mt-3 text-white">
                        <div style="height:400px" class="mx-auto mb-3">
                            <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205395%20(1).png?updatedAt=1741588022966" class="cover rounded-20" alt="Student Profile">
                        </div>
                        <h3 class="mb-2">Badar Abdi Mulya</h3>
                        <p class="mb-3">CODING IS A SHINOBI WAYS FOR ME!!!!!</p>
                        <div class="bg-grey rounded-pill px-4 py-2 d-inline-block">
                            <div>Enroll Kelas : 24 Oktober 2025</div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    <div class="mt-5">
                        <div class="card bg-dark rounded-20 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="text-white m-0">Batch 1</h5>
                                <img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%205326.png?updatedAt=1741588340180" width="30" class="me-1" alt="">
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                                </div>
                                <div class="text-secondary">100%</div>
                            </div>
                        </div>

                        <div class="card bg-dark rounded-20 p-3 mb-3">
                            <h5 class="text-white mb-2">Batch 2</h5>
                            <div class="d-flex align-items-center gap-3">
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar" style="width: 50%"></div>
                                </div>
                                <div class="text-secondary">50%</div>
                            </div>
                        </div>

                        <div class="card bg-dark rounded-20 p-3 mb-3">
                            <h5 class="text-white mb-2">Batch 3</h5>
                            <div class="d-flex align-items-center gap-3">
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar" style="width: 50%"></div>
                                </div>
                                <div class="text-secondary">50%</div>
                            </div>
                        </div>
                    </div>
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