<div class="card shadow-none mb-3 overflow-hidden rounded-4" style="background:#112f3d">
    <div class="d-flex align-items-center">
        <div>
            <img :src="course?.cover" class="rounded-3 img-course" alt="thumbnail kelas">
        </div>
        <div class="flex-grow-1 text-white px-3 py-3">
            <p class="fw-bold h5" x-text="course?.title"></p>
            <p x-text="course?.description"></p>
            <a href="/courses" class="btn btn-sm btn-outline-white mb-2 mb-lg-0 disabled"><i class="bi bi-stack fs-6"></i> Lihat Materi</a>
            <!-- <button type="button" class="btn btn-sm btn-outline-white mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#teaserModal"><i class="bi bi-play-circle-fill fs-6"></i> Lihat Teaser</button> -->
            <button type="button" class="btn btn-sm btn-outline-white mb-2 mb-lg-0 disabled"><i class="bi bi-play-circle-fill fs-6"></i> Lihat Teaser</button>
        </div>
    </div>
    <div class="modal fade" id="teaserModal" tabindex="-1" aria-labelledby="teaserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" title="YouTube video" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
