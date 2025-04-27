<section>
    <div class="px-3 pb-2 px-md-0 overflow-scroll">
        <div>
            <p x-text="data.course?.description"></p>
        </div>
        <div class="d-flex gap-3 mt-2 mb-2 pt-2">
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
    </div>
</section>