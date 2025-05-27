<div
	class="header-mobile-only"
	id="live_session"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/intro/live_session/data/${$params.course_id}`
    })">

	<?= $this->include('_appHeader'); ?>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh">

			<div class="card my-4 rounded-4">
				<div class="card-body">

					<div class="card bg-light-secondary pe-3 p-2 mb-4 rounded-4 border shadow-none">
						<div class="d-flex gap-2 align-items-center">
							<div class="py-1">
								<div class="d-flex align-items-center justify-content-center rounded-4" style="background-color: #F5CEBB; height: 48px; min-width: 48px">
									<i class="bi bi-megaphone-fill fs-4 text-secondary"></i>
								</div>
							</div>
							<div>
								<div class="fw-bold text-secondary">Pengumuman</div>
								<p class="mb-1 text-muted small" style="line-height:16px">Untuk menyelesaikan program ini, kamu wajib mengikuti min. 3 sessi live</p>
							</div>
						</div>
					</div>

					<!-- Check if no live session -->
					<template x-show="data.live_sessions?.length == 0">
						<div class="card card-hover rounded-20 shadow-none border p-3 mb-2">
							<div class="row g-3">
								<div class="col">
									<div class="d-flex justify-content-between align-items-start">
										<div>
											<div class="d-flex gap-3 align-items-center">
												<h5 class="text-pink m-0">Belum ada live session</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</template>

					<div>
						<div class="accordion bg-transparent border-0" id="accordion-livesession">

							<template x-for="live_session in data.live_sessions">
							<div class="accordion-item p-2 bg-dark bg-opacity-10 rounded-4 mb-1">
								<div class="accordion-header bg-white rounded-4 py-2 d-flex flex-column flex-md-row gap-3 align-items-md-center">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="`#live_`+live_session.id" aria-expanded="true" :aria-controls="`live_`+live_session.id">
										<div>
											<h5 class="text-muted mb-1 ms-1" x-text="live_session.subtitle"></h5>
											<h4 class="mb-1 ms-1" x-text="live_session.title"></h4>
											<p class="m-0 d-flex gap-3 text-muted">
												<span class="d-flex">
													<i class="bi bi-calendar me-1 fs-6"></i>
													<span x-text="$heroicHelper.formatDate(live_session.meeting_date)"></span>
												</span>
												<span class="d-flex">
													<i class="bi bi-clock me-1 fs-6"></i>
													<span x-text="live_session.meeting_time.substring(0, 5) + ` WIB`"></span>
												</span>
											</p>
										</div>
										<div class="badge bg-warning ms-auto p-2 text-dark">Belum Dimulai</div>
									</button>
								</div>
								<div :id="`live_`+live_session.id" class="bg-white rounded-4 mt-1 accordion-collapse collapse" data-bs-parent="#accordion-livesession">
									<div class="accordion-body">
										<dl>
											<dt>Deskripsi</dt>
											<dd x-text="live_session.description"></dd>
										</dl>
										<dl>
											<dt>Mentor</dt>
											<dd>Felisha Rehtaliani, Aji Raga Pamungkas</dd>
										</dl>
										<div class="d-flex gap-2 mt-4">
											<button class="btn btn-primary rounded-3"> <i class="bi bi-camera-video"></i> Gabung Zoom</button>
											<button class="btn btn-outline-secondary rounded-3"> <i class="bi bi-person-check-fill"></i> Isi Presensi</button>
										</div>
									</div>
								</div>
							</div>
							</template>

						</div>
					</div>
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