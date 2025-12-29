<div id="courses" x-data="courses()">
	<?= $this->include('_bottommenu') ?>

	<style>
		.card {
			border: none;
			border-radius: 1rem;
		}

		.scholarship-badge {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			padding: 0.25rem 0.75rem;
			border-radius: 0.5rem;
			font-size: 0.875rem;
			font-weight: 600;
		}
	</style>

	<div id="appCapsule">

		<div class="appContent py-4" style="min-height:90vh">

			<div class="header-large-title mb-4 ps-0">
				<h2 class="h3 fw-normal">Beasiswa Saya</h2>
			</div>

			<div class="">

				<!-- Card jika tidak ada beasiswa -->
				<template x-if="!data.is_scholarship_participant">
					<a :href="data.scholarship_url || 'https://ruangai.id'" target="_blank" class="text-decoration-none">
						<div class="card shadow-sm overflow-hidden mb-3 bg-white">
							<div class="card-body p-4 text-center">
								<h5 class="fw-bold mb-2 text-dark">Belum Ada Beasiswa Aktif</h5>
								<p class="mb-3 text-muted">
									Kamu belum memiliki beasiswa yang aktif saat ini. Daftar sekarang dan dapatkan akses gratis ke kursus Generative AI!
								</p>
								<div class="btn btn-primary rounded-pill px-4">
									<i class="bi bi-rocket-takeoff-fill me-2"></i>Daftar Beasiswa Sekarang
								</div>
							</div>
						</div>
					</a>
				</template>

				<!-- Daftar Beasiswa -->
				<template x-if="data.is_scholarship_participant">
					<div class="bg-white px-3 py-4 rounded-4 mb-4 shadow-sm">
						<h5 class="fw-bold mb-3">Beasiswa yang Kamu Miliki</h5>
						
						<!-- Render only the first course (index 0) -->
						<template x-if="data.courses && data.courses.length">
							<div x-data="{ course: data.courses[0] }">
								<div class="card shadow-sm overflow-hidden mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
									<div class="card-body p-4">
										<div class="d-flex justify-content-between align-items-start mb-3">
											<div>
												<h5 class="text-white fw-bold mb-1" x-text="course.course_title"></h5>
												<span class="scholarship-badge bg-white bg-opacity-25">
													<i class="bi bi-trophy-fill me-1"></i>
													<span x-text="course.program || 'Beasiswa Aktif'"></span>
												</span>
											</div>
											<i class="bi bi-mortarboard-fill text-white fs-1 opacity-25"></i>
										</div>
							
										<div class="row g-2 text-white mt-3">
											<div class="col-6">
												<small class="opacity-75">Progress</small>
												<p class="mb-0 fw-bold text-capitalize" x-text="(course.progress || '0') + '%' "></p>
											</div>
											<div class="col-6">
												<small class="opacity-75">Total Modul</small>
												<p class="mb-0 fw-bold" x-text="course.total_module || course.total_modules || '0'"></p>
											</div>
										</div>

										<div class="mt-3 pt-3 border-top border-white border-opacity-25">
											<a :href="`/courses/intro/${course.id}/${course.slug}`" class="btn btn-light w-100 rounded-pill">
												<i class="bi bi-book me-2"></i>Lihat Materi Kursus
											</a>
										</div>
									</div>
								</div>
							</div>
						</template>
					</div>
				</template>

			</div>

		</div>

	</div>

	<?= $this->include('courses/script') ?>
</div>