<style>
    #course-features .btn .h6 {
        font-size: 16px !important;
        line-height: 0;
    }
</style>

<div id="course-features" class="d-flex gap-2 px-3 pt-4 pb-1">
    <a :href="`/beasiswa/intro`"
        class="btn rounded-4 px-2"
        :class="data.active_page == 'intro' ? `btn-primary` : `btn-white bg-white text-primary`">
        <h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
    </a>
</div>