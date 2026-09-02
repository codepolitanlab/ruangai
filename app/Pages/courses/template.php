<div id="courses" class="header-mobile-only rd-page" x-data="courses()">
	<?= $this->include('_bottommenu') ?>

	<style>
		/* ==============================================================
		   TEMA GELAP — disamakan dengan dashboard home/user (tanpa ubah logic)
		   ============================================================== */
		#courses {
			background-color: var(--rd-bg);
			color: var(--rd-text);
			min-height: 100vh;
		}
		#courses #appCapsule {
			background-color: var(--rd-bg) !important;
			color: var(--rd-text);
		}
		#courses .appContent { color: var(--rd-text); }

		/* Judul halaman */
		#courses .header-large-title h2 {
			color: var(--rd-text) !important;
		}

		/* Kontainer section terang -> permukaan gelap */
		#courses .bg-white {
			background-color: var(--rd-surface) !important;
			border-color: var(--rd-border) !important;
			color: var(--rd-text) !important;
		}
		#courses h5 { color: var(--rd-text) !important; }
		#courses .text-muted { color: var(--rd-text-muted) !important; }

		/* Kartu kelas */
		#courses .card {
			background-color: var(--rd-surface-2) !important;
			border: none;
			border-radius: 1rem;
			box-shadow: none !important;
		}
		#courses .card .text-white { color: var(--rd-text) !important; }

		/* Angka materi selesai (accent) */
		#courses .card .fs-4 { color: var(--rd-primary) !important; }

		/* Progress bar */
		#courses .progress {
			background-color: var(--rd-border) !important;
			height: 8px;
			border-radius: 999px;
			overflow: hidden;
		}
		#courses .progress-bar {
			background-color: var(--rd-primary) !important;
			border-radius: 999px;
		}

		/* Overlay & tombol kelas terkunci */
		#courses .bg-dark.bg-opacity-75 { background-color: rgba(2, 13, 28, 0.88) !important; }
		#courses .bg-dark .bi-lock-fill { color: var(--rd-primary) !important; }
		#courses .btn-primary {
			background-color: var(--rd-primary) !important;
			border-color: var(--rd-primary) !important;
			color: var(--rd-primary-contrast) !important;
			border-radius: 999px;
		}
	</style>

	<div id="appCapsule">

		<div class="appContent py-4" style="min-height:90vh">

			<div class="header-large-title mb-4 ps-0">
				<h2 class="h3 fw-normal">Daftar Kelas</h2>
			</div>

			<div class="">

				<template x-if="data.courses.length > 0">
					<div class="bg-white px-3 py-4 rounded-4 mb-4">
						<h5 class="fw-bold mb-3">Kelas yang kamu miliki</h5>
						<template x-for="course in data.courses">
							<div class="position-relative">
								<template x-if="course.id == 1 && !data.has_attended_live_session && !data.has_valid_live_session">
									<div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center bg-dark bg-opacity-75 rounded-3" style="z-index: 10;">
										<div class="text-center text-white">
											<i class="bi bi-lock-fill display-4 mb-2"></i>
											<p class="mb-0 fw-bold">Belum bisa diakses</p>
											<small class="d-block mb-3">Selesaikan Modul PDF dan ikuti Webinar untuk membuka akses kelas</small>
											<a href="/beasiswa/intro" class="btn btn-primary btn-sm">Lihat Info Beasiswa</a>
										</div>
									</div>
								</template>
								<a href="#" @click.prevent="navigateToTargetLesson(course.id, course.slug)" class="link" :class="{'pointer-events-none': course.id == 1 && !data.has_attended_live_session && !data.has_valid_live_session}">
									<div class="card shadow-none overflow-hidden mb-3" style="background:#112f3d">
										<div class="d-flex align-items-center overflow-hidden">
											<img :src="course.thumbnail" class="rounded-3 img-course" alt="thumbnail kelas">
											<div class="flex-grow-1 ms-3 p-3">
												<p class="fw-bold h5 text-white" x-text="course.course_title"></p>
												<div class="d-flex justify-content-between align-items-center text-white">
													<p class="mb-1"><span class="fs-4" style="color: #7BD5FF" x-text="course.total_completed"></span> dari <span x-text="course.total_module"></span> materi selesai</p>
													<p class="fw-bold mb-1" x-text="Math.round(course?.total_completed/course?.total_module*100) + '%'"></p>
												</div>
												<div class="progress" style="background: #343434">
													<div class="progress-bar" role="progressbar" :style="`width: ${Math.round(course.total_completed/course.total_module*100)}%; background: #7BD5FF`" aria-valuenow="Math.round(course?.total_completed/course?.total_module*100)" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
						</template>
					</div>
				</template>
				
				<template x-if="data.courses.length === 0 && !data?.is_scholarship_participant">
					<div class="bg-white px-3 py-4 rounded-4 mb-4 text-center">
						<h5 class="fw-bold mb-2 mt-3">Belum Ada Kelas</h5>
						<p class="text-muted">Kamu belum memiliki kelas aktif. Daftar program beasiswa untuk mendapatkan akses kelas gratis!</p>
					</div>
				</template>

				<!-- <div class="bg-white px-3 py-4 rounded-4 mb-4">
					<h5 class="fw-bold mb-3">Kelas Khusus</h5>
					<template x-for="premium in data?.premium_courses">
						<?= $this->include('_components/card/CardPremiumCourse') ?>
					</template>
				</div> -->

			</div>

		</div>

	</div>

	<?= $this->include('courses/script') ?>
</div>