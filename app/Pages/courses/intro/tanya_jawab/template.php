<div id="tanya_jawab">
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
						<p>Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>
					</div>
					<div class="d-flex gap-3 overflow-scroll py-2">
						<div class="d-flex gap-3 overflow-scroll py-2">
							<a href="/courses/intro/32/intro-to-programming" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Materi Belajar</a>
							<a href="/courses/intro/inggris-beginner-book-1/live_session" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill position-relative">
								Live Session
								<span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle">
									<span class="visually-hidden">New alerts</span>
								</span>
							</a>
							<a href="/courses/intro/inggris-beginner-book-1/student" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Student</a>
							<a href="/courses/intro/inggris-beginner-book-1/tanya_jawab" class="btn btn-lg btn-primary text-nowrap rounded-pill">Tanya Jawab</a>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="container px-4">
					<template x-for="article in Array(3)">
						<div class="card shadow-none border rounded-20 p-3 mb-2" style="border: 4px solid rgba(0, 0, 0, 0.9);">
							<div class="d-flex flex-column flex-lg-row justify-content-between">
								<div class="d-flex gap-3 align-items-center">
									<img src="https://cdn-icons-png.flaticon.com/512/8792/8792047.png" class="rounded-circle" style="width: 50px;height: 50px" alt="">
									<div>
										<h5 class="m-0 mb-1">Badar Abdi Mulya</h5>
										<h6 class="m-0">UI & UX Designer - 04 Maret</h6>
									</div>
								</div>
								<div class="d-flex align-items-center gap-2 d-none d-lg-flex">
									<div class="d-flex btn-primary align-items-center justify-content-center h5 m-0 rounded" style="width: 50px;height: 40px">1</div>
									<div class="h6 m-0">Jawaban</div>
								</div>
							</div>
							<div class="card-body d-flex align-items-center gap-3 px-1">
								<a href="/courses/tanya_jawab/1">
									<div class="bg-light rounded-20 p-3 w-100">
										<h5>Tidak dapat menemukan URL Laravel</h5>
										<div class="bg-white p-2 rounded-20 text-muted">
											Ditanyakan di kelas <a href="" class="text-pink">Pengembangan Web Fullstack dengan Laravel 11</a>, Topik <a class="text-pink" href="">Setup kebutuhan untuk install project Laravel</a>
										</div>
									</div>
								</a>
							</div>
						</div>
					</template>
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