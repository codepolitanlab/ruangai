<div
    class="container-large"
    id="live_recording"
    x-data="liveRecording(`${$params.meeting_id}`)"
    x-effect="loadPage(`courses/recording/data/${$params.meeting_id}`)">

    <style>
        .video-container {
            position: relative;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .recording-info {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .recording-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .recording-subtitle {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        
        .recording-meta {
            display: flex;
            gap: 1.5rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .recording-meta i {
            margin-right: 0.25rem;
        }

        .alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .alert-box {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            margin: 1rem;
            text-align: center;
        }

        .alert-box h3 {
            margin-bottom: 1rem;
        }

        .alert-box p {
            margin-bottom: 1.5rem;
            color: #6c757d;
        }
    </style>

    <div id="app-header" class="appHeader main border-0 d-lg-none" style="background: white; border-bottom: 1px solid #e9ecef;">
        <div class="left">
            <a class="headerButton" :href="`/beasiswa/intro/${$params.course_id}/${$params.slug}/live_session`">
                <i class="bi bi-arrow-left" style="font-size: 1.25rem;"></i>
            </a>
        </div>
        <div class="pageTitle">Rekaman Live Session</div>
    </div>

    <div id="appCapsule" class="py-4">
        <!-- Debug info -->
        <div x-show="!data" class="container text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memuat rekaman...</p>
        </div>

        <!-- Error/No Access Message -->
        <template x-if="data?.response_code && data.response_code !== 200">
            <div class="alert-overlay">
                <div class="alert-box">
                    <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                    <h3 class="mt-3">Akses Ditolak</h3>
                    <p x-text="data.response_message"></p>
                    <a :href="`/beasiswa/intro/${$params.course_id}/${$params.slug}/live_session`" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </template>

        <!-- Video Player dan Info -->
        <template x-if="data?.meeting">
            <div class="container-xl">
                <div class="row">
                    <div class="col-12">
                        <!-- Back button for desktop -->
                        <div class="d-none d-lg-block mb-3">
                            <a :href="`/beasiswa/intro/${$params.course_id}/${$params.slug}/live_session`" class="btn btn-light">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Live Session
                            </a>
                        </div>

                        <!-- Video Player -->
                        <div class="video-container mb-4">
                            <template x-if="data.meeting.recording_link">
                                <div style="position:relative;padding-top:56.25%;">
                                    <iframe 
                                        x-bind:src="getVideoUrl(data.meeting.recording_link, data.meeting.bunny_collection_id)"
                                        loading="lazy" 
                                        style="border:0;position:absolute;top:0;height:100%;width:100%;" 
                                        allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;" 
                                        allowfullscreen="true"></iframe>
                                </div>
                            </template>
                        </div>

                        <!-- Recording Info -->
                        <div class="recording-info">
                            <h5 class="recording-subtitle" x-text="data.meeting.batch_name + ' - ' + data.meeting.subtitle"></h5>
                            <h2 class="recording-title" x-text="data.meeting.title"></h2>
                            
                            <div class="recording-meta mb-3">
                                <span>
                                    <i class="bi bi-calendar"></i>
                                    <span x-text="$heroicHelper.formatDate(data.meeting.meeting_date)"></span>
                                </span>
                                <span>
                                    <i class="bi bi-clock"></i>
                                    <span x-text="data.meeting.meeting_time.substring(0, 5) + ' WIB'"></span>
                                </span>
                            </div>

                            <template x-if="data.meeting.mentor_name">
                                <div class="mb-3">
                                    <strong>Mentor:</strong> <span x-text="data.meeting.mentor_name"></span>
                                </div>
                            </template>

                            <template x-if="data.meeting.description">
                                <div>
                                    <strong>Deskripsi:</strong>
                                    <p class="mt-2 mb-0" x-text="data.meeting.description"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('courses/recording/script') ?>
