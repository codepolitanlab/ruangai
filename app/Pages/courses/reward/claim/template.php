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

	.scale-selected {
		transform: scale(1.05);
	}

	.object-fit-cover {
		object-fit: cover;
	}

	.selectable-card {
		filter: grayscale(100%);
		opacity: 0.6;
	}

	.grayscale-0 {
		filter: grayscale(0%);
		opacity: 1;
	}
</style>

<style>
	/* ==============================================================
	   TEMA GELAP — selaras dengan beranda/dashboard user (tanpa ubah logic)
	   ============================================================== */
	#claim_reward {
		background-color: var(--rd-bg);
		color: var(--rd-text);
		min-height: 100vh;
	}
	#claim_reward #appCapsule {
		background-color: var(--rd-bg) !important;
		color: var(--rd-text);
	}
	#claim_reward .appContent { color: var(--rd-text); }

	/* Permukaan kartu -> gelap */
	#claim_reward .card,
	#claim_reward .card-body,
	#claim_reward .bg-white,
	#claim_reward .alert {
		background-color: var(--rd-surface) !important;
		color: var(--rd-text) !important;
		border-color: var(--rd-border) !important;
	}
	#claim_reward .card { box-shadow: none !important; }

	/* Kartu premium pilihan kelas khusus (inline #0d2535 -> surface-2) */
	#claim_reward .card.selectable-card {
		background-color: var(--rd-surface-2) !important;
		border-color: var(--rd-border) !important;
	}

	/* Judul */
	#claim_reward h1, #claim_reward h2, #claim_reward h3,
	#claim_reward h4, #claim_reward h5, #claim_reward h6,
	#claim_reward .h1, #claim_reward .h2, #claim_reward .h3,
	#claim_reward .h4, #claim_reward .h5, #claim_reward .h6 {
		color: var(--rd-text) !important;
	}

	/* Teks isi/muted */
	#claim_reward p, #claim_reward .text-muted, #claim_reward .text-secondary,
	#claim_reward .card-text, #claim_reward .card-title, #claim_reward .card-subtitle {
		color: var(--rd-text-muted) !important;
	}
	#claim_reward .text-dark { color: var(--rd-text) !important; }
	#claim_reward .opacity-50, #claim_reward .opacity-75 { opacity: 1 !important; }

	/* Tombol & tombol kembali */
	#claim_reward .btn-primary {
		background-color: var(--rd-primary) !important;
		border-color: var(--rd-primary) !important;
		color: var(--rd-primary-contrast) !important;
	}
	#claim_reward .btn-white.bg-white {
		background-color: var(--rd-surface-2) !important;
		color: var(--rd-primary) !important;
		border-color: var(--rd-border) !important;
	}
	#claim_reward .btn-white.bg-white .bi { color: var(--rd-primary) !important; }

	/* Info token */
	#claim_reward .alert-primary {
		background-color: var(--rd-primary-soft) !important;
		color: var(--rd-text) !important;
		border-color: var(--rd-border) !important;
	}
	#claim_reward a:not(.btn) { color: var(--rd-primary); }
</style>

<div
	class="header-mobile-only"
	id="claim_reward"
	x-data="claimReward()">
	<div id="appCapsule" class="">
		<div id="course-features" class="d-flex gap-2 px-3 pt-4 pb-1">
			<a href="/courses/reward" class="btn btn-white bg-white text-primary rounded-4 px-2">
				<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
			</a>
		</div>

		<div class="appContent" style="min-height:90vh">
			<div class="bg-white p-4 rounded-4 my-3">
				<h5 class="fw-bold">Klaim Kelas Khusus</h5>

				<!-- Belum punya token (masih ada kelas khusus yang bisa diklaim) -->
				<template x-if="data.user_token < 1 && (data?.premium_courses?.length ?? 0) > 0">
					<div class="mb-4">
						<p class="fs-6 mb-2 alert bg-warning bg-opacity-50">
							Kamu belum punya token reward untuk dapat mengklaim kelas khusus. <br><br>
							<a href="/courses/reward/howto">Cara Mendapatkan Token Reward <i class="bi bi-box-arrow-up-right ms-1"></i></a>
						</p>
					</div>
				</template>

				<!-- Punya token & masih ada kelas khusus yang bisa diklaim -->
				<template x-if="data.user_token > 0 && (data?.premium_courses?.length ?? 0) > 0">
					<div class="mb-4">
						<p class="fs-6 mb-2 alert alert-primary">
							Kamu memiliki <b x-text="data.user_token"></b> token yang belum digunakan.
						</p>
						<p class="mb-1">Pilih kelas khusus di bawah ini yang cocok buatmu. Setiap kelas bernilai 1 token.</p>
					</div>
				</template>

				<!-- Semua kelas khusus sudah diklaim -->
				<template x-if="Array.isArray(data?.premium_courses) && data.premium_courses.length === 0">
					<div class="text-center mb-2">
						<img src="<?= base_url('mobilekit/assets/img/ruangai/token-coin.png') ?>" width="110" height="110" alt="" class="mb-2">
						<h5 class="fw-bold">Semua kelas khusus sudah kamu klaim</h5>
						<p class="mx-auto mb-1" style="max-width: 340px;">
							Belum ada kelas khusus baru yang bisa diklaim saat ini. Token reward yang kamu miliki
							akan tetap tersimpan dan bisa kamu gunakan untuk mengklaim kelas khusus berikutnya.
						</p>
						<a href="/courses/reward" class="btn btn-primary mt-3"><i class="bi bi-gift me-1"></i> Lihat Daftar Kelas Khusus</a>
					</div>
				</template>

				<template x-for="premium in data?.premium_courses" :key="premium.id">
					<div
						class="card shadow-sm mb-3 rounded-4 position-relative selectable-card"
						:class="{'shadow-lg scale-selected grayscale-0': selected === premium.id}"
						style="background:#0d2535; cursor: pointer; transition: all 0.2s ease-in-out;"
						@click="if(data.user_token > 0){ selected = premium.id; courseSlug = premium.slug }">

						<!-- Badge checklist -->
						<template x-if="selected === premium.id">
							<div
								class="position-absolute text-white fs-4 bg-warning rounded-circle d-flex align-items-center justify-content-center"
								style="width: 28px; height: 28px; left: -10px; top: 25px;">
								<i class="bi bi-check-lg"></i>
							</div>
						</template>

						<!-- Unchecked -->
						<template x-if="selected !== premium.id">
							<div
								class="position-absolute text-white fs-4 bg-warning rounded-circle d-flex align-items-center justify-content-center"
								style="width: 28px; height: 28px; left: -10px; top: 25px;">
								<i class="bi bi-circle-fill"></i>
							</div>
						</template>

						<div class="row g-0 align-items-stretch">
							<!-- Thumbnail -->
							<div class="col-3">
								<img :src="premium?.thumbnail || premium?.cover"
									class="object-fit-cover rounded-start-5"
									alt="thumbnail kelas"
									style="height: 80px; width: 80px; object-fit: cover;">
							</div>

							<!-- Content -->
							<div class="col-9 d-flex flex-column justify-content-center text-white p-3">
								<h5 class="fw-bold text-white text-end pe-2 mb-1" x-text="premium?.course_title"></h5>
								<!-- <p class="small mb-0 text-white-50"
									x-text="premium?.description.length > 90 ? premium?.description.slice(0, 90) + '...' : premium?.description">
								</p> -->
							</div>
						</div>
					</div>
				</template>

				<!-- Button (hanya tampil bila masih ada kelas khusus yang bisa diklaim) -->
				<template x-if="(data?.premium_courses?.length ?? 0) > 0">
					<div class="d-grid">
						<button
							class="btn btn-primary btn-lg btn-block rounded-4 mt-3 py-2 d-flex align-items-center justify-content-center gap-2"
							@click="claim"
							:class="{'disabled': !selected || loading || data.user_token < 1}">
							<!-- spinner -->
							<template x-if="loading">
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
							</template>

							<!-- text -->
							<span x-text="loading ? 'Memproses...' : 'Klaim Kelas'"></span>
						</button>
					</div>
				</template>

			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('courses/reward/claim/script') ?>