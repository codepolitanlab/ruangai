<div
	class="header-mobile-only"
	id="course_intro"
	x-data="courseIntro()"
	x-effect="loadPage(`/beasiswa/intro/data`)">

	<style>
		.cover {
			object-fit: cover;
			width: 100%;
			height: 100%;
		}

		.progress,
		.progress-bar {
			height: 22px;
		}

		.card-hover:hover {
			transform: translateY(-2px);
			transition: all 0.3s ease;
		}

		.bg-light-secondary {
			background-color: rgba(108, 117, 125, 0.1);
		}

		.rounded-20 {
			border-radius: 20px;
		}

		.bg-warning-2 {
			background-color: #fe9500;
		}

		.lesson-not-complete #card-progress-live {
			background-color: #ddd !important;
		}

		.lesson-not-complete #card-progress-live .bi,
		.lesson-not-complete #card-progress-live p,
		.lesson-not-complete #card-progress-live h1 {
			color: #777 !important;
		}

		#card-progress-lesson.lesson-completed h1,
		#card-progress-lesson.lesson-completed span,
		#card-progress-lesson.lesson-completed p,
		#card-progress-live.live-completed h1,
		#card-progress-live.live-completed span,
		#card-progress-live.live-completed p {
			color: white;
		}

		#card-progress-live.live-completed .bi,
		#card-progress-live.live-completed .btn-secondary,
		#card-progress-lesson.lesson-completed .bi,
		#card-progress-lesson.lesson-completed .btn-primary,
		#card-progress-lesson.lesson-completed .progress-bar {
			background-color: #fff !important;
			color: #74bb8bff !important;
			border: 0;
		}

		.class-card {
			border-radius: 20px;
			padding: 20px;
			color: white;
			background: #EAF8FF;
		}
	</style>

	<div id="appCapsule">
		<div class="appContent py-4">
			<div class="mb-3">
				<button @click="history.back()" class="btn rounded-4 px-2 btn-white bg-white text-primary">
					<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
				</button>
			</div>

			<!-- Show Expire Alert -->
			<template x-if="data.is_expire && data?.student?.program !== 'RuangAI2026WSGenAI'">
				<div class="card bg-secondary rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3">
						<i class="bi bi-stopwatch-fill text-white display-3"></i>
						<div>
							<h4 class="text-white">Program Belajar Chapter 4 Sudah Ditutup</h4>
							<p class="mb-3 text-white">Pendaftaran untuk Chapter 4 telah ditutup. Nantikan informasi untuk chapter berikutnya.</p>
						</div>
					</div>
				</div>
			</template>

			<!-- Card Kelas -->
			<div class="bg-white rounded-4 mb-3 overflow-hidden">
				<div class="card border-0 rounded-4 shadow-none position-relative">
					<div class="position-relative" style="height: 200px;">
						<img
							:src="data?.course?.cover || data?.course?.thumbnail"
							class="rounded-top-4 w-100 h-100 object-fit-cover"
							alt="AI Course" />
						<!-- Fade gradient -->
						<div class="position-absolute bottom-0 start-0 end-0" style="height: 100%; background: linear-gradient(to top, white, transparent); pointer-events: none;"></div>
					</div>

					<div class="card-body p-3 py-4">
						<div class="h5 mb-3">
							<small class="text-primary">Beasiswa RuangAI</small> <br>
							<span x-text="data.course.course_title"></span>
						</div>

						<!-- Deskripsi pendek -->
						<!-- Ringkasan (hanya tampil kalau belum expand) -->
						<p class="card-text p-0 mt-2 mb-0 text-muted">
							Ikuti webinar untuk mendapatkan akses kelas online eksklusif AI Generatif. <br>
							Setelah webinar, akses kelas akan terbuka dan Anda bisa mengklaim sertifikat. Selesaikan kelas online untuk mendapatkan reward akses kelas lainnya.
						</p>

						<!-- Tombol teaser & enrol -->
						<template x-if="! data.is_enrolled">
							<div>
								<div class="text-end mt-4">
									<button
										:disabled="!data.course?.teaser"
										type="button"
										class="btn btn-outline-primary mb-2 mb-lg-0"
										@click="setVideoTeaser(data.course?.teaser)"
										data-bs-toggle="modal"
										data-bs-target="#teaserModal">
										<i class="bi bi-play-circle-fill"></i> SIMAK TEASER</button>

									<a href="/courses/reward/claim" class="btn btn-warning">
										<i class="bi bi-circle-fill" style="color:#ffeb3b"></i> KLAIM KELAS</a>
								</div>

								<div class="modal fade" id="teaserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="teaserModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-lg">
										<div class="modal-content bg-transparent border-0">
											<div class="modal-header bg-transparent border-0 pe-0">
												<button type="button" @click="setVideoTeaser(null)" class="btn-close btn-close-white fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body p-0">
												<div class="ratio ratio-16x9" x-html="meta?.videoTeaser">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</template>

					</div>
				</div>
			</div>

			<!-- List lesson for non enrolled user -->
			<template x-if="data.course?.lessons && Object.keys(data.course?.lessons).length > 0 && !data.is_enrolled">
				<template x-for="(topicLessons,topic) of data.course?.lessons">
					<section class="card shadow-none rounded-4 p-3 py-0 mb-3">
						<!-- <div class="h5 m-0" x-text="topic"></div> -->
						<div class="card-body d-flex flex-column align-items-center gap-1 py-3 px-0">
							<h4 class="w-100 mb-3">List Materi</h4>
							<template x-for="lesson of topicLessons">
								<div class="lesson-item rounded-20 pe-3 py-2 w-100 d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center gap-2">
										<i class="bi bi-file-play fs-4 text-primary"></i>
										<h4 class="fw-normal m-0" x-text="lesson.lesson_title"></h4>
									</div>
									<h5 class="m-0 ms-auto text-muted" x-text="lesson.duration"></h5>
								</div>
							</template>
						</div>
					</section>
				</template>
			</template>

			<!-- Section for enrolled user -->
			<template x-if="data?.is_enrolled">
				<div>
					<!-- Progress Stats -->
					<div class="p-3 pb-2 bg-white rounded-4 mb-3 position-relative"
						:class="{'lesson-not-complete': Math.round(data.lesson_completed/data.total_lessons*100) < 100}">

						<h4 class="mb-3">Jadwal Webinar</h4>

						<div class="row">
							<!-- Modul PDF -->
							<div class="col-md-4 mb-3">
								<div id="card-progress-lesson"
									class="card bg-light-primary border-0 shadow-none rounded-4 p-3 d-flex flex-column justify-content-between position-relative"
									style="min-height: 160px">
									<div class="d-flex">
										<h4 class="opacity-75">Modul PDF</h4>
									</div>
									<a href="javascript:void(0)"
										@click.prevent="navigateToTargetLesson()"
										class="btn btn-primary hover rounded-pill p-1 fs-6">Buka Modul</a>
									<img src="https://image.web.id/images/icon-bg-book.th.png" class="position-absolute end-0" style="top: 12px;opacity: .3;" width="90" alt="">
								</div>
							</div>

							<!-- Card Live Session Program Reguler -->
							<template x-if="data.course?.has_live_sessions === '1'">
								<div class="col-md-8 mb-3">
									<div id="card-progress-live"
										class="card border-0 bg-light-secondary shadow-none rounded-4  p-3 d-flex flex-column justify-content-between position-relative"
										style="min-height: 160px">
										<div class="d-flex flex-column gap-2">
											<h4 class="opacity-75 mb-0">Cara Mudah Bikin Video Keren Dari Nol Dengan Wan.Video & Flow</h4>
											<!-- Tampilkan tanggal webinar beserta ikon kalender -->
											<div class="">
												<i class="bi bi-calendar-event text-muted"></i>
												<span class="text-muted">28 September 2024, 19.00 WIB</span>
											</div>
											<a :href="`/beasiswa/intro/${data?.course?.id}/${data?.course?.slug}/live_session`"
												class="btn btn-secondary hover rounded-pill p-1 w-100 fs-6"
												:class="{'disabled': data?.lesson_completed != data?.total_lessons}">Daftar Webinar</a>
											<img src="https://image.web.id/images/icon-bg-webinar.th.png" class="position-absolute end-0" style="top: 12px;opacity: .3;" width="90" alt="">
										</div>
									</div>
							</template>
						</div>
					</div>

					<div class="section p-3 mb-3 bg-white rounded-4">
						<h4 class="fw-bold mb-3" style="color: #222;">Kelas Online AI Generatif</h4>
						<div class="mb-3">
							<div id="card-progress-lesson"
								class="card border-0 shadow-none rounded-4 p-3 d-flex flex-column justify-content-between position-relative"
								:class="{'lesson-completed bg-success bg-opacity-50': Math.round(data.lesson_completed/data.total_lessons*100) == 100, 
							'bg-light-primary': Math.round(data.lesson_completed/data.total_lessons*100) < 100}"
								style="min-height: 160px">
								<div class="d-flex">
									<div class="me-3 bg-white text-dark rounded-4 p-2 d-flex align-items-center  justify-content-center" style="width: 50px;height: 50px">
										<i class="bi h3 m-0" :class="Math.round(data.lesson_completed/data.total_lessons*100) == 100 ? 'bi-check-circle text-success' : 'bi-journal-text'"></i>
									</div>
									<div>
										<h5 class="text-light opacity-75 mb-0">Modul Video</h5>
										<h4 class="fw-bold text-white">Dasar-dasar dan Penggunaan Generative AI</h4>
									</div>
								</div>
								<div class="d-flex align-items-center">
									<div class="progress flex-grow-1 me-2 " style="height: 5px;">
										<div class="progress-bar" role="progressbar" :style="`width: ${Math.round(data.lesson_completed/data.total_lessons*100)}%`"></div>
									</div>
									<span class="fw-bold" x-text="`${Math.round(data.lesson_completed/data.total_lessons*100)}%`"></span>
								</div>
								<a href="javascript:void(0)"
									@click.prevent="navigateToTargetLesson()"
									class="btn btn-primary hover rounded-pill p-1 fs-6">Buka Kelas</a>
								<img src="https://image.web.id/images/icon-bg-video.th.png" class="position-absolute end-0" style="top: 12px;opacity: .3;" width="90" alt="">
							</div>
						</div>
					</div>


					<!-- Certificate -->
					<div class="section p-3 mb-3 pb-4 bg-white rounded-4">
						<h4 class="fw-bold mb-3" style="color: #222;">Klaim Sertifikat</h4>

						<div class="card border-0 rounded-4 bg-dark bg-opacity-10 cursor-pointer"
							@click="claimCertificate()"
							:class="data.course_completed ? 'bg-secondary' : 'bg-dark bg-opacity-10'">
							<div class="card-body d-flex align-items-center gap-3 p-4">
								<div class="rounded-3 d-flex align-items-center justify-content-center bg-white"
									style="min-width: 64px; height: 64px;">
									<i class="bi bi-award text-dark opacity-50 display-5"></i>
								</div>
								<div class="flex-grow-1">
									<h5 x-show="!data.course_completed" class="h6 opacity-50 mb-0">Selesaikan materi dan sesi live wajib untuk mendapatkan sertifikat.</h5>
									<div x-show="data.course_completed">
										<h3
											class="fw-bold mb-1"
											style="font-size:1.2rem; color:#fff;"
											x-text="data.student.cert_code ? `Unduh Sertifikat` : `Klaim Sertifikat`"></h3>
										<p class="text-white mb-1" x-show="!data.student.cert_code">Klik untuk mengklaim dan mengunduh sertifikat</p>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</template>

			<!-- <template x-if="data?.student.cert_code">
						<a href="https://www.ruangai.id/lenterai" target="_blank">
							<div class="section p-3 mb-3 pb-4 bg-white rounded-4">
								<h4 class="fw-bold mb-3" style="color: #222;">Daftar CO-Mentor</h4>
		
								<div class="card border-0 rounded-4 bg-secondary cursor-pointer">
									<div class="card-body d-flex align-items-center gap-3 p-4">
										<div class="rounded-3 d-flex align-items-center justify-content-center bg-white"
											style="min-width: 64px; height: 64px;">
											<i class="bi bi-person-workspace text-dark opacity-50 display-5"></i>
										</div>
										<div class="flex-grow-1">
											<h5 class="h6 opacity-50 mb-0">Daftar CO-Mentor untuk mendapatkan benefit khusus untuk kamu</h5>
										</div>
									</div>
								</div>
							</div>
						</a>
					</template> -->

			<!-- Klaim Reward, khusus untuk course campaign -->
			<template x-if="data.course?.id === '1'">
				<div class="section p-3 mb-3 bg-white rounded-4">
					<h4 class="fw-bold mb-3" style="color: #222;">Reward Beasiswa</h4>

					<div class="card bg-primary border-0 rounded-4 cursor-pointer"
						@click="claimReward()">
						<div class="card-body d-flex align-items-center gap-3 p-4">
							<div class="rounded-3 d-flex align-items-center justify-content-center px-3" style="min-width:64px;height:64px;background:#fff;">
								<i class="bi bi-gift fs-2" style="font-size:2.5rem; color:#e91e95;"></i>
							</div>
							<div class="flex-grow-1 text-white">
								<h5 class="h6 mb-0" style="font-size:1rem;">
									Pilih salah satu dari 5 kelas lanjutan yang paling cocok buatmu
								</h5>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>

		<template x-if="!data.is_enrolled && $params.course_id == 1">
			<a href="/courses/reward" class="btn btn-secondary rounded-pill p-1 w-100 fs-6 mb-3">Klaim Kelas</a>
		</template>

	</div>

	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('beasiswa/intro/script') ?>