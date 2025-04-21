<div
	id="lesson_detail"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        getUrl: `courses/lessons/data/${$router.params.id}`
    })">
	<div id="app-header" class="appHeader main border-0">
		<div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
		<div class="pageTitle"><span>Detail Lessons</span></div>
	</div>

	<div id="appCapsule" class="shadow">
		<div class="appContent" style="min-height:90vh">
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

				.author img {
					width: 80px;
				}
			</style>

			<section>
				<div x-show="data.lesson?.player == 'youtube'" class="ratio ratio-16x9">
					<iframe width="560" height="315" :src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>
				<div class="container px-3">
					<div class="mt-4">
						<h2 x-text="data.lesson?.lesson_title"></h2>
						<p class="">Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>

						<!-- Action Buttons -->
						<div class="d-flex gap-3 mb-5">
							<button class="btn btn-ultra-light-primary rounded-pill px-4" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas">
								<i class="bi bi-share-fill me-2"></i>
								Bagikan
							</button>
							<button class="btn btn-ultra-light-primary rounded-pill px-4">
								Forum
							</button>
							<button class="btn btn-primary rounded-pill px-4 ms-auto">
								<i class="bi bi-skip-forward-fill me-2"></i>
								Berikutnya
							</button>
						</div>

						<!-- Lesson List -->
						<div>
							<h3 class="mb-3">Materi Belajar Lainnya</h3>

							<div class="card shadow-none border mb-3 p-3 rounded-20">
								<template x-for="(lesson, index) in data.course?.lessons" :key="index">
									<div>
										<h5 class="mb-1" x-text="lesson.section_title"></h5>
										<!-- Card Lesson -->
										<a x-bind:href="`/courses/lessons/${lesson.id}`" class="d-block w-100 card-hover">
											<div class="card rounded-20 p-3 mb-2" :class="lesson.id == $router.params.id ? 'bg-primary text-white' : 'bg-secondary-subtle'">
												<div class="d-flex justify-content-between align-items-center">
													<div>
														<div class="h6 fw-bold mb-1" x-text="lesson.lesson_title"></div>
														<div x-text="lesson.duration"></div>
													</div>
													<div class="">
														<i x-show="lesson.id == $router.params.id" class="bi bi-check-circle-fill h4 m-0 fs-4"></i>
														<i x-show="lesson.id != $router.params.id" class="bi bi-lock-fill h4 m-0 text-muted fs-4"></i>
													</div>
												</div>
											</div>
										</a>
									</div>
								</template>
							</div>
						</div>
					</div>
				</div>
			</section>

		</div>
	</div>
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body small"></div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>