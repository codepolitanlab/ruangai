<style>
    .menu-responsive {
        transform: translate(-42px, 0) scale(0.7);
    }
    .menu-responsive .btn .h6 {
        font-size: 18px !important;
        line-height: 0;  
    } 
    @media (min-width: 768px) {
        .menu-responsive {
            transform: translate(0, 0) scale(1);
        }
    }
    
</style>

<section class="mb-4 mt-3 p-3 bg-white rounded-4">
    <div class="position-relative">
        <img src="https://image.web.id/images/cover-course.png" class="w-100 position-relative rounded-4" alt="">
        <div class="position-absolute pb-2 px-4" style="top: 10%;">
            <h2 class="text-white" x-text="data.course?.course_title || 'Belajar AI'"></h2>
            <div class="text-white d-flex gap-4 mb-2">
                <div><i class="bi bi-people"></i> <span x-text="data.course?.total_student"></span> Siswa</div>
                <div><i class="bi bi-book"></i> <span x-text="data.course?.total_module"></span> Modul Belajar</div>
            </div>
            <div class="text-white">
                <p x-text="data.course?.description"></p>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h3 class="mb-1">Deskripsi Singkat</h3>
        <p>Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>
    </div>
    <div class="d-flex gap-2 pt-2 menu-responsive">
        <a :href="`/courses/intro/${$params.course_id}/${$params.slug}`"
            class="btn text-nowrap rounded-pill"
            :class="data.active_page == 'materi' ? `btn-primary` : `btn-ultra-light-primary`">
            <h6 class="h6 m-0">Materi Belajar</h6>
        </a>
        <a :href="`/courses/intro/${$params.course_id}/${$params.slug}/live_session`"
            class="btn text-nowrap rounded-pill position-relative"
            :class="data.active_page == 'live' ? `btn-primary` : `btn-ultra-light-primary`">
            <h6 class="h6 m-0">Live Session</span>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
            </h6>
        </a>
        <a :href="`/courses/intro/${$params.course_id}/${$params.slug}/student`"
            class="btn text-nowrap rounded-pill"
            :class="data.active_page == 'student' ? `btn-primary` : `btn-ultra-light-primary`">
            <h6 class="h6 m-0">Student</h6>
        </a>
    </div>
</section>