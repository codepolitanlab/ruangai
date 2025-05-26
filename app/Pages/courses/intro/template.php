<div
	class="header-mobile-only"
	id="course_intro"
	x-data="$heroic({
		title: `<?= $page_title ?>`, 
		url: `/courses/intro/data/${$params.course_id}`
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
				<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206633.png" class="position-absolute bottom-0 end-0 w-25"  alt="">
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
			<div class="p-4 bg-white rounded-4 mb-3">
				<h3 class="mb-4">Progres Belajar</h3>
				<div class="row g-3 mb-4">

					<!-- Modul Selesai -->
					<div class="col-6">
						<div class="card border-0 shadow-sm h-100" style="background-color: #F3FBFF;">
							<div class="card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
										<i class="bi bi-journal-check text-primary fs-3"></i>
									</div>
								</div>
								<div class="d-flex align-items-end gap-2 mb-2">
									<h2 class="mb-0 fw-bold">12</h2>
									<span class="mb-1">Modul terselesaikan</span>
								</div>
								<div class="progress mb-2" style="height: 4px; background: #DBE6EC;">
									<div class="progress-bar bg-primary" style="width: 33%;"></div>
								</div>
								<div class="text-muted text-end text-primary small">30 Total Modul</div>
							</div>
						</div>
					</div>

					<!-- Live Session Wajib -->
					<div class="col-6">
						<div class="card border-0 shadow-sm h-100" style="background-color: #FFF6F2;">
							<div class="card-body">
								<div class="bg-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:44px;height:44px;">
									<i class="bi bi-tv text-warning fs-3"></i>
								</div>
								<div class="d-flex align-items-end gap-2 mb-1">
									<h2 class="mb-0 fw-bold">1</h2>
									<span class="mb-1">Live Session Wajib</span>
								</div>
								<!-- Segmented Progress Bar -->
								<div class="d-flex align-items-center gap-1 mt-2 mb-1">
									<div class="flex-fill rounded-pill" style="height:6px; background:#FF7A1A; opacity:1;"></div>
									<div class="flex-fill rounded-pill" style="height:6px; background:#FF7A1A; opacity:0.3;"></div>
									<div class="flex-fill rounded-pill" style="height:6px; background:#FF7A1A; opacity:0.3;"></div>
								</div>
								<div class="text-warning text-end small">3x Wajib Live Session</div>
							</div>
						</div>

					</div>
				</div>

				<!-- Lanjutkan Belajar -->
				<a href="#" class="text-decoration-none">
					<div class="card border-0 rounded-4 mb-3" style="background: #FF6C1A; color: #fff;">
						<div class="card-body d-flex align-items-center gap-3 p-4">
							<div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: #fff2e6;">
								<i class="bi bi-journal-bookmark-fill" style="font-size: 2.5rem; color: #FF6C1A;"></i>
							</div>
							<div class="flex-grow-1">
								<div class="fw-bold" style="font-size: 1.3rem; line-height:1.2;">Lanjutkan Belajar</div>
								<div style="font-size: 1rem; color: #ffe0c2;">Belajar Fundamental AI</div>
								<div class="d-flex align-items-center mt-2">
									<span class="me-2" style="font-size: 1.2rem;">&#9654;</span>
									<div class="flex-grow-1">
										<div class="progress" style="height: 6px; background: #fff2e6;">
											<div class="progress-bar" role="progressbar" style="width: 55%; background: #fff;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<span class="ms-3 fw-bold" style="font-size: 1rem; color: #fff;">55%</span>
								</div>
							</div>
						</div>
					</div>

				</a>
			</div>


			<!-- Final Task -->
			<div class="section p-3 mb-3 bg-white rounded-4">
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
			</div>

			<!-- Certificate -->
			<div class="section p-3 px-3 bg-white rounded-4">
				<h4 class="fw-bold mb-3" style="color: #222;">Klaim Sertifikat</h4>
				<div>
					<div class="card border-0 rounded-4" style="background: linear-gradient(90deg, #ffcf5c 0%, #ffb133 100%);">
						<div class="card-body d-flex align-items-center gap-3 p-4">
							<div class="rounded-3 d-flex align-items-center justify-content-center" style="width:64px;height:64px;background:#fff2e6;">
								<i class="bi bi-award-fill" style="font-size:2.5rem; color:#ffb133;"></i>
							</div>
							<div class="flex-grow-1">
								<div style="font-size:1.1rem; color:#fff;">Selamat! kamu telah menyelesaikan kelas!</div>
								<div class="fw-bold" style="font-size:1.2rem; color:#fff;">Klaim Sertifikat Sekarang!</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>