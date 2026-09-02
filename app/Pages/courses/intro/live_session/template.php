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

		/* ==============================================================
		   TEMA GELAP — disamakan dengan dashboard home user (tanpa ubah logic)
		   ============================================================== */
		#live_session {
			background-color: var(--rd-bg);
			color: var(--rd-text);
			min-height: 100vh;
		}
		#live_session #appCapsule {
			background-color: var(--rd-bg) !important;
			color: var(--rd-text);
		}
		#live_session .card,
		#live_session .card-body {
			background-color: var(--rd-surface) !important;
			color: var(--rd-text) !important;
			border-color: var(--rd-border) !important;
		}
		#live_session h1, #live_session h2, #live_session h3,
		#live_session h4, #live_session h5, #live_session h6,
		#live_session .h4, #live_session .h5, #live_session .h6 {
			color: var(--rd-text) !important;
		}
		#live_session .text-muted { color: var(--rd-text-muted) !important; }
		#live_session .text-dark { color: var(--rd-text) !important; }
		#live_session .text-primary { color: var(--rd-primary) !important; }
		#live_session .text-success { color: var(--rd-green, #22C55E) !important; }
		#live_session .text-warning { color: #f5a623 !important; }

		/* Tabs */
		#live_session .nav-pills .nav-link { color: var(--rd-text-muted); }
		#live_session .nav-pills .nav-link.active {
			background-color: var(--rd-primary);
			color: var(--rd-primary-contrast);
		}

		/* Accordion */
		#live_session .accordion-item {
			background-color: var(--rd-surface) !important;
			border-color: var(--rd-border) !important;
			color: var(--rd-text) !important;
		}
		#live_session .accordion-header { background-color: var(--rd-surface) !important; }
		#live_session .accordion-button {
			background-color: var(--rd-surface) !important;
			color: var(--rd-text) !important;
			box-shadow: none;
		}
		#live_session .accordion-button:not(.collapsed) {
			background-color: var(--rd-surface-2) !important;
			color: var(--rd-text) !important;
		}
		#live_session .accordion-button::after { filter: invert(1); }
		#live_session .accordion-collapse.bg-light { background-color: var(--rd-surface) !important; }
		#live_session .bg-light { background-color: var(--rd-surface) !important; }

		/* Status tint accordion */
		#live_session .accordion-item.attended { background-color: rgba(34, 197, 94, 0.14) !important; }
		#live_session .accordion-item.attended .accordion-header { background-color: rgba(34, 197, 94, 0.22) !important; }
		#live_session .accordion-item.ongoing { background-color: rgba(255, 193, 7, 0.1) !important; }
		#live_session .accordion-item.ongoing .accordion-header { background-color: rgba(255, 193, 7, 0.2) !important; }
		#live_session .accordion-item.completed .accordion-header { background-color: var(--rd-surface-2) !important; }

		/* Date box */
		#live_session .date-box.currently {
			background-color: var(--rd-surface-2) !important;
			border-color: #00BCD4 !important;
		}

		/* Badges */
		#live_session .bg-white { background-color: var(--rd-surface-2) !important; }
		#live_session .bg-primary-subtle,
		#live_session .bg-secondary-subtle { background-color: var(--rd-surface-2) !important; }
		#live_session .badge.text-dark { color: var(--rd-text) !important; }

		/* Buttons */
		#live_session .btn-primary {
			background-color: var(--rd-primary) !important;
			border-color: var(--rd-primary) !important;
			color: var(--rd-primary-contrast) !important;
		}
		#live_session .btn-secondary {
			background-color: var(--rd-surface-2) !important;
			border-color: var(--rd-border) !important;
			color: var(--rd-text) !important;
		}

		/* Offcanvas share */
		#live_session .offcanvas {
			background-color: var(--rd-surface) !important;
			color: var(--rd-text) !important;
		}
		#live_session .offcanvas-header { border-color: var(--rd-border) !important; }
		#live_session .btn-close { filter: invert(1); }

		/* Menu (_menu partial) */
		#live_session #course-features .btn-white.bg-white {
			background-color: var(--rd-surface) !important;
			color: var(--rd-primary) !important;
			border-color: var(--rd-border) !important;
		}
	</style>


	<div id="appCapsule" class="">
		<?= $this->include('courses/intro/_menu'); ?>

		<div class="appContent" style="min-height:90vh">

			<div class="card my-4 rounded-4 shadow-none">
				<div class="card-body">
					<h4 class="h5"
						x-show="data?.course?.course_title"
						x-transition
						x-text="`Live Session - ` + data?.course?.course_title"></h4>

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
			<template x-if="data?.is_expire && data?.student?.program !== 'RuangAI2026WSGenAI'">
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
							<template x-if="data?.live_sessions?.scheduled.length < 1" x-transition>
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

							<!-- tampil jika is_reference_followup true ATAU user role_id = 1 atau 3 -->
							<div x-show="(data?.is_reference_followup && data?.student.graduate == '0') || [1,3].includes(+data?.user?.role_id) || data?.program === 'RuangAI2025B4' || data?.prev_chapter === 'RuangAI2025B4' || data?.is_followup || data?.is_mentee_comentor" x-transition>
								<div class="mb-5" x-show="data?.live_sessions?.ongoing.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Event Hari Ini</h4>
									<?= $this->include('courses/intro/live_session/meeting_ongoing') ?>
								</div>
	
								<div class="mb-5" x-show="data?.live_sessions?.scheduled.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Event Mendatang</h4>
									<?= $this->include('courses/intro/live_session/meeting_scheduled') ?>
								</div>
	
								<div x-show="data?.live_sessions?.completed.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Sudah Selesai</h4>
									<?= $this->include('courses/intro/live_session/meeting_completed') ?>
								</div>
							</div>
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