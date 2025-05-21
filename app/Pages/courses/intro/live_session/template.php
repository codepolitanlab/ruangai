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

			<?= $this->include('courses/intro/_header'); ?>

			<section>
				<div class="">

					<div class="card bg-light-secondary p-2 mb-4 rounded-4 border shadow-none">
						<div class="row">
							<div class="col-2">
								<div class="d-flex align-items-center justify-content-center rounded-4" style="background-color: #F5CEBB;height: 50px;width: 50px">
									<i class="bi bi-megaphone-fill fs-4 text-secondary"></i>
								</div>
							</div>
							<div class="col-10">
								<div class="d-flex flex-column">
									<div class="fw-bold text-secondary">Pengumuman</div>
									<small class="lh-base text-muted">Untuk menyelesaikan beasiswa ini, kamu wajib mengikuti 3x live session</small>
								</div>
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

					<div class="accordion p-3 border-0 rounded-4" id="accordionPanelsStayOpenExample">
						<template x-show="data.live_sessions?.length > 0" x-for="(live_session, index) in data.live_sessions" :key="index">
							<div class="accordion-item card card-hover rounded-20 shadow-none border p-3 mb-2">
								<div type="button" :data-bs-toggle="'collapse'" :data-bs-target="'#panelsStayOpen-collapse-' + index" :aria-expanded="index === 0 ? 'true' : 'false'" :aria-controls="'panelsStayOpen-collapse-' + index">
									<div class="row g-3">
										<div class="col">
											<h4 class="mb-3" x-text="live_session.title"></h4>
											<div class="d-flex gap-3" x-data="{
													sessionDate: new Date(live_session.date),
													today: new Date(),
													getSessionStatus: function() {
														this.sessionDate.setHours(0, 0, 0, 0);
														this.today.setHours(0, 0, 0, 0);

														if (live_session.is_followed) { // Tambahkan properti is_followed di data Anda
															return 'followed'; // Status baru: sudah mengikuti
														} else if (this.sessionDate.getTime() > this.today.getTime()) {
															return 'upcoming'; // Akan Datang
														} else if (this.sessionDate.getTime() === this.today.getTime()) {
															return 'on-going'; // Sedang Berlangsung
														} else {
															return 'finished'; // Selesai
														}
													}
												}">
												<div x-show="getSessionStatus() === 'followed'">
													<button type="button" class="btn btn-sm btn-secondary rounded-pill">
														<i class="bi bi-check-circle"></i> Sudah mengikuti
													</button>
												</div>
												<div x-show="getSessionStatus() === 'on-going'">
													<a :href="live_session.zoom_link" target="_blank" class="btn btn-sm btn-primary rounded-pill">
														<i class="bi bi-camera-video"></i> Gabung Sekarang
													</a>
												</div>
												<div x-show="getSessionStatus() === 'finished'">
													<button type="button" class="btn btn-sm btn-secondary rounded-pill" disabled>
														<i class="bi bi-camera-video"></i>
														<span x-text="getSessionStatus() === 'upcoming' ? 'Akan Datang' : 'Selesai'"></span>
													</button>
												</div>
												<div x-show="getSessionStatus() === 'upcoming'">
													<button type="button" class="btn btn-sm rounded-pill" style="background-color: #D9D9D9;border-color: #D9D9D9;" disabled>
														<i class="bi bi-camera-video"></i>
														<span>Akan Datang</span>
													</button>
												</div>

												<div class="text-secondary"><i class="bi bi-clock"></i> <span x-text="live_session.date"></span></div>
											</div>
										</div>
									</div>
								</div>
								<div :id="'panelsStayOpen-collapse-' + index" class="accordion-collapse collapse" :aria-labelledby="'panelsStayOpen-heading-' + index">
									<div 
										class="accordion-body" 
										x-data="{
											sessionDate: new Date(live_session.date),
											today: new Date(),
											isOnGoing: function() {
												this.sessionDate.setHours(0, 0, 0, 0);
												this.today.setHours(0, 0, 0, 0);
												return this.sessionDate.getTime() === this.today.getTime();
											}
										}">
										<div class="mb-3">
											<div class="fw-bold">Deskripsi:</div>
											<div x-text="live_session.description"></div>
										</div>

										<div class="mb-3">
											<div class="fw-bold">Status:</div>
											<span 
												class="badge" 
												x-data="{
												sessionDate: new Date(live_session.date),
												today: new Date(),
												getStatusBadge: function() {
													this.sessionDate.setHours(0, 0, 0, 0);
													this.today.setHours(0, 0, 0, 0);

													if (this.sessionDate.getTime() > this.today.getTime()) {
														return { text: 'Akan Datang', class: 'bg-warning text-dark' };
													} else if (this.sessionDate.getTime() === this.today.getTime()) {
														return { text: 'Sedang Berlangsung', class: 'bg-primary' };
													} else {
														return { text: 'Selesai', class: 'bg-success' };
													}
												}
											}" :class="getStatusBadge().class" x-text="getStatusBadge().text"></span>
										</div>

										<div class="mb-3" x-show="isOnGoing()">
											<div class="fw-bold">Link Zoom:</div>
											<a :href="live_session.zoom_link" target="_blank" class="btn btn-sm btn-outline-primary">
												<i class="bi bi-camera-video"></i> Gabung Zoom
											</a>
										</div>

										<div class="mb-3" x-show="isOnGoing()">
											<div class="fw-bold">Passcode:</div>
											<span x-text="live_session.zoom_passcode"></span>
										</div>

										<div x-show="isOnGoing()">
											<button type="button" class="btn btn-primary">
												<i class="bi bi-person-check"></i> Ambil Presensi
											</button>
										</div>
									</div>
								</div>
							</div>
						</template>
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