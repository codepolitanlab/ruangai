<div id="courses" x-data="courses()">

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
				<!-- <div class="card text-white bg-primary p-3 mb-4 shadow-sm">
					<div class="d-flex align-items-center">
						<div class="bg-white p-4 rounded-3 d-flex align-items-center justify-content-center me-3">
							<img src="<?= base_url('mobilekit/assets/img/ruangai/book-play.svg') ?>" alt="">
						</div>
						<div class="flex-grow-1">
							<div class="d-flex align-items-center">
								<span class="fw-bold">Lanjutkan Belajar</span>
							</div>
							<p class="fw-bold mb-2" x-text="data.last_lesson?.title"></p>
							<div class="d-flex align-items-center">
								<i class="bi bi-play-fill fs-3 me-2"></i>
								<div class="progress flex-grow-1" style="background: #BFD6E0">
									<div class="progress-bar bg-white" role="progressbar" :style="{ width: data.last_lesson?.progress + '%' }" aria-valuenow="data.last_lesson?.progress" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<span class="ms-3 fw-bold small" x-text="data.last_lesson?.progress + '%'">0%</span></span>
							</div>
						</div>
					</div>
				</div> -->

				<template x-if="data.courses.length > 0">
					<div class="bg-white p-4 rounded-4 mb-4">
						<h5 class="fw-bold mb-3">Kelas yang kamu miliki</h5>
						<template x-for="course in data.courses">
							<a :href="`/courses/intro/${course.id}/${course.slug}/lessons`" class="link">
								<div class="card shadow-none bg-black overflow-hidden">
									<div class="d-flex align-items-center overflow-hidden">
										<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Mask%20group%20(6).png?updatedAt=1754293150119" class="rounded-3 img-course" alt="thumbnail kelas">
										<div class="flex-grow-1 ms-3 p-3">
											<p class="fw-bold h5 text-white" x-text="course.course_title"></p>
											<div class="d-flex justify-content-between align-items-center text-white">
												<p class="mb-1"><span class="fs-4" style="color: #7BD5FF" x-text="course.total_completed"></span> dari <span x-text="course.total_module"></span> materi selesai</p>
												<p class="fw-bold mb-1" x-text="course.progress + '%'"></p>
											</div>
											<div class="progress" style="background: #343434">
												<div class="progress-bar" role="progressbar" :style="{ width: course.progress + '%', background: '#7BD5FF' }" aria-valuenow="course.progress" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</template>
					</div>
				</template>

				<div class="bg-white p-4 rounded-4 mb-4">
					<h5 class="fw-bold mb-3">Kelas Premium</h5>
					<template x-for="course in data.premium_courses">
						<?= $this->include('_components/card/CardPremiumCourse') ?>
					</template>
				</div>

			</div>

		</div>
	</div>
	<?= $this->include('_bottommenu') ?>
	<?= $this->include('courses/script') ?>
</div>