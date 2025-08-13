<div
	class="header-mobile-only"
	id="course_reward"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/courses/reward/data/${$params.course_id}`,
		meta: {
			videoTeaser: null,
		}
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

	</style>

	<div id="appCapsule" class="">
		<div id="course-features" class="d-flex gap-2 px-3 pt-4 pb-1">
			<a :href="`/courses/intro/${data.course.id}/${data.course.slug}`"
				class="btn rounded-4 px-2"
				:class="data.active_page == 'intro' ? `btn-primary` : `btn-white bg-white text-primary`">
				<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
			</a>
		</div>

		<div class="appContent" style="min-height:90vh" x-data="listLesson()">

			<div class="card mt-2 mb-4 rounded-4 shadow-none">
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
						<p class="m-0 opacity-75">Kelas Khusus ini dapat kamu klaim setelah lulus di Chapter 2, silahkan klik 'Lihat Teaser' untuk membantu kamu memilih kelas mana yang sesuai. Kamu hanya dapat klaim salah satu saja.</p>
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

			<div class="bg-white p-4 rounded-4 mb-4">
				<h5 class="fw-bold mb-3">Kelas Premium</h5>
				<template x-for="premium in data?.premium_courses">
					<?= $this->include('_components/card/CardPremiumCourse') ?>
				</template>
			</div>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('courses/reward/script') ?>