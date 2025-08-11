<div
    id="courses_zoom"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/zoom/data/${$params.meeting_code}`
        })">

    <div class="container" x-show="data?.status == 'error'" x-transition>
        <div class="row justify-content-center text-center mt-5">
            <h2>404</h2>
            <p>Form pendaftaran live session belum tersedia atau link live session tidak valid.</p>
            <a href="/courses"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <template x-if="data?.status != 'error'">
        <div class="container mt-5" x-show="data?.meeting?.id" x-transition>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center">
                        <h2 class="h3 text-secondary">Registrasi Live Session</h2>
                        <h1 x-text="data.meeting.title"></h1>
                        <p class="text-dark opacity-75">
                            Tanggal event: <span x-text="$heroicHelper.formatDate(data.meeting.meeting_date)"></span><br>
                            pukul <span x-text="data.meeting.meeting_time"></span> WIB
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" x-data="registerLiveSession()">

                <div class="col-md-5" x-show="!data.zoom_join_link">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center">Anda akan mendaftar ke live session dengan akun di bawah ini:</p>
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" x-model="data.name" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" x-model="data.email" disabled>
                            </div>

                            <div class="text-center mt-4" x-show="data.completed == 100">
                                <button
                                    class="btn btn-success fs-6"
                                    :class="registering ? 'btn-progress' : ''"
                                    @click="register">
                                    <div class="btn-progress-spinner">Mendaftarkan..</div>
                                    <span class="btn-label">Daftar Live Session</span>
                                </button>
                            </div>

                            <div class="alert alert-warning mt-4" x-show="data.completed < 100">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-exclamation-triangle fs-3"></i>
                                    <p class="mb-0 py-2 text-white fs-6">Silakan selesaikan dahulu materi belajar mandiri untuk dapat mengikuti sesi live ini.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 text-center" x-show="data.zoom_join_link">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <p class="mb-4"><i class="bi bi-bookmark-check-fill text-success fs-3 me-1"></i> Kamu telah terdaftar di live session ini.</p>

                            <div class="d-flex justify-content-between">
                                <a :href="data.zoom_join_link" class="btn btn-primary fs-6" target="_blank" native>
                                    <i class="bi bi-camera-video"></i>
                                    Gabung Zoom
                                </a>
                                <a :href="`/courses/intro/${data.course.id}/${data.course.slug}/live_session`" class="btn btn-outline-dark opacity-50 fs-6">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </template>


</div>

<?= $this->include('courses/zoom/script') ?>