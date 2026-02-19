<div
    class="container-large"
    id="lesson_detail"
    x-data="lesson_detail_script($params.course_id, $params.lesson_id, <?= service('settings')->get('Course.waitToEnableButtonUnderstand'); ?>)"
    x-effect="loadPage(`courses/lesson/data/${$params.course_id}/${$params.lesson_id}?t=${Date.now()}`); setTimerButtonPaham()"
>

    <div id="app-header" class="appHeader main border-0 d-lg-none" style="background: white; border-bottom: 1px solid #e9ecef;">
        <div class="left">
            <a class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#lessonListOffcanvas" style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-list" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.875rem; font-weight: 500;">List Materi</span>
            </a>
        </div>
    </div>

    <!-- Mobile Progress Bar -->
    <!-- <div class="d-lg-none" style="background: white; padding: 0.75rem 1rem 1rem; border-bottom: 1px solid #e9ecef;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="progress" style="flex: 1; height: 8px; background: #e9ecef; border-radius: 10px;">
                <div class="progress-bar" 
                     style="background: linear-gradient(90deg, #4A90E2 0%, #5BA3F5 100%); border-radius: 10px;"
                     role="progressbar" 
                     :style="`width: ${data.course?.progress || 0}%`" 
                     :aria-valuenow="data.course?.progress || 0" 
                     aria-valuemin="0" 
                     aria-valuemax="100"></div>
            </div>
            <span style="font-size: 0.875rem; font-weight: 600; color: #6c757d; min-width: 45px; text-align: right;" x-text="Math.round(data.course?.progress || 0) + '%'"></span>
        </div>
    </div> -->

    <style>
        body { background: #f5f7fa; }
        .disabled { pointer-events: none; opacity: 0.6; cursor: not-allowed; }
        .lesson-breadcrumb {
            padding: 1rem 0 0.5rem;
            font-size: 0.875rem;
            color: #6c757d;
        }
        .course-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .course-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .course-header .subtitle {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .course-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: #6c757d;
        }
        .course-meta i {
            margin-right: 0.25rem;
        }
        .sidebar-col { 
            position: sticky;
            top: 20px;
            align-self: flex-start;
        }
        .lesson-sidebar { 
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            max-height: calc(100vh - 100px); 
            overflow-y: auto;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .lesson-sidebar h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .lesson-topic-title {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            margin-top: 1rem;
            color: #495057;
        }
        .lesson-topic-title:first-child {
            margin-top: 0;
        }
        .lesson-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: inherit;
        }
        .lesson-item:hover:not(.disabled) {
            background: #f8f9fa;
        }
        .lesson-item.active {
            background: #e3f2fd;
            border-left: 3px solid #2196F3;
        }
        .lesson-item.completed {
            background: #e8f5e9;
        }
        .lesson-item.disabled {
            opacity: 0.5;
        }
        .lesson-item-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        .lesson-item-icon i {
            font-size: 1.25rem;
        }
        .lesson-item-content {
            flex: 1;
        }
        .lesson-item-title {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.125rem;
            line-height: 1.4;
        }
        .lesson-item-duration {
            font-size: 0.75rem;
            color: #6c757d;
        }
        .content-area {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .video-container {
            position: relative;
            /* background: #000; */
            padding: 1rem;
        }
        .content-body {
            padding: 1.3rem;
            padding-top: 0;
        }
        .lesson-topic-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .lesson-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #212529;
        }
        .lesson-content h2, .lesson-content h3 {
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #212529;
        }
        .lesson-content h2 {
            font-size: 1.25rem;
        }
        .lesson-content h3 {
            font-size: 1.1rem;
        }
        .lesson-content p {
            line-height: 1.7;
            color: #495057;
            margin-bottom: 1rem;
        }
        .lesson-content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1rem 0;
            border-radius: 8px;
        }
        .lesson-list a.disabled { pointer-events: none; }
        .offcanvas-lesson-list { max-width: 320px; }
        .offcanvas-lesson-list .lesson-list { max-height: calc(100vh - 120px); overflow-y: auto; }
        
        @media (max-width: 991px) {
            body { background: #f8f9fa; }
            .lesson-breadcrumb { display: none; }
            .course-header { 
                border-radius: 0;
                margin-bottom: 0;
            }
            .content-area {
                border-radius: 20px;
                margin: 1rem;
                overflow: visible;
            }
            .video-container {
                border-radius: 20px 20px 0 0;
                overflow: hidden;
            }
            .content-body {
                padding: 1.25rem;
                background: white;
                border-radius: 0 0 20px 20px;
            }
            .lesson-topic-label {
                font-size: 0.875rem;
                color: #868e96;
                margin-bottom: 0.5rem;
            }
            .lesson-title {
                font-size: 1.375rem;
                font-weight: 700;
                margin-bottom: 1.25rem;
                line-height: 1.1;
            }
            .lesson-content h2 {
                font-size: 1.125rem;
                font-weight: 600;
                margin-top: 1.5rem;
                margin-bottom: 0.75rem;
            }
            .lesson-content h3 {
                font-size: 1rem;
                font-weight: 600;
                margin-top: 1.25rem;
                margin-bottom: 0.75rem;
            }
            .lesson-content p {
                font-size: 0.9375rem;
                line-height: 1.6;
            }
            .appHeader .headerButton {
                display: flex;
                align-items: center;
            }
        }
    </style>

    <div id="appCapsule" class="appCapsule-lg" style="padding-top: 0;">
        <div class="container-fluid px-0 px-lg-3" style="max-width: 1150px;">

            <!-- Breadcrumb -->
            <div class="lesson-breadcrumb d-none d-lg-block">
                <a href="/courses" class="text-decoration-none text-muted">Kelas saya</a>
                <span class="mx-2">
                    <i class="bi bi-chevron-right"></i>
                </span>
                <span x-text="data.lesson?.course_title"></span>
            </div>

            <!-- Course Header -->
            <div class="course-header d-none d-lg-block">
                <h1 x-text="data.course?.course_title"></h1>
                <div class="subtitle" x-text="data.course?.description"></div>
                <div class="course-meta">
                    <div x-show="data.course?.instructor_name">
                        <i class="bi bi-person"></i>
                        <span x-text="data.course?.instructor_name"></span>
                    </div>
                    <div x-show="data.course?.lessons?.length">
                        <i class="bi bi-book"></i>
                        <span x-text="data.course?.lessons?.length + ' Lesson'"></span>
                    </div>
                    <div x-show="data.course?.duration">
                        <i class="bi bi-clock"></i>
                        <span x-text="data.course?.duration"></span>
                    </div>
                </div>
            </div>

            <template x-if="data?.response_code == 403">
                <div class="card shadow-none rounded-4 p-3 mb-3 text-center bg-white">
                    <div class="mb-3"><i class="bi bi-journal-x display-4"></i></div>
                    <h3 class="text-muted mb-2">Kelas Terkunci</h3>
                    <p class="text-muted">Anda belum memiliki akses ke kelas ini.</p>
                </div>
            </template>

            <template x-if="data?.response_code == 404">
                <div class="card shadow-none rounded-4 p-3 mb-3 text-center bg-white">
                    <div class="mb-3"><i class="bi bi-sign-dead-end display-4"></i></div>
                    <h3 class="text-muted mb-2">Konten tidak ditemukan</h3>
                </div>
            </template>

            <div class="row">

                <!-- LEFT: Lesson list -->
                <div class="col-lg-4 sidebar-col mb-4 d-none d-lg-block order-2">
                    <div class="lesson-sidebar">
                        <h5>Materi Belajar</h5>
                        <div class="lesson-list">
                            <template x-for="(topicLessons, topic) of (data.course?.lessons_grouped || {})" :key="topic">
                                <div class="mb-3">
                                    <div class="lesson-topic-title" x-text="topic"></div>
                                    <template x-for="lessonItem of topicLessons" :key="lessonItem.id">
                                        <a href="javascript:void(0)"
                                            @click.prevent="canAccessLessonById(lessonItem.id) && $router.navigate('/courses/' + lessonItem.course_id + '/lesson/' + lessonItem.id)"
                                            class="lesson-item"
                                            :class="{
                                                'disabled': !canAccessLessonById(lessonItem.id),
                                                'active': lessonItem.id === data.lesson?.id,
                                                'completed': lessonItem.is_completed
                                            }">
                                            <div class="lesson-item-icon">
                                                <template x-if="lessonItem.is_completed">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                </template>
                                                <template x-if="!lessonItem.is_completed && canAccessLessonById(lessonItem.id)">
                                                    <i class="bi bi-play-circle" :class="lessonItem.id === data.lesson?.id ? 'text-primary' : 'text-muted'"></i>
                                                </template>
                                                <template x-if="!lessonItem.is_completed && !canAccessLessonById(lessonItem.id)">
                                                    <i class="bi bi-lock-fill text-muted"></i>
                                                </template>
                                            </div>
                                            <div class="lesson-item-content">
                                                <div class="lesson-item-title" x-text="lessonItem.lesson_title"></div>
                                                <div class="lesson-item-duration" x-text="lessonItem.duration"></div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Video + Content -->
                <div class="col-12 col-lg-8">
                    <div class="content-area mb-4">
                        <!-- Video Player -->
                        <div class="video-container">
                            <div x-show="data?.lesson?.default_video_server" class="ratio ratio-16x9">
                                <iframe
                                    class="rounded-3"
                                    :id="data?.lesson?.default_video_server + `-player`"
                                    width="560"
                                    height="315"
                                    :src="getVideoUrl(data?.lesson?.default_video_server, data?.lesson['video_' + data.lesson?.default_video_server])"
                                    title="Video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen></iframe>
                            </div>
                        </div>

                        <!-- Content Body -->
                        <div class="content-body">
                            <!-- Server Selection Buttons -->
                            <div class="mb-3" x-show="data.lesson?.video_diupload && data.lesson?.video_bunny">
                                <div class="btn-group">
                                    <button class="btn btn-sm" :class="data.lesson?.default_video_server === 'diupload' ? 'btn-primary' : 'btn-outline-primary'" @click="data.lesson.default_video_server ='diupload'">Server 1</button>
                                    <button class="btn btn-sm" :class="data.lesson?.default_video_server === 'bunny' ? 'btn-primary' : 'btn-outline-primary'" @click="data.lesson.default_video_server = 'bunny'">Server 2</button>
                                </div>
                            </div>

                            <div class="lesson-topic-label" x-text="data.lesson?.topic_title"></div>
                            <h2 class="lesson-title" x-text="data.lesson?.lesson_title"></h2>

                            
                            <template x-if="data.lesson?.text">
                                <div>
                                    <!-- Action Buttons -->
                                    <div class="mb-5">
                                        <?= $this->include('courses/lesson/_navigation') ?>
                                    </div>
                                    
                                    <div class="lesson-content" x-html="data.lesson?.text" x-init="$nextTick(() => setNativeLinks())"></div>
                                </div>
                            </template>

                            <!-- Quiz container -->
                            <template x-if="data.lesson?.quiz">
                                <?= $this->include('courses/lesson/quiz') ?>
                            </template>
                            
                            <!-- Action Buttons -->
                            <div class="mt-5">
                                <?= $this->include('courses/lesson/_navigation') ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Offcanvas for Lesson List (Mobile) -->
    <div class="offcanvas offcanvas-start offcanvas-lesson-list" tabindex="-1" id="lessonListOffcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Materi Belajar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-3">
            <template x-for="(topicLessons, topic) of (data.course?.lessons_grouped || {})" :key="topic">
                <div class="mb-3">
                    <div class="lesson-topic-title" x-text="topic"></div>
                    <template x-for="lessonItem of topicLessons" :key="lessonItem.id">
                        <a href="javascript:void(0)"
                            @click.prevent="canAccessLessonById(lessonItem.id) && ($router.navigate('/courses/' + lessonItem.course_id + '/lesson/' + lessonItem.id), bootstrap.Offcanvas.getInstance(document.getElementById('lessonListOffcanvas'))?.hide())"
                            class="lesson-item"
                            :class="{
                                'disabled': !canAccessLessonById(lessonItem.id),
                                'active': lessonItem.id === data.lesson?.id,
                                'completed': lessonItem.is_completed
                            }">
                            <div class="lesson-item-icon">
                                <template x-if="lessonItem.is_completed">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                </template>
                                <template x-if="!lessonItem.is_completed && canAccessLessonById(lessonItem.id)">
                                    <i class="bi bi-play-circle" :class="lessonItem.id === data.lesson?.id ? 'text-primary' : 'text-muted'"></i>
                                </template>
                                <template x-if="!lessonItem.is_completed && !canAccessLessonById(lessonItem.id)">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </template>
                            </div>
                            <div class="lesson-item-content">
                                <div class="lesson-item-title" x-text="lessonItem.lesson_title"></div>
                                <div class="lesson-item-duration" x-text="lessonItem.duration"></div>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
    <?= $this->include('courses/lesson/script') ?>
</div>