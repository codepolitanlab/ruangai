<template x-for="attended in data.attended">
    <div 
        class="card pe-3 p-2 rounded-4 border shadow-none mb-2"
        :class="attended.status == 1 ? 'bg-success' : 'bg-warning'">
        <div class="d-flex gap-2 align-items-center">
            <div class="py-2 ps-1 pe-2">
                <div class="d-flex align-items-center justify-content-center rounded-4 bg-white">
                    <i class="bi bi-check fs-2"
                        :class="attended.status == 1 ? 'bi-check text-success' : 'bi-x text-danger'"></i>
                </div>
            </div>
            <div>
                <p class="text-white mb-1" x-text="attended.batch_title + ', ' + attended.subtitle"></p>
                <div class="fw-bold text-white mb-1" x-text="attended.title"></div>
                <p class="m-0 d-flex gap-3 text-white small">
                    <span class="d-flex">
                        <i class="bi bi-calendar me-1 fs-6"></i>
                        <span x-text="$heroicHelper.formatDate(attended.meeting_date)"></span>
                    </span>
                    <span class="d-flex">
                        <i class="bi bi-clock me-1 fs-6"></i>
                        <span x-text="attended.meeting_time.substring(0, 5) + ` WIB`"></span>
                    </span>
                </p>
                <div x-show="attended.status == 0 || attended.status == null">
                    <p 
                        class="bg-white bg-opacity-50 py-1 px-2 rounded-4 mt-3 mb-0"
                        x-show="attended.duration < 1">
                        <i class="bi bi-exclamation-triangle"></i>
                        Kamu tidak mengikuti sesi
                    </p>
                    <p 
                        class="bg-white bg-opacity-50 py-1 px-2 rounded-4 mt-3 mb-0"
                        x-show="attended.duration > 0 && attended.duration < 1800">
                        <i class="bi bi-exclamation-triangle"></i>
                        Durasi kamu mengikuti sesi kurang dari yang dipersyaratkan
                    </p>
                    <p 
                    class="bg-white bg-opacity-50 py-1 px-2 rounded-4 mt-3 mb-0"
                    x-show="attended.duration > 0 && attended.meeting_feedback_id == null">
                        <i class="bi bi-exclamation-triangle"></i>
                        Kamu belum mengisi feedback
                    </p>
            </div>
            </div>
        </div>
    </div>
</template>