<div
	id="live_session"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        getUrl: `/courses/intro/live_session/data`
    })">
	<div id="app-header" class="appHeader main border-0">
		<div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
		<div class="pageTitle"><span>Detail Kelas</span></div>
		<div class="right"><a class="headerButton" role="button" data-bs-toggle="offcanvas" data-bs-target="#shareCanvas"><i class="bi bi-share-fill me-1"></i></a></div>
	</div>

	<div id="appCapsule" class="shadow">
		<div class="appContent" style="min-height:90vh">
			<style>
				.accordion-body {
					padding: 0 .25rem;
				}

				.list-group-item {
					border: 0;
				}

				.accordion-body,
				.accordion-body .list-group-item {
					background: #fff !important;
				}

				.hovered:hover {
					background: #eee !important;
				}

				.cover {
					object-fit: cover;
					width: 100%;
					height: 100%;
				}

				.progress,
				.progress-bar {
					height: 22px;
				}

				.lessons a {
					color: #009688;
					font-weight: 400;
					font-size: 1rem;
				}

				.author img {
					width: 80px;
				}
			</style>
			<section class="p-3 p-lg-4">
				<div class="position-relative">
					<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%205231%20(1).png" class="w-100 position-relative" alt="">
					<div class="position-absolute ms-3 mt-2 top-0">
						<h3 class="text-white" x-text="data.course?.course_title || 'Belajar AI'"></h3>
						<div class="text-white d-flex gap-4 mb-2">
							<div><i class="bi bi-people"></i> <span x-text="data.course?.total_student"></span> Siswa</div>
							<div><i class="bi bi-book"></i> <span x-text="data.course?.total_module"></span> Modul Belajar</div>
						</div>
						<div class="progress mb-3 w-50" role="progressbar" style="height: 8px;">
							<div class="progress-bar bg-primary" style="width: 25%"></div>
						</div>
						<a href="" class="btn btn-sm btn-primary rounded-pill">Lanjutkan Belajar</a>
					</div>
				</div>
			</section>
			<section>
				<div class="container px-4">
					<div>
						<h2>Deskripsi Singkat</h2>
						<p x-text="data.course?.description"></p>
					</div>
					<div class="d-flex gap-3 mt-2 overflow-scroll py-3">
						<a href="/courses/intro/32/intro-to-programming" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Materi Belajar</a>
						<a href="/courses/intro/inggris-beginner-book-1/live_session" class="btn btn-lg btn-primary text-nowrap rounded-pill text-white position-relative">
							Live Session
							<span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle">
								<span class="visually-hidden">New alerts</span>
							</span>
						</a>
						<a href="/courses/intro/inggris-beginner-book-1/student" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Student</a>
						<a href="/courses/intro/inggris-beginner-book-1/tanya_jawab" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Tanya Jawab</a>
					</div>
				</div>
			</section>
			<section>
				<div class="container px-4">

					<!-- Check if no live session -->
					<template x-show="data.live_sessions.length == 0">
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
					<template x-show="data.live_sessions.length > 0" x-for="live_session in data.live_sessions">
						<a href="/courses/intro/inggris-beginner-book-1/live_session/1">
							<div class="card card-hover rounded-20 shadow-none border p-3 mb-2">
								<div class="row g-3">
									<div class="col">
										<div class="d-flex justify-content-between align-items-start">
											<div>
												<div class="d-flex gap-3 mb-1 align-items-center">
													<h5 class="text-pink m-0" x-text="live_session.title"></h5>
													<div class="badge btn-primary px-2">Rekaman</div>
												</div>
												<h4 class="mb-3" x-text="live_session.description"></h4>
											</div>
										</div>
										<div class="d-flex gap-3">
											<div><i class="bi bi-clock"></i> <span x-text="live_session.date"></span></div>
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