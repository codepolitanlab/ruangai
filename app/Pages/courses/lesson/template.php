<div
	class="container-large"
	id="lesson_detail"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/lesson/data/${$params.id}`
    })"
	x-effect="loadPage(`courses/lesson/data/${$params.id}`)">

	<div id="app-header" class="appHeader main border-0">
		<div class="left">
			<a class="headerButton" :href="`/courses/intro/${data.course.id}/${data.course.slug}/lessons`"><i class="bi bi-chevron-left"></i></a>
			<span x-text="data.course.lessons.find(lesson => lesson.id == $params.id).topic_title"></span>
		</div>
		<div class="pageTitle"></div>
	</div>

	<div id="appCapsule" class="appCapsule-lg" x-data="lesson()">
		<div class="appContent px-0 bg-white rounded-4" style="min-height:95vh">

			<section>
				<!-- If player Youtube -->
				<div x-show="data.lesson?.player == 'youtube'" class="ratio ratio-16x9">
					<iframe width="560" height="315"
						:src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}?autoplay=1&mute=1`"
						title="YouTube video player"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
						referrerpolicy="strict-origin-when-cross-origin"
						allowfullscreen>
					</iframe>
				</div>

				<!-- If player Bunny -->
				<div x-show="data.lesson?.player == 'bunnystream'" class="ratio ratio-16x9">
					<!-- <iframe width="560" height="315" :src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
				</div>

				<!-- If player Diupload -->
				<div x-show="data.lesson?.player == 'diupload'" class="ratio ratio-16x9">
					<!-- <iframe width="560" height="315" :src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
				</div>

				<div class="container">
					<div class="mt-4">
						<div class="card border-0 shadow-none rounded-4 p-3 mb-3">
							<h2 x-text="data.lesson?.lesson_title"></h2>
							<p class="">Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>
						</div>

						<!-- Action Buttons -->
						<div class="d-flex gap-3 mb-5">
							<template x-if="data.lesson?.prev_lesson">
								<div class="d-flex flex-column align-items-start gap-2">
									<a :href="`/courses/lesson/${data.lesson?.prev_lesson.id}`" 
										class="btn btn-outline-secondary rounded-pill ps-4 pe-3 py-4">
										<i class="bi bi-arrow-left me-2"></i>
										<div class="text-start me-3 mt-2">
											<span>Sebelumnya</span>
											<h5 class="h6" x-text="data.lesson?.prev_lesson.lesson_title"></h5>
										</div>
									</a>
								</div>
							</template>

							<template x-if="!data.lesson?.is_completed && data.lesson?.next_lesson">
								<button @click="markAsComplete(data.lesson?.id, data.lesson?.next_lesson?.id)" 
									class="btn btn-lg btn-primary rounded-pill px-4 ms-auto"
									:class="showButtonPaham ? '' : 'disabled'"
									x-transition>
									<i class="bi bi-check-circle me-2"></i>
									Saya Sudah Faham
								</button>
							</template>
							
							<template x-if="data.lesson?.is_completed && data.lesson?.next_lesson">
								<div class="d-flex flex-column align-items-end gap-2 ms-auto">
									<a :href="`/courses/lesson/${data.lesson?.next_lesson.id}`" 
									   class="btn btn-outline-secondary rounded-pill ps-4 pe-3 py-4">
										<div class="text-end me-3 mt-2">
											<span class="">Selanjutnya</span><br>
											<h5 class="h6 " x-text="data.lesson?.next_lesson.lesson_title"></h5>
										</div>
										<i class="bi bi-arrow-right me-2"></i>
									</a>
								</div>
							</template>

							<template x-if="!data.lesson?.next_lesson">
								<div class="ms-auto">
									<button @click="markAsComplete(data.lesson?.id, data.lesson?.next_lesson?.id)" class="btn btn-success rounded-pill px-4">
										<i class="bi bi-check-circle-fill me-2"></i>
										Selesai
									</button>
								</div>
							</template>
						</div>
					</div>
				</div>
			</section>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('courses/lesson/script') ?>
</div>