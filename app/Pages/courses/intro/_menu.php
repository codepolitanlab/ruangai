<style>
    #course-features .btn .h6 {
        font-size: 16px !important;
        line-height: 0;  
    }
</style>

<div id="course-features" class="d-flex gap-1 px-2 py-3 rounded-4">
    <a :href="`/courses/intro/${$params.course_id}/${$params.slug}`"
        class="btn text-nowrap rounded-pill"
        :class="data.active_page == 'materi' ? `btn-primary` : `btn-ultra-light-primary`">
        <h6 class="h6 m-0">Materi</h6>
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
        <h6 class="h6 m-0">Siswa</h6>
    </a>
</div>