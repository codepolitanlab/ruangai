<div
    id="courses_zoom"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/zoom/data/${$params.meeting_code}`
        })">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <h1>Registrasi Webinar Fundamental Kelasfullstack</h1>
                    <p>Anda akan mendaftar webinar gratis untuk kelas Fundamental Kelasfullstack</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="py-3">   
                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" x-model="data.name" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" x-model="data.email" disabled>
                    </div>

                    <button class="btn btn-secondary" @click="register">Lanjutkan Daftar</button>
                </div>
            </div>
        </div>
    </div>

</div>
