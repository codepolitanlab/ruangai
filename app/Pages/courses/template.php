<div id="courses" x-data="courses()">
	<?= $this->include('_bottommenu') ?>

	<style>
		.card {
			border: none;
			border-radius: 1rem;
			/* rounded-4 */
		}

		.progress {
			height: 8px;
			border-radius: 1rem;
		}

		.locked-btn {
			background-color: #e9ecef;
			/* Warna tombol locked */
			color: #6c757d;
			border: 1px solid #dee2e6;
			font-size: 0.8rem;
			padding: 0.25rem 0.75rem;
		}
	</style>

	<div id="appCapsule">

		<div class="appContent py-4" style="min-height:90vh">

			<div class="header-large-title mb-4 ps-0">
				<h2 class="h3 fw-normal">Daftar Kelas</h2>
			</div>

			<div class="">
				<!-- Show Scholarship CTA for Competition Users -->
				<?= $this->include('_components/scholarship_cta') ?>

				<template x-if="data.courses.length > 0">
					<div class="bg-white px-3 py-4 rounded-4 mb-4">
						<h5 class="fw-bold mb-3">Kelas yang kamu miliki</h5>
						<template x-for="course in data.courses">
							<a :href="`/courses/intro/${course.id}/${course.slug}`" class="link">
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
						</template>
					</div>
				</template>
				
				<template x-if="data.courses.length === 0 && !data?.is_scholarship_participant">
					<div class="bg-white px-3 py-4 rounded-4 mb-4 text-center">
						<i class="bi bi-inbox display-1 text-muted"></i>
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