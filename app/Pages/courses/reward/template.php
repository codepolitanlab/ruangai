<div
	class="header-mobile-only"
	id="course_reward"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/courses/reward/data`,
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

		/* ==============================================================
		   TEMA GELAP — selaras dengan beranda/dashboard user (tanpa ubah logic)
		   ============================================================== */
		#course_reward {
			background-color: var(--rd-bg);
			color: var(--rd-text);
			min-height: 100vh;
		}
		#course_reward #appCapsule {
			background-color: var(--rd-bg) !important;
			color: var(--rd-text);
		}
		#course_reward .appContent { color: var(--rd-text); }

		/* Permukaan kartu -> gelap */
		#course_reward .card,
		#course_reward .card-body,
		#course_reward .bg-white,
		#course_reward .bg-info,
		#course_reward .bg-warning,
		#course_reward .alert {
			background-color: var(--rd-surface) !important;
			color: var(--rd-text) !important;
			border-color: var(--rd-border) !important;
		}
		#course_reward .card { box-shadow: none !important; }

		/* Judul */
		#course_reward h1, #course_reward h2, #course_reward h3,
		#course_reward h4, #course_reward h5, #course_reward h6,
		#course_reward .h1, #course_reward .h2, #course_reward .h3,
		#course_reward .h4, #course_reward .h5, #course_reward .h6 {
			color: var(--rd-text) !important;
		}

		/* Teks isi/muted & utilitas kegelapan */
		#course_reward p, #course_reward .text-muted, #course_reward .text-secondary,
		#course_reward .card-text, #course_reward .card-title, #course_reward .card-subtitle {
			color: var(--rd-text-muted) !important;
		}
		#course_reward .text-dark { color: var(--rd-text) !important; }
		#course_reward .opacity-50, #course_reward .opacity-75 { opacity: 1 !important; }

		/* Tombol & tombol kembali */
		#course_reward .btn-primary {
			background-color: var(--rd-primary) !important;
			border-color: var(--rd-primary) !important;
			color: var(--rd-primary-contrast) !important;
		}
		#course_reward .btn-white.bg-white {
			background-color: var(--rd-surface-2) !important;
			color: var(--rd-primary) !important;
			border-color: var(--rd-border) !important;
		}
		#course_reward .btn-white.bg-white .bi { color: var(--rd-primary) !important; }

		/* Badge jumlah token tetap aksen oranye */
		#course_reward .badge.bg-warning {
			background-color: var(--rd-primary) !important;
			color: #fff !important;
		}

		/* Kartu premium (CardPremiumCourse) */
		#course_reward .card.overflow-hidden {
			background-color: var(--rd-surface-2) !important;
		}
		#course_reward a:not(.btn) { color: var(--rd-primary); }

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

			<div class="card mt-2 mb-3 rounded-4 shadow-none">
				<div class="card-body d-flex justify-content-start align-items-center gap-2 p-3">
					<img src="https://image.web.id/images/icon-gift-min.png" width="100" height="100" alt="">
					<div>
						<h4 class="h4 fw-normal">Klaim Reward</h4>
						<p class="text-dark opacity-50 mb-0">Pilih reward kelas khusus yang cocok buatmu</p>
					</div>
				</div>
			</div>

			<template x-if="!data.user_token">
				<div class="card bg-info bg-opacity-50 rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3">
						<div class="text-center">
							<img src="<?= base_url('mobilekit/assets/img/ruangai/token-coin.png') ?>" width="100" height="100" alt="">
						</div>
						<div>
							<h4 class="opacity-75 mb-1">Token Reward</h4>
							<p class="mb-2 opacity-75">Kamu dapat mengklaim akses kelas khusus menggunakan <b class="text-nowrap fw-bold">token reward</b>.
							<br>Token yang kamu miliki saat ini: <span class="fw-bold">0</span></p>
							<a href="/courses/reward/howto">Cara Mendapatkan Token Reward <i class="bi bi-box-arrow-up-right ms-1"></i></a>
						</div>
					</div>
				</div>
			</template>

			<template x-if="data.user_token">
				<div class="card rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3 bg-warning bg-opacity-10 rounded-4">
						<img src="<?= base_url('mobilekit/assets/img/ruangai/token-coin.png') ?>" width="100" height="100" alt="">
						<div>
							<h4 class="opacity-75 mb-1">
								<span 
									class="badge bg-warning bg-opacity-50 text-dark rounded-3 p-2 fs-5 shadow-sm me-1" 
									x-text="data.user_token">
								</span> 
								Token Reward
							</h4>
							<p class="m-0 opacity-75">Kamu memiliki <span x-text="data.user_token"></span> token reward yang dapat digunakan untuk klaim kelas khusus.</p>
							<a href="/courses/reward/claim" class="btn btn btn-primary mt-3">KLAIM KELAS KHUSUS</a>
						</div>
					</div>
				</div>
			</template>

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

			<div class="bg-white p-4 rounded-4 my-4">
				<h5 class="fw-bold">Kelas Khusus</h5>
				<p class="mb-3 border-bottom pb-3">Lihat daftar materi dan teaser dari kelas khusus di bawah ini untuk mengetahui kelas mana yang paling cocok buatmu.</p>
				<template x-for="premium in data?.premium_courses">
					<?= $this->include('_components/card/CardPremiumCourse') ?>
				</template>
			</div>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('courses/reward/script') ?>