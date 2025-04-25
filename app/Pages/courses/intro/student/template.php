<div
	id="student"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
		url: `courses/intro/student/data/${$params.course_id}`
    })" 
	x-debug>
	<div id="app-header" class="appHeader main border-0">
		<div class="left"><a class="headerButton" href="/courses"><i class="bi bi-chevron-left"></i></a></div>
		<div class="pageTitle"><span><?= $page_title ?></span></div>
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
					/* object-position: top; */
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
						<h4 class="text-white" x-text="data.course?.course_title || 'Belajar AI'"></h4>
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
							<a :href="`/courses/intro/${$params.course_id}/${$params.slug}`" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Materi Belajar</a>
							<a :href="`/courses/intro/${$params.course_id}/${$params.slug}/live_session`"class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill position-relative">
								Live Session
								<span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle">
									<span class="visually-hidden">New alerts</span>
								</span>
							</a>
							<a :href="`/courses/intro/${$params.course_id}/${$params.slug}/student`" class="btn btn-lg btn-primary text-nowrap rounded-pill">Student</a>
							<!-- <a :href="`/courses/intro/${$params.course_id}/${$params.slug}/tanya_jawab`" class="btn btn-lg btn-ultra-light-primary text-nowrap rounded-pill">Tanya Jawab</a> -->
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="container px-4">
					<div class="d-flex justify-content-between align-items-center">
						<div class="d-flex align-items-center h6">
							<span>Filter</span>
							<button class="btn btn-sm" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas" aria-controls="offcanvasExample">
								<i class="bi bi-sort-alpha-down text-primary"></i>
							</button>
						</div>
						<div class="d-flex align-items-center h6">
							<span>Sort</span>
							<button class="btn btn-sm" data-bs-toggle="offcanvas" data-bs-target="#sortCanvas" aria-controls="offcanvasExample">
								<i class="bi bi-filter text-primary"></i>
							</button>
						</div>
					</div>

					<!-- Student Cards -->
					<template x-for="student in data.students">
						<div class="card shadow-none border rounded-20 p-2 mb-2">
							<div class="d-flex gap-3 align-items-center">
								<div style="width: 100px; height: 100px">
									<img :src="student.avatar" class="cover rounded" alt="Student">
								</div>
								<div class="flex-grow-1">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<div class="">Enroll : <span x-text="student.joined_at.slice(0, 10)"></span></div>
									</div>
									<h5 class="mb-2">
										<a :href="`/courses/intro/${$params.course_id}/${$params.slug}/student/${student.user_id}`" x-text="student.name"></a>
									</h5>
									<div class="d-flex align-items-center gap-3">
										<div class="progress flex-grow-1" style="height: 8px">
											<div class="progress-bar bg-primary" role="progressbar" style="width: 80%"></div>
										</div>
										<div class="text-primary" style="min-width: 45px">80%</div>
									</div>
								</div>
							</div>
						</div>
					</template>

				</div>
			</section>
		</div>
	</div>

	<!-- Offcanvas share -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body small"></div>
	</div>

	<!-- Offcanvas Filter -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="filterCanvas" aria-labelledby="filterCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h4 class="m-0" id="filterCanvasLabel">Filter</h4>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body small">
			<h5>Nama</h5>
			<div class="d-flex gap-3">
				<button class="btn btn-primary rounded-20">Urutkan Nama A - Z</button>
				<button class="btn btn-primary rounded-20">Urutkan Nama Z - A</button>
			</div>
		</div>
	</div>

	<!-- Offcanvas Sort -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="sortCanvas" aria-labelledby="sortCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h4 class="m-0" id="sortCanvasLabel">Sort</h4>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body text-white">
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h4 class="m-0">Tanggal Bergabung</h4>
				<input type="radio" class="form-check-input h5" name="sort" id="sortJoin" checked>
			</div>
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h4 class="m-0">Terakhir Online</h4>
				<input type="radio" class="form-check-input h5" name="sort" id="sortOnline">
			</div>
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h4 class="m-0">Progress Belajar</h4>
				<input type="radio" class="form-check-input h5" name="sort" id="sortProgress">
			</div>
		</div>
	</div>
	<?= $this->include('_bottommenu') ?>
</div>