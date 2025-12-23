<div
	class="header-mobile-only"
	id="live_session"
	x-data="sesiLive(`${$params.course_id}`)"
	x-effect="loadPage(`courses/intro/live_session/data/${$params.course_id}`)">

	<style>
		.date-box {
			line-height: 13px;
			max-width: 70px;
			width: 70px;
		}

		.date-box.attended,
		.date-box.attended h4 {
			background-color: #77CD94;
			color: white;
		}

		.date-box.not-attended,
		.date-box.not-attended h4 {
			background-color: #ef7071;
			color: white;
		}

		.date-box.currently {
			border: 1px solid #00BCD4 !important;
			background-color: #F3FBFE;
		}

		.date-box p {
			font-size: 13px;
		}

		.date-box small {
			font-size: 11px;
		}

		.accordion-item .accordion-header {
			background-color: white;
		}

		.accordion-item.completed .accordion-header {
			background-color: #ccc;
		}

		.accordion-item.attended {
			background-color: #E5FDEC;
		}

		.accordion-item.attended .accordion-header {
			background-color: #77CD94;
		}

		.accordion-item.ongoing {
			background-color: #fff3cf;
		}

		.accordion-item.ongoing .accordion-header {
			background-color: #FFC107;
		}

		.accordion-item.attended .accordion-button h4,
		.accordion-item.attended .accordion-button h5,
		.accordion-item.attended .accordion-button p,
		.accordion-item.attended .accordion-button .text-muted,
		.accordion-item.ongoing .accordion-button h4,
		.accordion-item.ongoing .accordion-button h5,
		.accordion-item.ongoing .accordion-button p,
		.accordion-item.ongoing .accordion-button .text-muted {
			color: white !important;
		}

		.bg-warning-2 {
			background-color: #fe9500;
		}
	</style>


	<div id="appCapsule" class="">
		<?= $this->include('courses/intro/_menu'); ?>

		<div class="appContent" style="min-height:90vh">

			<div class="card my-4 rounded-4 shadow-none">
				<div class="card-body">
					<h4 class="h5"
						x-show="data.course?.course_title"
						x-transition
						x-text="`Live Session - ` + data.course?.course_title"></h4>

					<!-- <div class="card bg-light-secondary pe-3 p-2 rounded-4 border shadow-none">
						<div class="d-flex gap-2 align-items-center">
							<div class="py-1">
								<div class="d-flex align-items-center justify-content-center rounded-4" style="background-color: #F5CEBB; height: 48px; min-width: 48px">
									<i class="bi bi-megaphone-fill fs-4 text-secondary"></i>
								</div>
							</div>
							<div>
								<div class="fw-bold text-secondary">Pengumuman</div>
								<p class="mb-1 text-muted small" style="line-height:16px">Untuk menyelesaikan program ini, kamu wajib mengikuti min. 3 sesi live</p>
							</div>
						</div>
					</div> -->
				</div>
			</div>

			<!-- Show Expire Alert -->
			<template x-if="data.is_expire">
				<div class="card bg-warning-2 rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3">
						<i class="bi bi-stopwatch-fill text-white display-3 shaky-icon"></i>
						<div>
							<h4 class="text-white">Program Belajar Chapter 1 Telah Berakhir</h4>
							<p class="m-0 text-white">Tapi tenang saja! Kamu tetap dapat melanjutkan belajar saat Chapter 2 dibuka.</p>
						</div>
					</div>
				</div>
			</template>

			<div class="nav nav-pills mb-1 gap-2">
				<div class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#upcoming">Jadwal Sesi</a>
				</div>
				<div class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#ongoing">Sesi yang Diikuti</a>
				</div>
			</div>

			<div class="tab-content" id="pills-tabContent">
				<!-- List Upcoming -->
				<div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab" tabindex="0">
					<div class="my-4 rounded-4 shadow-none">
						<div class="card-body">

							<!-- Check if no live session -->
							<template x-if="data.live_sessions?.scheduled.length < 1" x-transition>
								<div class="row g-3">
									<div class="col">
										<div class="d-flex justify-content-between align-items-start">
											<div>
												<div class="d-flex gap-3 align-items-center">
													<h5 class="text-dark fst-italic opacity-50 m-0">
														<i class="bi bi-cup-straw"></i>
														Belum ada jadwal live session terbaru
													</h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</template>

							<!-- hanya tampil jika is_reference_followup true -->
							<template x-if="data.is_reference_followup" x-transition>
								<div class="mb-5" x-show="data.live_sessions?.ongoing.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Event Hari Ini</h4>
									<?= $this->include('courses/intro/live_session/meeting_ongoing') ?>
								</div>
	
								<div class="mb-5" x-show="data.live_sessions?.scheduled.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Event Mendatang</h4>
									<?= $this->include('courses/intro/live_session/meeting_scheduled') ?>
								</div>
	
								<div x-show="data.live_sessions?.completed.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Sudah Selesai</h4>
									<?= $this->include('courses/intro/live_session/meeting_completed') ?>
								</div>
							</template>
						</div>
					</div>
				</div>
			</div>

			<!-- List Attended -->
			<div class="tab-pane fade" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab" tabindex="0">
				<div class="my-4 rounded-4 shadow-none">

					<?= $this->include('courses/intro/live_session/meeting_attended') ?>

				</div>
			</div>
		</div>

		<div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
			<div class="offcanvas-header">
				<h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body small"></div>
		</div>

	</div>
	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('courses/intro/live_session/script') ?>