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

		.img-course {
			width: 100px;
			height: 110px;
			object-fit: cover;
		}

		@media (min-width: 768px) {
			.img-course {
				width: 150px;
				height: 110px;
				object-fit: cover;
			}
		}
	</style>

	<div id="appCapsule">

		<div class="appContent py-4" style="min-height:90vh">

			<div class="">

				<div class="bg-white p-4 rounded-4 mb-4">
					<h5 class="fw-bold mb-3">Progres Kelas</h5>
					<div class="card text-white bg-primary p-3">
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
					</div>
				</div>

				<div class="bg-white p-4 rounded-4 mb-4">
					<h5 class="fw-bold mb-3">Kelas yang kamu miliki</h5>
					<template x-for="course in data.courses">
						<div class="card shadow-none p-3" style="background: #F2F2F2;">
							<div class="d-flex align-items-center">
								<img src="https://ik.imagekit.io/56xwze9cy/ruangai/course.png" class="rounded-3 img-course" alt="thumbnail kelas">
								<div class="flex-grow-1 ms-3">
									<p class="fw-bold" x-text="course.course_title"></p>
									<div class="d-flex justify-content-between align-items-center">
										<p class="mb-1"><span class="text-primary fs-4" x-text="course.total_completed"></span> dari <span x-text="course.total_module"></span> lesson selesai</p>
										<p class="fw-bold mb-1" x-text="course.progress + '%'"></p>
									</div>
									<div class="progress" style="background: #BFD6E0">
										<div class="progress-bar bg-primary" role="progressbar" :style="{ width: course.progress + '%' }" aria-valuenow="course.progress" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
					</template>
				</div>

				<div class="bg-white p-4 rounded-4 mb-4">
					<h5 class="fw-bold mb-3">Kelas Premium</h5>
					<div class="list-group list-group-flush">

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/saas.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<p class="fw-bold mb-0">Kelas AI for SaaS Builder</p>
								<button class="btn btn-sm locked-btn" disabled>
									<i class="bi bi-lock-fill me-1"></i> Locked
								</button>
							</div>
						</div>

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/smart-creator.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<p class="fw-bold mb-0">Kelas AI for Smart Creators</p>
								<button class="btn btn-sm locked-btn" disabled>
									<i class="bi bi-lock-fill me-1"></i> Locked
								</button>
							</div>
						</div>

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/academic.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<p class="fw-bold mb-0">Kelas AI for Academics</p>
								<button class="btn btn-sm locked-btn" disabled>
									<i class="bi bi-lock-fill me-1"></i> Locked
								</button>
							</div>
						</div>

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/storyteller.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<p class="fw-bold mb-0">Kelas AI for Digital Storyteller</p>
								<button class="btn btn-sm locked-btn" disabled>
									<i class="bi bi-lock-fill me-1"></i> Locked
								</button>
							</div>
						</div>

					</div>
				</div>

			</div>

		</div>
	</div>
	<?= $this->include('_bottommenu') ?>
	<?= $this->include('courses/script') ?>
</div>