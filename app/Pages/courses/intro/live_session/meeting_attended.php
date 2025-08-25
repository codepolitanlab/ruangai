<template x-for="(attended, attendedIndex) in data.attended">
    <div 
        class="card pe-3 p-2 rounded-4 shadow-sm mb-3 bg-opacity-10 border"
        :class="attended.status == 1 ? 'bg-success border-success' : 'bg-warning border-warning'"
        x-show="moment().isAfter(moment(attended.meeting_date + ' ' + attended.meeting_end, 'YYYY-MM-DD HH:mm:ss'))">
        <div class="d-flex gap-2 align-items-top">
            <div class="py-2 ps-1 pe-2">
                <div class="d-flex align-items-center justify-content-center rounded-4 bg-white">
                    <i class="bi fs-2"
                        :class="{'bi-check text-success': attended.status == 1, 'bi-x text-danger': attended.status == 0, 'bi-arrow-repeat text-warning': attended.status == null}"></i>
                </div>
            </div>
            <div class="py-2">
                <h5 class="text-muted mb-1" x-text="attended.batch_title + ', ' + attended.subtitle"></h5>
                <h4 class="fw-bold mb-1" x-text="attended.title"></h4>
                <p class="m-0 d-flex gap-3 small">
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
                        <span x-show="attended.status == null">
                            <i class="bi bi-arrow-repeat"></i>
                            Data kehadiran sedang diproses
                        </span>
                        <span x-show="attended.status == 0">
                            <i class="bi bi-exclamation-triangle"></i>
                            Kamu tidak mengikuti sesi
                        </span>
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
                        Kamu sudah mengisi feedback? 
                        <button 
                            class="fw-bold ms-2 btn btn-sm btn-outline-success" 
                            @click="checkAttendedStatus(attendedIndex)"
                            :class="checkingStatus ? 'btn-progress' : ''">
                            <div class="btn-progress-spinner text-primary">Mengecek..</div>
                            <span class="btn-label">Cek Status</span>
                        </button>
                        <a :href="`/courses/feedback/${attended.meeting_code}`" class="fw-bold ms-2 btn btn-sm btn-outline-primary">Isi Feedback</a>
                    </p>
            </div>
            </div>
        </div>
    </div>
</template>