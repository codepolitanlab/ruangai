<div
	class="header-mobile-only"
	id="live_session"
	x-data="sesiLive(`${$params.course_id}`)"
	x-effect="loadPage(`beasiswa/intro/live_session/data/${$params.course_id}`)">

	<style>.date-box{line-height: 13px;max-width: 70px;width: 70px;}.date-box.attended,.date-box.attended h4{background-color: #77CD94;color: white;}.date-box.not-attended,.date-box.not-attended h4{background-color: #ef7071;color: white;}.date-box.currently{border: 1px solid #00BCD4 !important;background-color: #F3FBFE;}.date-box p{font-size: 13px;}.date-box small{font-size: 11px;}.accordion-item .accordion-header{background-color: white;}.accordion-item.completed .accordion-header{background-color: #ccc;}.accordion-item.attended{background-color: #E5FDEC;}.accordion-item.attended .accordion-header{background-color: #77CD94;}.accordion-item.ongoing{background-color: #fff3cf;}.accordion-item.ongoing .accordion-header{background-color: #FFC107;}.accordion-item.attended .accordion-button h4,.accordion-item.attended .accordion-button h5,.accordion-item.attended .accordion-button p,.accordion-item.attended .accordion-button .text-muted,.accordion-item.ongoing .accordion-button h4,.accordion-item.ongoing .accordion-button h5,.accordion-item.ongoing .accordion-button p,.accordion-item.ongoing .accordion-button .text-muted{color: white !important;}.bg-warning-2{background-color: #fe9500;}</style>

	<div id="appCapsule" class="">
		<?= $this->include('beasiswa/intro/_menu'); ?>

		<div class="appContent" style="min-height:90vh">

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
									<?= $this->include('beasiswa/intro/live_session/meeting_ongoing') ?>
								</div>
	
								<div class="mb-5" x-show="data?.live_sessions?.scheduled.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Event Mendatang</h4>
									<?= $this->include('beasiswa/intro/live_session/meeting_scheduled') ?>
								</div>
	
								<div x-show="data?.live_sessions?.completed.length > 0" x-transition>
									<h4 class="border-bottom pb-2 opacity-75">Event yang Pernah Diikuti</h4>
									<?= $this->include('beasiswa/intro/live_session/meeting_attended') ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- List Attended -->
			<div class="tab-pane fade" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab" tabindex="0">
				<div class="my-4 rounded-4 shadow-none">

					<?= $this->include('beasiswa/intro/live_session/meeting_attended') ?>

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

<?= $this->include('beasiswa/intro/live_session/script') ?>