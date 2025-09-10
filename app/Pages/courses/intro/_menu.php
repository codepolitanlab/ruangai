<style>
    #course-features .btn .h6 {
        font-size: 16px !important;
        line-height: 0;
    }
</style>

<div id="course-features" class="d-flex gap-2 px-3 pt-4 pb-1">
    <a :href="`/courses/intro/${$params.course_id}/${$params.slug}`"
        class="btn rounded-4 px-2"
        :class="data.active_page == 'intro' ? `btn-primary` : `btn-white bg-white text-primary`">
        <h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
    </a>

    <div x-show="data.course?.has_modules === '1' && data.course?.has_live_sessions === '1'">
        <template x-if="data.course?.has_modules === '1'">
            <a :href="`/courses/intro/${$params.course_id}/${$params.slug}/lessons`"
                class="btn text-nowrap rounded-4"
                :class="data.active_page == 'materi' ? `btn-primary` : `btn-white bg-white text-primary`">
                <h6 class="h6 m-0">Materi Belajar</h6>
            </a>
        </template>

        <template x-if="data.course?.has_live_sessions === '1'">
            <a :href="`/courses/intro/${$params.course_id}/${$params.slug}/live_session`"
                class="btn text-nowrap rounded-4 position-relative"
                :class="data.active_page == 'live' ? `btn-primary` : `btn-white bg-white text-primary`">
                <h6 class="h6 m-0">Live Session</h6>
            </a>
        </template>
    </div>
</div>