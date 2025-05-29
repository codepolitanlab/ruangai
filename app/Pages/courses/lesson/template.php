<div
	class="container-large"
	id="lesson_detail"
	x-data="lesson_detail_script($params.course_id, $params.lesson_id, <?= service('settings')->get('Course.waitToEnableButtonUnderstand'); ?>)"
	x-effect="loadPage(`courses/lesson/data/${$params.course_id}/${$params.lesson_id}`); setTimerButtonPaham()">

	<div id="app-header" class="appHeader main border-0">
		<div class="left">
			<a class="headerButton" :href="`/courses/intro/${data.lesson?.course_id}/${data.lesson?.course_slug}/lessons`"><i class="bi bi-chevron-left"></i></a>
		</div>
		<div class="">
			<span x-text="data.lesson?.course_title + ' - ' + data.lesson?.topic_title"></span>
		</div>
	</div>

	<div id="appCapsule" class="appCapsule-lg">
		<div class="appContent px-0 bg-white rounded-bottom-4" style="min-height:95vh">

			<section>
				<div id="video_player">

					<!-- If player Youtube -->
					<!-- <div x-show="data.lesson?.player == 'youtube'" class="ratio ratio-16x9">
						<iframe width="560" height="315"
							:src="`${data.lesson?.video}&autoplay=1`"
							title="YouTube video player"
							frameborder="0"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
							referrerpolicy="strict-origin-when-cross-origin"
							allowfullscreen>
						</iframe>
					</div> -->

					<!-- Video Player -->
					<div x-show="data.lesson?.default_video_server" class="ratio ratio-16x9">
						<iframe
							:id="data.lesson?.default_video_server + `-player`"
							width="560"
							height="315"
							:src="getVideoUrl(data.lesson?.default_video_server, data.lesson['video_' + data.lesson?.default_video_server])"
							title="Video player"
							frameborder="0"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
							referrerpolicy="strict-origin-when-cross-origin"
							allowfullscreen>
						</iframe>
					</div>

					<!-- Server Selection Buttons -->
					<div class="btn-group m-3" x-show="data.lesson?.video_diupload && data.lesson?.video_bunny">
						<button 
							class="btn btn-sm" 
							:class="data.lesson?.default_video_server === 'diupload' ? 'btn-primary' : 'btn-outline-primary'" 
							@click="data.lesson.default_video_server ='diupload'">
							Server 1</button>
						<button 
							class="btn btn-sm" 
							:class="data.lesson?.default_video_server === 'bunny' ? 'btn-primary' : 'btn-outline-primary'" 
							@click="data.lesson.default_video_server = 'bunny'">
							Server 2</button>
					</div>
				</div>

				<div class="container">

					<div id="lesson_text_container"
						class="card border-0 shadow-none rounded-4 p-3 mb-3">
						<h2 class="h2 mb-5" x-text="data.lesson?.lesson_title"></h2>

						<template x-if="data.lesson?.text">
							<p class="" x-html="data.lesson?.text"></p>
						</template>
					</div>

					<div id="lesson_quiz_container">
						<template x-if="data.lesson?.quiz">
							<?= $this->include('courses/lesson/quiz') ?>
						</template>
					</div>

					<!-- Action Buttons -->
					<div class="d-flex gap-3 mb-5 mt-5 border-top pt-5">
						<template x-if="data.lesson?.prev_lesson">
							<div class="d-flex flex-column align-items-start gap-2">
								<a :href="`/courses/${data.lesson.course_id}/lesson/${data.lesson?.prev_lesson.id}`"
									class="btn btn-outline-secondary rounded-pill ps-4 pe-3" style="height:auto; min-height: 48px;">
									<i class="bi bi-arrow-left me-2"></i>
									<div class="text-start me-3 mt-2 d-none d-lg-block">
										<span>Sebelumnya</span>
										<h5 class="h6" x-text="data.lesson?.prev_lesson.lesson_title"></h5>
									</div>
								</a>
							</div>
						</template>

						<template x-if="!data.lesson?.is_completed && data.lesson?.type == 'theory'">
							<button @click="markAsComplete(data.lesson?.course_id, data.lesson?.id, data.lesson?.next_lesson?.id)"
								class="btn btn-lg btn-primary rounded-pill px-4 ms-auto"
								:class="{'disabled': !showButtonPaham, 'btn-progress': buttonSubmitting}"
								x-transition>
								<i class="bi bi-check-circle me-2"></i>
								Saya Sudah Paham
							</button>
						</template>

						<template x-if="data.lesson?.is_completed && data.lesson?.next_lesson">
							<div class="d-flex flex-column align-items-end gap-2 ms-auto">
								<a :href="`/courses/${data.lesson.course_id}/lesson/${data.lesson?.next_lesson.id}`"
									class="btn btn-outline-secondary rounded-5 ps-4 pe-3" style="height:auto">
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
			</section>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('courses/lesson/script') ?>
</div>