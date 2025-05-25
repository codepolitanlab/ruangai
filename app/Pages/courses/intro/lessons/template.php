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
				<template x-for="(topicLessons,topic) of data.course?.lessons" x-data="listLesson()">
					<section class="card shadow-none rounded-3 p-3 mb-3">
						<div class="h5 m-0" x-text="topic"></div>
						<div class="card-body d-flex flex-column align-items-center gap-3 px-0">
							<template x-for="(lesson, lessonID) of topicLessons">
								<a x-bind:href="`/courses/${data.course.id}/lesson/${lessonID}`"
									:class="{'disabled': !canAccessLesson(lessonID, data.lessonsCompleted)}"
									class="d-block w-100">
									<div 
										class="lesson-item rounded-20 p-3 w-100 d-flex align-items-center justify-content-between"
										:class="{'completed': data.lessonsCompleted[lessonID], 'active': canAccessLesson(lessonID, data.lessonsCompleted)}">
										<div>
											<h4 class="fw-normal m-0 mb-1" x-text="lesson.lesson_title"></h4>
											<h5 class="m-0 text-muted" x-text="lesson.duration"></h5>
										</div>
										<div>
											<template x-if="data.lessonsCompleted[lessonID]">
												<i class="bi bi-check-circle-fill text-success h4 m-0"></i>
											</template>
											<template x-if="!data.lessonsCompleted[lessonID] && canAccessLesson(lessonID, data.lessonsCompleted)">
												<i class="bi bi-play-circle-fill text-primary h4 m-0"></i>
											</template>
											<template x-if="!data.lessonsCompleted[lessonID] && !canAccessLesson(lessonID, data.lessonsCompleted)">
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