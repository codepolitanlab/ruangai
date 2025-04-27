<div id="pengumuman"
	class="header-mobile-only"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/pengumuman/data`
    })">

	<?= $this->include('_appHeader'); ?>

	<!-- App Capsule -->
	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh">
			<section class="p-3 p-lg-4">
				<!-- Generate here -->
				<div class="rounded-4">
					<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
						<li class="nav-item me-1" role="presentation">
							<button class="nav-link active w-100 rounded-pill" id="pills-pengumuman-tab" data-bs-toggle="pill" data-bs-target="#pills-pengumuman" type="button" role="tab" aria-controls="pills-pengumuman" aria-selected="true">Pengumuman</button>
						</li>
						<li class="nav-item position-relative" role="presentation">
							<button class="nav-link w-100 rounded-pill" id="pills-pemberitahuan-tab" data-bs-toggle="pill" data-bs-target="#pills-pemberitahuan" type="button" role="tab" aria-controls="pills-pemberitahuan" aria-selected="false">Pemberitahuan</button>
							<span class="position-absolute top-0 end-0 translate-middle p-1 bg-danger rounded-circle">
								<span class="visually-hidden">New alerts</span>
							</span>
						</li>
					</ul>

					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-pengumuman" role="tabpanel" aria-labelledby="pills-pengumuman-tab" tabindex="0">
							<!-- Announcement Items -->
							<div class="announcement-list">
								<!-- Item 1 - Highlighted -->
								<div class="card border-0 rounded-4 mb-3" style="background-color: #FFF1EB;">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #FFD9C6;">
													<i class="bi bi-megaphone-fill fs-3 text-warning"></i>
												</div>
											</div>
											<div>
												<h5 class="text-warning mb-1">Pengumuman!</h5>
												<p class="mb-0">Selesaikan kelas pertama sebelum tanggal 31 july 2025, supaya kamu lulus pada tahap pertama!</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Item 2 -->
								<div class="card border-0 rounded-4 mb-3">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
													<i class="bi bi-megaphone fs-3 text-dark"></i>
												</div>
											</div>
											<div>
												<h5 class="mb-1">Pengumuman!</h5>
												<p class="mb-0">Maintenance aplikasi akan diadakan hari ini pukul 21.00! Selesaikan Progress belajar kamu secepatnya!</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Item 3 -->
								<div class="card border-0 rounded-4 mb-3">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
													<i class="bi bi-megaphone fs-3 text-dark"></i>
												</div>
											</div>
											<div>
												<h5 class="mb-1">Pengumuman!</h5>
												<p class="mb-0">Maintenance aplikasi akan diadakan hari ini pukul 21.00! Selesaikan Progress belajar kamu secepatnya!</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Item 4 -->
								<div class="card border-0 rounded-4 mb-3">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
													<i class="bi bi-megaphone fs-3 text-dark"></i>
												</div>
											</div>
											<div>
												<h5 class="mb-1">Pengumuman!</h5>
												<p class="mb-0">Maintenance aplikasi akan diadakan hari ini pukul 21.00! Selesaikan Progress belajar kamu secepatnya!</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-pemberitahuan" role="tabpanel" aria-labelledby="pills-pemberitahuan-tab" tabindex="0">
							<div class="announcement-list">
								<!-- Item 1 - Highlighted -->
								<div class="card border-0 rounded-4 mb-3" style="background-color: #EBF6FF;">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #D6EEFF;">
													<i class="bi bi-bell-fill fs-3 text-primary"></i>
												</div>
											</div>
											<div>
												<h5 class="text-primary mb-1">Pemberitahuan!</h5>
												<p class="mb-0">Yeay! kamu telah menyelesaikan batch 1 hari ini! Yuk lanjutkan progress belajar kamu ke bacth selanjutnya!</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Item 2 -->
								<div class="card border-0 rounded-4 mb-3">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
													<i class="bi bi-bell fs-3 text-dark"></i>
												</div>
											</div>
											<div>
												<h5 class="mb-1">Pemberitahuan!</h5>
												<p class="mb-0">Ada yang baru nih! course baru telah ditambahkan ke kelas batch 1, Cek sekarang juga!</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Item 3 -->
								<div class="card border-0 rounded-4 mb-3">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
													<i class="bi bi-bell fs-3 text-dark"></i>
												</div>
											</div>
											<div>
												<h5 class="mb-1">Pemberitahuan!</h5>
												<p class="mb-0">Ada yang baru nih! course baru telah ditambahkan ke kelas batch 1, Cek sekarang juga!</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Item 4 -->
								<div class="card border-0 rounded-4 mb-3">
									<div class="card-body p-3">
										<div class="d-flex">
											<div class="me-3">
												<div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
													<i class="bi bi-bell fs-3 text-dark"></i>
												</div>
											</div>
											<div>
												<h5 class="mb-1">Pemberitahuan!</h5>
												<p class="mb-0">Ada yang baru nih! course baru telah ditambahkan ke kelas batch 1, Cek sekarang juga!</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<!-- * App Capsule -->
	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('pengumuman/script') ?>