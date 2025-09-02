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

	.scale-102 {
		transform: scale(1.02);
	}

	.object-fit-cover {
		object-fit: cover;
	}

	.selectable-card {
		filter: grayscale(100%);
	}

	.grayscale-0 {
		filter: grayscale(0%);
	}


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
				<h5 class="fw-bold mb-1">Klaim Kelas Premium</h5>
				<p class="mb-4 text-muted">Pilih kelas premium yang cocok buatmu</p>

				<template x-for="premium in data?.premium_courses" :key="premium.id">
					<div
						class="card shadow-sm mb-3 overflow-hidden rounded-4 position-relative selectable-card"
						:class="{'shadow-lg scale-102 grayscale-0': selected === premium.id}"
						style="background:#0d2535; cursor: pointer; transition: all 0.2s ease-in-out;"
						@click="selected = premium.id; courseSlug = premium.slug">
						<!-- Badge checklist -->
						<template x-if="selected === premium.id">
							<div
								class="position-absolute top-0 end-0 m-3 text-success bg-white rounded-circle d-flex align-items-center justify-content-center"
								style="width: 28px; height: 28px;">
								<i class="bi bi-check-lg"></i>
							</div>
						</template>

						<div class="row g-0 align-items-stretch">
							<!-- Thumbnail -->
							<div class="col-4">
								<img :src="premium?.cover"
									class="w-100 h-100 object-fit-cover"
									alt="thumbnail kelas"
									style="min-height: 100%; object-fit: cover;">
							</div>

							<!-- Content -->
							<div class="col-8 d-flex flex-column justify-content-center text-white p-3">
								<h5 class="fw-bold text-white mb-1" x-text="premium?.course_title"></h5>
								<p class="small mb-0 text-white-50"
									x-text="premium?.description.length > 90 ? premium?.description.slice(0, 90) + '...' : premium?.description">
								</p>
							</div>
						</div>
					</div>
				</template>

				<!-- Button -->
				<div class="d-grid">
					<button
						class="btn btn-primary btn-block rounded-4 py-2 d-flex align-items-center justify-content-center gap-2"
						@click="claim"
						:class="{'disabled': !selected || loading}">
						<!-- spinner -->
						<template x-if="loading">
							<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
						</template>

						<!-- text -->
						<span x-text="loading ? 'Memproses...' : 'Klaim Kelas'"></span>
					</button>
				</div>

			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('courses/reward/claim/script') ?>