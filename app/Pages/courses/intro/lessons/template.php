<div
	class="header-mobile-only"
	id="course_intro"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/courses/intro/lessons/data/${$params.course_id}`
    })"
	x-effect="loadPage(`/courses/intro/lessons/data/${$params.course_id}`)">

	<?= $this->include('_appHeader'); ?>

	<style>
		.disabled {
			pointer-events: none;
			opacity: 0.6;
			cursor: not-allowed;
		}

		.lesson-item {
			background-color: #F6F6F6;
		}

		.lesson-item.completed {
			background-color: #7BCC94 !important;
			color: #eee;
		}

		.lesson-item.active.completed {
			border: 0 !important;
		}

		.lesson-item.active {
			border: 2px solid #79B2CD !important;
		}

		.lesson-item.completed h4,
		.lesson-item.completed h5,
		.lesson-item.completed .bi {
			color: #fff !important;
		}
		.bg-warning-2 {
			background-color: #fe9500;
		}
	</style>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh" x-data="listLesson()">

			<div class="card my-4 rounded-4 shadow-none">
				<div class="card-body d-flex justify-content-between">
					<div>
						<h4 class="h5" x-text="data.course?.course_title"></h4>
						<p>
							<span class="h5 text-primary opacity-100" x-text="data.numCompleted"></span>
							<span class="text-dark opacity-50">/
								<span x-text="data.lessonsCompleted ? data.lessonsCompleted.length : 0"></span>
								materi selesai
							</span>
						</p>
						<button x-show="data.student.progress < 100" class="btn btn-secondary btn-sm rounded-pill"
							x-on:click="$router.navigate(`/courses/${data.course?.id}/lesson/${nextLesson(data.lessonsCompleted)}`)">
							Lanjutkan Belajar</button>

						<button x-show="data.student.progress == 100" class="btn btn-secondary btn-sm rounded-pill"
							x-on:click="$router.navigate(`/courses/${data.course?.id}/lesson/${data.lessonsCompleted[0].id}`)">
							Belajar Lagi</button>
					</div>

					<svg class="progress-ring" width="120" height="120">
						<circle class="progress-ring__circle-bg" stroke="#e9ecef" stroke-width="10" fill="transparent" r="50" cx="60" cy="60" />
						<circle class="progress-ring__circle" stroke="#81B0CA" stroke-width="10" fill="transparent" r="50" cx="60" cy="60"
							stroke-dasharray="314" :stroke-dashoffset="314 - (314 * countPercentageCompleteness(data.numCompleted ?? 0, data.lessonsCompleted ?? 1)) / 100" transform="rotate(-90 60 60)" />
						<text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size="1.2rem" fill="#81B0CA" x-text="countPercentageCompleteness(data.numCompleted ?? 0, data.lessonsCompleted ?? 1) + '%'"></text>
					</svg>
				</div>
			</div>

			<!-- Show Expire Alert -->
			<template x-if="data.is_expire">
				<div class="card bg-warning-2 rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3">
						<i class="bi bi-stopwatch-fill text-white display-3 shaky-icon"></i>
						<div>
							<h4 class="text-white">Waktu akses kamu untuk kelas ini telah berakhir</h4>
							<p class="m-0 text-white">Tapi tenang aja! Silakan hubungi tim admin temanRAI via email ke <u><a class="text-white fw-bold" href="mailto:temanrai@codepolitan.com">temanrai@codepolitan.com</a></u> untuk permintaan perpanjangan kelas ini.</p>
						</div>
					</div>
				</div>
			</template>

			<template x-if="!data.course?.lessons || Object.keys(data.course?.lessons).length === 0">
				<div class="card shadow-none rounded-4 p-3 mb-3 text-center">
					<div class="mb-3">
						<i class="bi bi-journal-x display-4"></i>
					</div>
					<h3 class="text-muted mb-2">Belum Ada Materi</h3>
					<p class="text-muted">Materi untuk kursus ini belum tersedia.</p>
				</div>
			</template>

			<template x-if="data.course?.lessons && Object.keys(data.course?.lessons).length > 0">
				<template x-for="(topicLessons,topic) of data.course?.lessons">
					<section class="card shadow-none rounded-4 p-3 mb-3">
						<div class="h5 m-0" x-text="topic"></div>
						<div class="card-body d-flex flex-column align-items-center gap-3 px-0">
							<template x-for="(lesson, lessonID) of topicLessons">
								<a :native="data.is_expire"
									:href="data.is_expire ? `javascript:void()` : `/courses/${data.course.id}/lesson/${lessonID}`"
									:class="{'disabled': !canAccessLesson(lessonID, data.lessonsCompleted)}"
									class="d-block w-100">
									<div
										class="lesson-item rounded-20 p-3 w-100 d-flex align-items-center justify-content-between"
										:class="{ 'completed': isLessonCompleted(lessonID, data.lessonsCompleted),
												  'active': canAccessLesson(lessonID, data.lessonsCompleted),
												  'disabled': data.is_expire }">
										<div>

											<h4 class="fw-normal m-0 mb-1" x-text="lesson.lesson_title"></h4>
											<h5 class="m-0 text-muted" x-text="lesson.duration"></h5>
										</div>
										<div>
											<template x-if="isLessonCompleted(lessonID, data.lessonsCompleted)">
												<i class="bi bi-check-circle-fill text-success h4 m-0"></i>
											</template>
											<template x-if="!isLessonCompleted(lessonID, data.lessonsCompleted) && canAccessLesson(lessonID, data.lessonsCompleted)">
												<i class="bi bi-play-circle-fill text-primary h4 m-0"></i>
											</template>
											<template x-if="!isLessonCompleted(lessonID, data.lessonsCompleted) && !canAccessLesson(lessonID, data.lessonsCompleted)">
												<i class="bi bi-lock-fill text-dark opacity-50 h4 m-0"></i>
											</template>
										</div>
									</div>
								</a>
							</template>
						</div>
					</section>
				</template>
			</template>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('courses/intro/lessons/script') ?>