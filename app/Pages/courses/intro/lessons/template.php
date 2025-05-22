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
		.accordion-body {
			padding: 0 .25rem;
		}

		.list-group-item {
			border: 0;
		}

		.accordion-body,
		.accordion-body .list-group-item {
			background: #fff !important;
		}

		.hovered:hover {
			background: #eee !important;
		}

		.cover {
			object-fit: cover;
			width: 100%;
			height: 100%;
		}

		.progress,
		.progress-bar {
			height: 22px;
		}

		.lessons a {
			color: #009688;
			font-weight: 400;
			font-size: 1rem;
		}

		.disabled {
			pointer-events: none;
			opacity: 0.6;
			cursor: not-allowed;
		}

		.author img {
			width: 80px;
		}
	</style>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh">

			<?= $this->include('courses/intro/_header'); ?>

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
				<template x-for="(lessons,topic) of data.course?.lessons" x-data="listLesson()">
					<section class="card shadow-none rounded-3 p-3 mb-3">
						<div class="h5 m-0" x-text="topic"></div>
						<div class="card-body d-flex flex-column align-items-center gap-3 px-0">
							<template x-for="(lesson, index) of lessons">
								<a x-bind:href="`/courses/${data.course.id}/lesson/${lesson.id}`"
									:class="{'disabled': !canAccessLesson(lesson, index, lessons, data.course?.lessons)}"
									class="d-block w-100">
									<div class="rounded-20 p-3 w-100 d-flex bg-light align-items-center justify-content-between">
										<div>
											<h4 class="fw-normal m-0 mb-1" x-text="lesson.lesson_title"></h4>
											<h5 class="m-0 text-muted" x-text="lesson.duration"></h5>
										</div>
										<div>
											<template x-if="lesson.is_completed">
												<i class="bi bi-check-circle text-success h4 m-0"></i>
											</template>
											<template x-if="!lesson.is_completed && canAccessLesson(lesson, index, lessons, data.course?.lessons)">
												<i class="bi bi-play-circle text-primary h4 m-0"></i>
											</template>
											<template x-if="!lesson.is_completed && !canAccessLesson(lesson, index, lessons, data.course?.lessons)">
												<i class="bi bi-lock h4 m-0"></i>
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

	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body small"></div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('courses/intro/lessons/script') ?>
</div>