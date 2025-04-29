<div
	class="header-mobile-only"
	id="live_session"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/intro/live_session/data/${$params.course_id}`
    })">

	<div id="appCapsule" class="">
		<div class="appContent p-3" style="min-height:90vh">
			
			<?= $this->include('courses/intro/_header'); ?>

			<?= $this->include('courses/intro/_menu'); ?>

			<section>
				<div class="">

					<div class="card bg-light-secondary p-2 mb-4 rounded-4 border border-secondary">
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

					<!-- Completed Live Sessions -->
					<template x-show="data.live_sessions?.length > 0" x-for="live_session in data.live_sessions">
						<a :href="`/courses/intro/${data.course.id}/${data.course.slug}/live_session/${live_session.id}`">
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
						</a>
					</template>


					<!-- Coming Soon Sessions -->
					<!-- <div class="card rounded-20 p-3 mb-2 shadow-none border position-relative">
						<div class="d-flex gap-3 position-relative" style="filter: blur(5px);opacity: 0.5;">
							<div style="width: 200px; height: 130px">
								<img src="https://plus.unsplash.com/premium_photo-1661766386981-1140b7b37193?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cHJvZmVzaW9uYWx8ZW58MHx8MHx8fDA%3D" class="rounded-3 cover w-100 object-fit-cover" height="100" alt="Live Session 1">
							</div>
							<div class="flex-grow-1">
								<div class="d-flex justify-content-between align-items-start">
									<div>
										<div class="d-flex gap-3 mb-1 align-items-center">
											<h5 class="text-pink m-0">Live Session 1</h5>
											<div class="badge btn-primary px-2">Rekaman</div>
										</div>
										<h4 class="mb-3">Mengenal Lebih Dalam Peran AI di Kehidupan Sehari-hari</h4>
									</div>
								</div>
								<div class="d-flex gap-3">
									<div><i class="bi bi-clock"></i> 50:22</div>
									<div><i class="bi bi-people"></i> 120 Siswa</div>
								</div>
							</div>
						</div>
						<div class="position-absolute top-50 start-50 translate-middle rounded-3 p-2 w-100">
							<div class="d-flex flex-column justify-content-center">
								<h3 class="text-center mb-2">Akan dimulai pada</h3>
								<div class="d-flex gap-4 justify-content-center">
									<div class="d-flex align-items-center gap-2">
										<i class="bi bi-calendar"></i>
										<div>12 April 2025</div>
									</div>
									<div class="d-flex align-items-center gap-2">
										<i class="bi bi-clock"></i>
										<div>14:00</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
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