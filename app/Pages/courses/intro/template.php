<div
	class="header-mobile-only"
	id="course_intro"
	x-data="$heroic({
		title: `<?= $page_title ?>`, 
		url: `/courses/intro/data/${$params.course_id}`,
		meta: {
			graduate: false
		}
	})"
	x-effect="loadPage(`/courses/intro/data/${$params.course_id}`)">

	<?= $this->include('_appHeader'); ?>

	<style>
		.cover {
			object-fit: cover;
			width: 100%;
			height: 100%;
		}

		.progress,
		.progress-bar {
			height: 22px;
		}

		.card-hover:hover {
			transform: translateY(-2px);
			transition: all 0.3s ease;
		}

		.bg-light-secondary {
			background-color: rgba(108, 117, 125, 0.1);
		}

		.rounded-20 {
			border-radius: 20px;
		}
	</style>

	<div id="appCapsule">
		<div class="appContent py-4" style="min-height:90vh">
			<!-- Header -->
			<div class="section p-4 px-3 bg-white rounded-4 mb-3 position-relative overflow-hidden">
				<div class="d-flex align-items-center gap-3 position-relative" style="z-index: 99;">
					<div class="avatar">
						<img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" alt="avatar" class="imaged w64 rounded-circle">
					</div>
					<div>
						<h5 class="mb-0 fw-normal">Selamat Belajar,</h5>
						<h4 class="mb-0">Badar Abdi Mulya</h4>
					</div>
				</div>
				<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206633.png" class="position-absolute bottom-0 end-0 w-25" alt="">
			</div>

			<!-- Card Kelas -->
			<div class="section p-3 bg-white rounded-4 mb-3">
				<div class="card border-0 shadow-none overflow-hidden">
					<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206751%20(2).png" class="card-img-top cover rounded-4" style="height: 200px;" alt="AI Course">
					<div class="card-body p-2">
						<h2 class=" mt-2">Kelas - Belajar Fundamental AI</h2>
						<p class="card-text p-0">
							Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta perannya dalam kehidupan sehari-hari.
							<a href="#" class="text-primary text-decoration-none p-0">Lihat Selengkapnya</a>
						</p>
					</div>
				</div>
			</div>

			<!-- Progress Stats -->
			<div class="p-3 pb-4 bg-white rounded-4 mb-3">
				<h4 class="mb-4">Progres Belajar</h4>

				<!-- Modul Selesai -->
				<a href="/course/intro/1/belajar-fundamental-ai/lessons">
					<div class="card border-0 rounded-4 mb-4" style="background: #79b2cd;">
						<div class="card-body d-flex align-items-center gap-3 p-4">

							<div class="rounded-3 d-flex align-items-center justify-content-center bg-white"
								style="width: 64px; height: 64px;">
								<i class="bi bi-journal-bookmark-fill display-5" style="color: #79b2cd;"></i>
							</div>
							<div class="flex-grow-1">
								<div class="d-flex align-items-end gap-2">
									<h2 class="mb-0 fw-bold text-white">12</h2>
									<span class="mb-1 text-white">materi selesai</span>
								</div>
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<div class="progress" style="height: 7px; background: #5b9ab8;">
											<div class="progress-bar" role="progressbar" style="width: 55%; background: #ffffff;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<span class="ms-3 fw-bold text-white" style="font-size: 1rem;">55%</span>
								</div>
								<div class="text-white text-end small">30 total materi dan kuis</div>
							</div>
						</div>
					</div>
				</a>

				<!-- Live Session Wajib -->
				<a href="/course/intro/1/belajar-fundamental-ai/live_session">
					<div class="card border-0 rounded-4" style="background: #fe9500;">
						<div class="card-body d-flex align-items-center gap-3 p-4">

							<div class="rounded-3 d-flex align-items-center justify-content-center bg-white"
								style="width: 64px; height: 64px;">
								<i class="bi bi-camera-video text-warning display-5"></i>
							</div>
							<div class="flex-grow-1">
								<div class="d-flex align-items-end gap-2">
									<h2 class="mb-0 fw-bold text-white">1</h2>
									<span class="mb-1 text-white">sessi live diikuti</span>
								</div>
								<div class="d-flex align-items-center gap-2 mt-2 mb-1">
									<div class="flex-fill rounded-pill" style="height:7px; background:#ffffff;">&nbsp;</div>
									<div class="flex-fill rounded-pill" style="height:7px; background:#cb7e10;">&nbsp;</div>
									<div class="flex-fill rounded-pill" style="height:7px; background:#cb7e10;">&nbsp;</div>
								</div>
								<div class="text-white text-end small">Minimal 3 dari 10 sessi</div>
							</div>
						</div>
					</div>
				</a>

			</div>


			<!-- Final Task -->
			<!-- <div class="section p-3 mb-3 bg-white rounded-4">
				<h4 class="fw-bold mb-3" style="color: #222;">Tugas Akhir</h4>
				<div class="card border-0 rounded-4" style="background: #7db9d2;">
					<div class="card-body d-flex align-items-center gap-3 p-4">
						<div class="rounded-3 d-flex align-items-center justify-content-center" style="width:64px;height:64px;background:#fff;">
							<i class="bi bi-clipboard" style="font-size:2.5rem; color:#7db9d2;"></i>
						</div>
						<div class="flex-grow-1">
							<div class="fw-bold mb-1" style="font-size:1.2rem; color:#fff;">Tugas Akhir - Berkenalan Dengan AI</div>
							<div style="font-size:1rem; color:#eaf6fa;">30 Soal pilihan ganda</div>
						</div>
					</div>
				</div>
			</div> -->

			<!-- Certificate -->
			<div class="section p-3 pb-4 bg-white rounded-4">
				<h4 class="fw-bold mb-3" style="color: #222;">Klaim Sertifikat</h4>

				<div
					class="card border-0 rounded-4 bg-dark bg-opacity-10"
					:class="meta.graduate ? 'bg-secondary' : 'bg-dark bg-opacity-10'">
					<div class="card-body d-flex align-items-center gap-3 p-4">
						<div class="rounded-3 d-flex align-items-center justify-content-center bg-white"
							style="min-width: 64px; height: 64px;">
							<i class="bi bi-award text-dark opacity-50 display-5"></i>
						</div>
						<div class="flex-grow-1">
							<h5 class="h6 opacity-50 mb-0">Selesaikan materi dan sessi live wajib untuk mendapatkan sertifikat.</h5>
							<!-- <div class="fw-bold" style="font-size:1.2rem; color:#fff;">Klaim Sertifikat Sekarang!</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>