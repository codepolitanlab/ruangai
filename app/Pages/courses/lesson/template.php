<div
    class="container-large"
    id="lesson_detail"
    x-data="lesson_detail_script($params.course_id, $params.lesson_id, <?= service('settings')->get('Course.waitToEnableButtonUnderstand'); ?>)"
    x-effect="loadPage(`courses/lesson/data/${$params.course_id}/${$params.lesson_id}?t=${Date.now()}`); setTimerButtonPaham()"
>

    <div id="app-header" class="appHeader main border-0">
        <div class="left">
            <a class="headerButton" :href="`/courses/intro/${data.lesson?.course_id}/${data.lesson?.course_slug}`"><i class="bi bi-chevron-left"></i></a>
        </div>
        <div class="">
            <span x-text="data.lesson?.course_title"></span>
        </div>
        <div class="right">
            <a class="headerButton d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#lessonListOffcanvas">
                <i class="bi bi-list"></i>
            </a>
        </div>
    </div>

    <style>
        .disabled { pointer-events: none; opacity: 0.6; cursor: not-allowed; }
        .sidebar-col { 
            transition: opacity 0.3s ease; 
            position: sticky;
            top: 60px;
            align-self: flex-start;
        }
        .sidebar-col[style*="display: none"] { display: none !important; }
        .lesson-sidebar { 
            max-height: calc(100vh - 80px); 
            overflow-y: auto;
        }
        .lesson-list a.disabled { pointer-events: none; }
        .offcanvas-lesson-list { max-width: 320px; }
        .offcanvas-lesson-list .lesson-list { max-height: calc(100vh - 120px); overflow-y: auto; }
        .content-col { transition: all 0.3s ease; }
        .sidebar-toggle-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 20;
            background: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .sidebar-toggle-btn:hover {
            background: #f8f9fa;
        }
    </style>

    <div id="appCapsule" class="appCapsule-lg">
        <div class="appContent px-0 bg-white rounded-bottom-4" style="min-height:95vh">

            <template x-if="data?.response_code == 403">
                <div class="card shadow-none rounded-4 p-3 mb-3 text-center">
                    <div class="mb-3"><i class="bi bi-journal-x display-4"></i></div>
                    <h3 class="text-muted mb-2">Kelas Terkunci</h3>
                    <p class="text-muted">Anda belum memiliki akses ke kelas ini.</p>
                </div>
            </template>

            <template x-if="data?.response_code == 404">
                <div class="card shadow-none rounded-4 p-3 mb-3 text-center">
                    <div class="mb-3"><i class="bi bi-sign-dead-end display-4"></i></div>
                    <h3 class="text-muted mb-2">Konten tidak ditemukan</h3>
                </div>
            </template>

            <section>
                <div class="row">

                    <!-- LEFT: Lesson list -->
					<div class="d-none d-lg-block col-lg-3 sidebar-col vh-100 pt-2 bg-light-primary" x-show="sidebarVisible" x-transition.opacity>
						<div class="card shadow-none rounded-4 p-3 lesson-sidebar ms-2" style="margin-bottom: 0;">
                            <h5 class="mb-3">Daftar Materi</h5>
                            <div class="lesson-list">
                                <template x-for="(topicLessons, topic) of (data.course?.lessons_grouped || {})" :key="topic">
                                    <div class="mb-3">
                                        <div class="fw-bold mb-2" x-text="topic"></div>
                                        <template x-for="lessonItem of topicLessons" :key="lessonItem.id">
                                            <a href="javascript:void(0)"
                                                @click.prevent="canAccessLessonById(lessonItem.id) && $router.navigate('/courses/' + lessonItem.course_id + '/lesson/' + lessonItem.id)"
                                                :class="{'d-block': true, 'mb-2': true, 'text-decoration-none': true, 'disabled': !canAccessLessonById(lessonItem.id), 'recommended': lessonItem.id === getNextLessonIdFromCourse()}">
                                                <div class="p-2 rounded-2" 
                                                    :class="{
                                                        'bg-success text-white': lessonItem.is_completed,
                                                        'bg-primary text-white': !lessonItem.is_completed && lessonItem.id === data.lesson?.id && canAccessLessonById(lessonItem.id),
                                                        'bg-light': !lessonItem.is_completed && lessonItem.id !== data.lesson?.id && canAccessLessonById(lessonItem.id),
                                                        'bg-light opacity-50': !canAccessLessonById(lessonItem.id)
                                                    }">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <div class="small fw-medium" x-text="lessonItem.lesson_title"></div>
                                                            <div class="small" :class="lessonItem.is_completed ? 'text-white-50' : 'text-muted'" x-text="lessonItem.duration"></div>
                                                        </div>
                                                        <div>
                                                            <template x-if="lessonItem.is_completed">
                                                                <i class="bi bi-check-circle-fill text-white"></i>
                                                            </template>
                                                            <template x-if="!lessonItem.is_completed && canAccessLessonById(lessonItem.id)">
                                                                <i class="bi bi-play-circle-fill" :class="lessonItem.id === data.lesson?.id ? 'text-white' : 'text-primary'"></i>
                                                            </template>
                                                            <template x-if="!lessonItem.is_completed && !canAccessLessonById(lessonItem.id)">
                                                                <i class="bi bi-lock-fill text-muted"></i>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- CENTER: Video + Content -->
					<div class="d-flex flex-column content-col pt-1" :class="sidebarVisible ? 'col-lg-6' : 'col-lg-9'" style="position: relative;">
                        <!-- Toggle Button when sidebar hidden/shown -->
                        <button @click="sidebarVisible = !sidebarVisible" class="sidebar-toggle-btn d-none d-lg-block" x-transition>
                            <i class="bi" :class="sidebarVisible ? 'bi-chevron-left' : 'bi-chevron-right'"></i>
                        </button>
                        
                        <div id="video_player">
                            <div x-show="data?.lesson?.default_video_server" class="ratio ratio-16x9">
                                <iframe
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

                            <!-- Server Selection Buttons -->
                            <div class="btn-group m-3" x-show="data.lesson?.video_diupload && data.lesson?.video_bunny">
                                <button class="btn btn-sm" :class="data.lesson?.default_video_server === 'diupload' ? 'btn-primary' : 'btn-outline-primary'" @click="data.lesson.default_video_server ='diupload'">Server 1</button>
                                <button class="btn btn-sm" :class="data.lesson?.default_video_server === 'bunny' ? 'btn-primary' : 'btn-outline-primary'" @click="data.lesson.default_video_server = 'bunny'">Server 2</button>
                            </div>

                        </div>

                        <!-- Text Content -->
                        <div id="lesson_text_container" class="card border-0 shadow-none rounded-4 p-3 mb-3">
                            <h4 class="fw-normal text-dark opacity-75 mb-1" x-text="data.lesson?.topic_title"></h4>
                            <h2 class="h2 mb-4" x-text="data.lesson?.lesson_title"></h2>
                            <template x-if="data.lesson?.text">
                                <p class="" x-html="data.lesson?.text" x-init="$nextTick(() => setNativeLinks())"></p>
                            </template>
                        </div>

                        <!-- Quiz container -->
                        <div id="lesson_quiz_container">
                            <template x-if="data.lesson?.quiz">
                                <?= $this->include('courses/lesson/quiz') ?>
                            </template>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mb-5 mt-5 border-top px-3 pt-5">
                            <template x-if="data.lesson?.prev_lesson">
                                <div class="d-flex flex-column align-items-start gap-2">
                                    <a :href="`/courses/${data.lesson.course_id}/lesson/${data.lesson?.prev_lesson.id}`" class="btn btn-outline-secondary rounded-pill ps-4 pe-3" style="height:auto; min-height: 38px;">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        <div class="text-start me-3 mt-2 d-none d-lg-block">
                                            <span>Sebelumnya</span>
                                            <h5 class="h6" x-text="data.lesson?.prev_lesson.lesson_title"></h5>
                                        </div>
                                    </a>
                                </div>
                            </template>

                            <template x-if="!data.lesson?.is_completed && data.lesson?.type == 'theory'">
                                <button @click="markAsComplete(data.lesson?.course_id, data.lesson?.id, data.lesson?.next_lesson?.id)" class="btn btn-primary rounded-pill px-4 ms-auto" style="height: auto;min-height: 38px;" :class="{'disabled': !showButtonPaham || buttonSubmitting}" :disabled="buttonSubmitting" x-transition>
                                    <template x-if="!buttonSubmitting">
                                        <i class="bi bi-check-circle me-2"></i>
                                    </template>
                                    <template x-if="buttonSubmitting">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                    </template>
                                    <span class="h6 m-0" x-text="buttonSubmitting ? 'Memproses...' : 'Saya Sudah Paham'"></span>
                                </button>
                            </template>

                            <template x-if="data.lesson?.is_completed && data.lesson?.next_lesson">
                                <div class="d-flex flex-column align-items-end gap-2 ms-auto">
                                    <a :href="`/courses/${data?.lesson?.course_id}/lesson/${data?.lesson?.next_lesson.id}`" class="btn btn-outline-secondary rounded-5 ps-4 pe-3" style="height:auto; min-height: 38px;">
                                        <div class="text-end me-3 mt-2">
                                            <span class="">Selanjutnya</span><br>
                                            <h5 class="h6" x-text="data.lesson?.next_lesson.lesson_title"></h5>
                                        </div>
                                        <i class="bi bi-arrow-right me-2"></i>
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- RIGHT: Course info -->
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="card rounded-4 p-3 mb-3 shadow-none lesson-sidebar">
                            <h5 class="mb-3">Tentang Kelas</h5>
                            <div class="text-muted small" x-html="data.course?.long_description || data.course?.description || ''"></div>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

    <!-- Offcanvas for Lesson List (Mobile) -->
    <div class="offcanvas offcanvas-start offcanvas-lesson-list" tabindex="-1" id="lessonListOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Daftar Materi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="lesson-list px-3">
                <template x-for="(topicLessons, topic) of (data.course?.lessons_grouped || {})" :key="topic">
                    <div class="mb-3">
                        <div class="fw-bold my-2" x-text="topic"></div>
                        <template x-for="lessonItem of topicLessons" :key="lessonItem.id">
                            <a href="javascript:void(0)"
                                @click.prevent="canAccessLessonById(lessonItem.id) && ($router.navigate('/courses/' + lessonItem.course_id + '/lesson/' + lessonItem.id), bootstrap.Offcanvas.getInstance(document.getElementById('lessonListOffcanvas'))?.hide())"
                                :class="{'d-block': true, 'mb-2': true, 'text-decoration-none': true, 'disabled': !canAccessLessonById(lessonItem.id), 'recommended': lessonItem.id === getNextLessonIdFromCourse()}">
                                <div class="p-2 rounded-2" 
                                    :class="{
                                        'bg-success text-white': lessonItem.is_completed,
                                        'bg-primary text-white': !lessonItem.is_completed && lessonItem.id === data.lesson?.id && canAccessLessonById(lessonItem.id),
                                        'bg-light': !lessonItem.is_completed && lessonItem.id !== data.lesson?.id && canAccessLessonById(lessonItem.id),
                                        'bg-light opacity-50': !canAccessLessonById(lessonItem.id)
                                    }">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="small fw-medium" x-text="lessonItem.lesson_title"></div>
                                            <div class="small" :class="lessonItem.is_completed ? 'text-white-50' : 'text-muted'" x-text="lessonItem.duration"></div>
                                        </div>
                                        <div>
                                            <template x-if="lessonItem.is_completed">
                                                <i class="bi bi-check-circle-fill text-white"></i>
                                            </template>
                                            <template x-if="!lessonItem.is_completed && canAccessLessonById(lessonItem.id)">
                                                <i class="bi bi-play-circle-fill" :class="lessonItem.id === data.lesson?.id ? 'text-white' : 'text-primary'"></i>
                                            </template>
                                            <template x-if="!lessonItem.is_completed && !canAccessLessonById(lessonItem.id)">
                                                <i class="bi bi-lock-fill text-muted"></i>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
    <?= $this->include('courses/lesson/script') ?>
</div>