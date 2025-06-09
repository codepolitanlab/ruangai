<div
	class="header-mobile-only"
	id="live_session"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/intro/live_session/data/${$params.course_id}`
    })">

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
		.accordion-item {
			background-color:#f8f8f8;
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
	</style>

	<?= $this->include('_appHeader'); ?>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh">

			<div class="card my-4 rounded-4 shadow-none">
				<div class="card-body">
					<h4 class="h5 mb-3" 
						x-show="data.course?.course_title" 
						x-transition
						x-text="`Live Session - ` + data.course?.course_title + `: ` + data.course?.name"></h4>

					<!-- <div class="d-flex mb-3">
						<div class="date-box attended me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Jan</p>
							<small>09:00</small>
						</div>
						<div class="date-box not-attended me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Feb</p>
							<small>09:00</small>
						</div>
						<div class="date-box currently me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Mar</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Apr</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Mei</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Jun</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Ags</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Sep</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Okt</p>
							<small>09:00</small>
						</div>
						<div class="date-box me-1 p-2 text-center border rounded-3">
							<h4 class="mb-0">01</h4>
							<p class="mb-0">Nov</p>
							<small>09:00</small>
						</div>
					</div> -->

					<div class="card bg-light-secondary pe-3 p-2 rounded-4 border shadow-none">
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
					</div>
				</div>
			</div>

			<div class="card my-4 rounded-4 shadow-none">
				<div class="card-body">

					<!-- Check if no live session -->
					<template x-show="data.live_sessions?.length == 0" x-transition>
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

					<div x-show="data.live_sessions?.length > 0" x-transition>
						<div class="accordion bg-transparent border-0" id="accordion-livesession">

							<template x-for="live_session in data.live_sessions">
							<div class="accordion-item p-2 rounded-4 mb-1" :class="live_session.status_date">
								<div class="accordion-header rounded-4 py-2">
									<button class="accordion-button d-flex flex-column flex-md-row gap-3 align-items-md-center" type="button" data-bs-toggle="collapse" :data-bs-target="`#live_`+live_session.id" aria-expanded="true" :aria-controls="`live_`+live_session.id">
										<div>
											<h5 class="text-muted mb-1 ms-1" x-text="live_session.subtitle"></h5>
											<h4 class="mb-1 ms-1" style="max-width:250px" x-text="live_session.title"></h4>
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
										<div class="badge bg-primary-subtle ms-auto px-2 py-3 text-dark opacity-50" x-show="live_session.status_date == 'upcoming'">Akan datang</div>
										<div class="badge bg-white ms-auto px-2 py-3 text-warning" x-show="live_session.status_date == 'ongoing'"><i class="bi bi-broadcast"></i> Sedang berlangsung</div>
										<div class="badge bg-white border border-success ms-auto px-2 py-3 text-success" x-show="live_session.status_date == 'attended'"><i class="bi bi-check-circle"></i> Sudah mengikuti</div>
										<div class="badge bg-secondary-subtle border border-secondary-subtle ms-auto px-2 py-3 text-dark opacity-75" x-show="live_session.status_date == 'completed'"> Sesi selesai</div>
									</button>
								</div>
								<div :id="`live_`+live_session.id" class="bg-white rounded-4 mt-1 accordion-collapse collapse" data-bs-parent="#accordion-livesession">
									<div class="accordion-body py-3">
										<dl>
											<dt>Deskripsi</dt>
											<dd x-text="live_session.description"></dd>
										</dl>
										<dl>
											<dt>Mentor</dt>
											<dd x-text="live_session.mentor_name"></dd>
										</dl>
										<div class="d-flex gap-2 mt-4">
											<a :href="live_session.zoom_link"
												target="_blank"
												class="btn btn-primary rounded-3" 
												x-show="['ongoing', 'upcoming'].includes(live_session.status_date)" 
												:class="! live_session.zoom_link ? 'disabled' : ''"> 
												<i class="bi bi-camera-video"></i> 
												<span x-text="! live_session.zoom_link ? 'Zoom link belum tersedia' : 'Gabung Zoom'">Gabung Zoom</span>
											</a>
											<template x-if="data.enable_live_recording">
												<a
													:href="live_session.recording_link"
													target="_blank" 
													class="btn btn-danger rounded-3" 
													x-show="['attended','completed'].includes(live_session.status_date)" 
													:class="! live_session.recording_link ? 'disabled' : ''"> 
													<i class="bi bi-play-circle-fill"></i> 
													<span x-text="! live_session.recording_link ? 'Rekaman belum tersedia' : 'Rekaman Video'"></span>
												</a>
											</template>
											<!-- <button class="btn btn-outline-secondary rounded-3"> <i class="bi bi-person-check-fill"></i> Isi Presensi</button> -->
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