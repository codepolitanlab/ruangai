<div
	class="header-mobile-only"
	id="course_reward"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/courses/reward/data/${$params.course_id}`
    })">

	<style>
		.disabled {
			pointer-events: none;
			opacity: 0.6;
			cursor: not-allowed;
		}

		.lesson-item {
			background-color: #F6F6F6;
		}

		.lesson-item.completed {
			background-color: #7BCC94 !important;
			color: #eee;
		}

		.lesson-item.active.completed {
			border: 0 !important;
		}

		.lesson-item.active {
			border: 2px solid #79B2CD !important;
		}

		.lesson-item.completed h4,
		.lesson-item.completed h5,
		.lesson-item.completed .bi {
			color: #fff !important;
		}

		.bg-warning-2 {
			background-color: #fe9500;
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

	<div id="app-header" class="appHeader main border-0 bg-transparent">
		<div class="left">
			<a class="headerButton" :href="`/courses/intro/${data.lesson?.course_id}/${data.lesson?.course_slug}/lessons`"><i class="bi bi-chevron-left"></i></a>
		</div>
		<div class="">
			<!-- <span x-text="data.lesson?.course_title + ' - ' + data.lesson?.topic_title"></span> -->
		</div>
	</div>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh" x-data="listLesson()">

			<div class="card my-4 rounded-4 shadow-none">
				<div class="card-body d-flex justify-content-start align-items-center gap-2 p-3">
					<img src="https://image.web.id/images/icon-gift-min.png" alt="">
					<div>
						<h4 class="h4 fw-normal">Klaim Reward</h4>
						<p class="text-dark opacity-50 mb-0">Pilih reward kelas lanjutan yang cocok buatmu</p>
					</div>
				</div>
			</div>

			<!-- Show alert not yet complete course -->
			<div class="card bg-info bg-opacity-50 rounded-4 mb-3 shadow-none">
				<div class="card-body d-flex gap-3">
					<i class="bi bi-megaphone text-white display-3"></i>
					<div>
						<h4 class="opacity-75 mb-1">Info Klaim Reward</h4>
						<p class="m-0 opacity-75">Reward kelas lanjutan akan tersedia di akhir program Chapter 2. Pastikan kamu sudah menuntaskan belajar sebelum program berakhir.</p>
					</div>
				</div>
			</div>

			<!-- Show Expire Alert -->
			<template x-if="data.is_expire">
				<div class="card bg-warning-2 rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3">
						<i class="bi bi-stopwatch-fill text-white display-3 shaky-icon"></i>
						<div>
							<h4 class="text-white">Program Belajar Chapter 1 Telah Berakhir</h4>
							<p class="m-0 text-white">Tapi tenang saja! Kamu tetap dapat melanjutkan belajar saat Chapter 2 dibuka.</p>
						</div>
					</div>
				</div>
			</template>

			<div class="card rounded-4 shadow-none">
				<div class="card-body">
					<div class="list-group list-group-flush">

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/saas.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<h4 class="fw-bold mb-1 opacity-75">Kelas AI for SaaS Builder</h4>
								<p class="text-dark opacity-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil natus deserunt, vel illo animi totam enim temporibus inventore, eos dolor non modi commodi.</p>
								<button class="btn btn-sm btn-outline-primary">
									<i class="bi bi-play-btn me-1"></i> Lihat Teaser
								</button>
							</div>
						</div>

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/smart-creator.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<h4 class="fw-bold mb-1 opacity-75">Kelas AI for Smart Creators</h4>
								<p class="text-dark opacity-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil natus deserunt, vel illo animi totam enim temporibus inventore, eos dolor non modi commodi.</p>
								<button class="btn btn-sm btn-outline-primary">
									<i class="bi bi-play-btn me-1"></i> Lihat Teaser
								</button>
							</div>
						</div>

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/academic.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<h4 class="fw-bold mb-1 opacity-75">Kelas AI for Academics</h4>
								<p class="text-dark opacity-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil natus deserunt, vel illo animi totam enim temporibus inventore, eos dolor non modi commodi.</p>
								<button class="btn btn-sm btn-outline-primary">
									<i class="bi bi-play-btn me-1"></i> Lihat Teaser
								</button>
							</div>
						</div>

						<div class="list-group-item d-flex p-3 rounded-4 mb-3" style="background: #F2F2F2;">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/storyteller.png" class="rounded-3 img-course" alt="Kelas Premium">
							<div class="d-flex flex-column justify-content-between align-items-start flex-grow-1 ms-3">
								<h4 class="fw-bold mb-1 opacity-75">Kelas AI for Digital Storyteller</h4>
								<p class="text-dark opacity-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil natus deserunt, vel illo animi totam enim temporibus inventore, eos dolor non modi commodi.</p>
								<button class="btn btn-sm btn-outline-primary">
									<i class="bi bi-play-btn me-1"></i> Lihat Teaser
								</button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('courses/intro/lessons/script') ?>