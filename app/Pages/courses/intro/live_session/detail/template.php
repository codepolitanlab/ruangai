<div
	id="detail_live_session"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/intro/live_session/detail/data/${$params.live_id}`
    })">
	<div id="app-header" class="appHeader main border-0">
		<div class="left"><a class="headerButton" :href="`/courses/intro/${$params.course_id}/${$params.slug}/live_session`"><i class="bi bi-chevron-left"></i></a></div>
		<div class="pageTitle"><span><?= $page_title ?></span></div>
		<div class="right"><a class="headerButton" role="button" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas"><i class="bi bi-share-fill me-1"></i></a></div>
	</div>

	<div id="appCapsule" class="shadow">
		<div class="appContent" style="min-height:90vh">

			<style>
				.cover {
					object-fit: cover;
					width: 100%;
					height: 100%;
				}
			</style>

			<section>
				<div class="container px-4 pt-2">
					<div class="mt-1">
						<div class="badge bg-secondary mb-2 p-2">
							<i class="bi bi-cast h6 m-0"></i>
							<div>Live</div>
						</div>

						<h3>Tips Memanfaatkan AI di Dunia Industri 4.3</h3>
						<p>Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>

						<button class="btn btn-ultra-light-primary rounded-pill px-4 mb-5" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas">
							<i class="bi bi-share-fill me-2"></i>
							Bagikan
						</button>

						<div class="mb-4">
							<h4 class="mb-3">Rekaman Live Sebelumnya</h4>

							<!-- Previous Live Session Card -->
							<template x-for="live_session in data.live_sessions">
								<div class="card card-hover rounded-20 shadow-none border p-3 mb-2">
									<div class="row g-3">
										<div class="col">
											<h4 class="mb-3" x-text="live_session.title"></h4>
											<div class="d-flex gap-3">
												<div><button type="button" class="btn btn-sm btn-secondary rounded-pill"><i class="bi bi-check-circle"></i> Sudah mengikuti</button></div>
												<div class="text-secondary"><i class="bi bi-clock"></i> <span x-text="live_session.date"></span></div>
												<div><i class="bi bi-people"></i> <span x-text="live_session.total_student"></span> Siswa</div>
											</div>
										</div>
									</div>
								</div>
							</template>
						</div>
					</div>
					<!-- Slice here -->
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