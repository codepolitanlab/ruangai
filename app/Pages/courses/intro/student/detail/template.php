<div id="student_detail"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
		url: `courses/intro/student/detail/data/${$params.id}`
    })"
	>
	<div id="app-header" class="appHeader main border-0">
		<div class="left"><a class="headerButton" :href="`/courses/intro/${$params.course_id}/${$params.slug}/student`"><i class="bi bi-chevron-left"></i></a></div>
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

				.progress {
					height: 8px;
					background: #eaeaea !important;
				}

				.progress-bar {
					background: #AEAEAE;
				}
			</style>
			<section>
				<div class="container px-3">

					<!-- Profile Section -->
					<div class="text-center mb-4 mt-3">
						<div style="height:400px" class="mx-auto mb-3">
							<img :src="data.student?.avatar" class="cover rounded-20" alt="Student Profile">
						</div>
						<h3 class="mb-2" x-text="data.student?.name"></h3>
						<p class="mb-3">CODING IS A SHINOBI WAYS FOR ME!!!!!</p>
						<div class="bg-ultra-light rounded-pill px-4 py-2 d-inline-block">
							<div>Enroll Kelas : 24 Oktober 2025</div>
						</div>
					</div>

					<!-- Progress Section -->
					<div class="mt-5">
						<div class="card shadow-none border bg-primary rounded-20 p-3 mb-3 text-white">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<div class="h5 m-0">Batch 1</div>
								<i class="bi bi-shield-fill-check fs-4"></i>
							</div>
							<div class="d-flex align-items-center gap-3">
								<div class="progress flex-grow-1 bg-white">
									<div class="progress-bar bg-light" role="progressbar" style="width: 100%"></div>
								</div>
								<div class="">100%</div>
							</div>
						</div>

						<div class="card shadow-none border rounded-20 p-3 mb-3">
							<h5 class="mb-2">Batch 2</h5>
							<div class="d-flex align-items-center gap-3">
								<div class="progress flex-grow-1">
									<div class="progress-bar bg-primary" role="progressbar" style="width: 70%"></div>
								</div>
								<div>70%</div>
							</div>
						</div>

						<div class="card shadow-none border rounded-20 p-3 mb-3">
							<h5 class="mb-2">Batch 3</h5>
							<div class="d-flex align-items-center gap-3">
								<div class="progress flex-grow-1">
									<div class="progress-bar bg-primary" role="progressbar" style="width: 50%"></div>
								</div>
								<div>50%</div>
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