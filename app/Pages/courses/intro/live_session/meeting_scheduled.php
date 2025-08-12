<div class="accordion bg-transparent border-0" id="accordion-livesession-scheduled">
    <template x-for="(live_session, meetingIndex) in data.live_sessions?.scheduled">
        <div class="accordion-item p-2 rounded-4 mb-3" :class="live_session.status_date">
            <div class="accordion-header rounded-4 py-2">
                <button class="accordion-button d-flex flex-column flex-md-row gap-3 align-items-md-center" type="button" data-bs-toggle="collapse" :data-bs-target="`#live_`+live_session.id" aria-expanded="true" :aria-controls="`live_`+live_session.id">
                    <div>
                        <h5 class="text-muted mb-1 ms-1" x-text="live_session.subtitle"></h5>
                        <h4 class="mb-1 ms-1" style="max-width:250px" x-text="live_session.title"></h4>
                        <p class="m-0 d-flex gap-3 text-muted">
                            <span class="d-flex">
                                <i class="bi bi-calendar me-1 fs-6"></i>
                                <span x-text="$heroicHelper.formatDate(live_session.meeting_date)"></span>
                            </span>
                            <span class="d-flex">
                                <i class="bi bi-clock me-1 fs-6"></i>
                                <span x-text="live_session.meeting_time.substring(0, 5) + ` WIB`"></span>
                            </span>
                        </p>
                    </div>
                    <div class="badge bg-primary-subtle ms-auto px-2 py-3 text-dark opacity-50" x-show="live_session.status_date == 'upcoming'">Akan datang</div>
                    <div class="badge bg-white ms-auto px-2 py-3 text-warning" x-show="live_session.status_date == 'ongoing'"><i class="bi bi-broadcast"></i> Sedang berlangsung</div>
                    <div class="badge bg-white border border-success ms-auto px-2 py-3 text-success" x-show="live_session.status_date == 'attended'"><i class="bi bi-check-circle"></i> Sudah mengikuti</div>
                    <div class="badge bg-secondary-subtle border border-secondary-subtle ms-auto px-2 py-3 text-dark opacity-75" x-show="live_session.status_date == 'completed'"> Sesi selesai</div>
                </button>
            </div>
            <div :id="`live_`+live_session.id" class="bg-light rounded-4 mt-1 accordion-collapse collapse" data-bs-parent="#accordion-livesession">
                <div class="accordion-body py-3">
                    <dl>
                        <dt>Deskripsi</dt>
                        <dd x-text="live_session.description"></dd>
                    </dl>
                    <dl>
                        <dt>Mentor</dt>
                        <dd x-text="live_session.mentor_name"></dd>
                    </dl>
                    <template x-if="data?.completed">
                        <div class="d-flex gap-2 mt-4">
                            <template x-if="!data.attendedCode.includes(live_session.theme_code) && !data.is_expire">
                                <button
                                    class="btn btn-primary rounded-3"
                                    @click.prevent="checkEmailIsVerified(meetingIndex, 'scheduled')"
                                    x-show="['ongoing','upcoming'].includes(live_session.status_date)"
                                    :class="!live_session.zoom_link && !live_session.zoom_meeting_id ? 'disabled' : ''">
                                    <i class="bi bi-camera-video"></i>
                                    <span x-text="!live_session.zoom_link && !live_session.zoom_meeting_id ? 'Zoom link belum tersedia' : 'Daftar Live Session'"></span>
                                </button>
                            </template>
                            <p
                                x-show="live_session.status_date == 'completed' && live_session.feedback_submitted"
                                class="border border-success bg-white rounded-3 py-2 px-3">
                                <i class="bi bi-check-circle text-success"></i>
                                Terima kasih sudah mengisi feedback
                            </p>

                            <p class="px-3 py-2 bg-info bg-opacity-50 rounded-2"
                                x-show="data.attendedCode.includes(live_session.theme_code)">
                                <i class="bi bi-hand-thumbs-up"></i>
                                Kamu sudah mengikuti sesi dengan judul ini
                            </p>

                            <template x-if="data.enable_live_recording">
                                <a
                                    :href="live_session.recording_link"
                                    target="_blank"
                                    class="btn btn-danger rounded-3"
                                    x-show="['attended','completed'].includes(live_session.status_date)"
                                    :class="! live_session.recording_link ? 'disabled' : ''">
                                    <i class="bi bi-play-circle-fill"></i>
                                    <span x-text="! live_session.recording_link ? 'Rekaman belum tersedia' : 'Rekaman Video'"></span>
                                </a>
                            </template>
                            <!-- <button class="btn btn-outline-secondary rounded-3"> <i class="bi bi-person-check-fill"></i> Isi Presensi</button> -->
                        </div>
                    </template>
                    <template x-if="!data?.completed">
                        <div class="alert alert-warning">
                            Harap bereskan kursus sebelum mengikuti live session
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>