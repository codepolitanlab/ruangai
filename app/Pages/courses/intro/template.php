<div
	class="header-mobile-only"
	id="course_intro"
	x-data="courseIntro($params.course_id)"
	x-effect="loadPage(`/courses/intro/data/${$params.course_id}`)">

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
	</style>

	<div id="appCapsule">
		<!-- Fullscreen Alert Overlay -->
		<!-- <div x-show="!data.is_enrolled" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.9); z-index: 9999;">
			<div class="text-center p-4">
				<div class="alert alert-warning mb-4" role="alert">
					<i class="bi bi-exclamation-triangle fs-1 d-block"></i>
					<h4 class="text-warning mb-2">Akses Terbatas</h4>
					<p class="mb-4">Anda belum terdaftar di kelas ini. Silakan daftar terlebih dahulu untuk mengakses materi.</p>
					<a target="_blank" href="https://ruangai.id/registration" class="btn btn-warning">Daftar Sekarang</a>
				</div>
			</div>
		</div> -->

		<div class="appContent py-4" style="min-height:90vh">
			<div>
				<div class="mb-3">
					<a href="/courses" class="btn rounded-4 px-2 btn-white bg-white text-primary">
						<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
					</a>
				</div>
				<!-- <div class="ms-2">
					<h5 class="mb-1 fs-5 opacity-50">Kelas</h5>
					<h2 class="h4 mb-3"><span x-text="data.course.course_title"></span></h2>
				</div> -->
			</div>

			<!-- Show Expire Alert -->
			<template x-if="data.is_expire">
				<div class="card bg-warning-2 rounded-4 mb-3 shadow-none">
					<div class="card-body d-flex gap-3">
						<i class="bi bi-stopwatch-fill text-white display-3 shaky-icon"></i>
						<div>
							<h4 class="text-white">Program Belajar Chapter 2 Sudah Dibuka!</h4>
							<p class="mb-3 text-white">Kamu dapat melanjutkan belajar dengan bergabung di Chapter 2 dengan mengklik tombol di bawah ini untuk mendaftar ulang.</p>
							<button class="btn btn-light" @click="heregister"><i class="bi bi-file-earmark-arrow-up"></i> Daftar Ulang ke Chapter 2</button>
						</div>
					</div>
				</div>
			</template>

			<!-- Card Kelas -->
			<div class="bg-white rounded-4 mb-3 overflow-hidden">
				<div class="card border-0 rounded-4 shadow-none position-relative">
					<div class="position-relative" style="height: 200px;">
						<img
							src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206751%20(2).png"
							class="rounded-top-4 w-100 h-100 object-fit-cover"
							alt="AI Course" />
						<!-- Fade gradient -->
						<div class="position-absolute bottom-0 start-0 end-0" style="height: 100%; background: linear-gradient(to top, white, transparent); pointer-events: none;"></div>
					</div>

					<div class="card-body p-3 py-4">
						<div class="h5 mb-3">
							Kelas - <span x-text="data.course.course_title"></span>
						</div>

						<!-- Deskripsi pendek -->
						<p class="card-text p-0 mt-2 mb-0">
							Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta perannya dalam kehidupan sehari-hari.
							<button
								x-show="!meta.expandDesc" x-transition
								@click="meta.expandDesc = !meta.expandDesc"
								class="border-0 bg-transparent text-primary text-decoration-none p-0">
								Lihat selengkapnya
							</button>
						</p>
						<div class="mt-3" x-show="meta.expandDesc" x-transition>
							<p>Kelas ini merupakan kelas pertama program RuangAI dari CODEPOLITAN yang fokus membahas tentang fundamental kecerdasan artifisial dengan total durasi belajar 15 jam, terdiri dari 30 materi dan 10 sesi live bersama mentor AI.</p>
							<p>Kelas ini merupakan bagian dari program AI Opportunity Fund: Asia Pasifik, bekerja sama dengan AVPN dan didukung oleh Google.org dan Asian Development Bank.</p>
							<button
								@click="meta.expandDesc = !meta.expandDesc"
								class="border-0 bg-transparent text-primary text-decoration-none p-0">
								Lihat lebih sedikit
							</button>
						</div>
					</div>
				</div>
			</div>


			<!-- Progress Stats -->
			<div class="p-3 pb-4 bg-white rounded-4 mb-3 position-relative"
				:class="{'lesson-not-complete': data.student.progress < 100}">
				<h4 class="mb-3">Progres Belajar</h4>
				
				<div x-show="data?.is_expire">
					<div class="position-absolute d-flex align-items-center justify-content-center rounded-4 top-0 start-0 end-0 bottom-0" style="z-index: 100;width: 100%;height: 100%;background: rgba(0, 0, 0, 0.5);">
						<i class="bi bi-lock-fill text-white display-3"></i>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div id="card-progress-lesson" 
							class="card border-0 shadow-none rounded-4 p-3 d-flex flex-column justify-content-between position-relative"
							:class="{'lesson-completed bg-success bg-opacity-50': data.student.progress == 100, 
							'bg-light-primary': data.student.progress < 100}"
							style="min-height: 210px">
							<div class="me-3 bg-white text-dark rounded-4 p-2 d-flex align-items-center  justify-content-center" style="width: 50px;height: 50px">
								<i class="bi h3 m-0" :class="data.student.progress == 100 ? 'bi-check-circle text-success' : 'bi-journal-text'"></i>
							</div>
							<div class="d-flex align-items-end gap-2 mt-3 text-dark">
								<h1 class="mb-0 display-6 fw-bold" x-text="data?.lesson_completed "></h1>
								<p class="mb-1">dari <span x-text="data?.total_lessons"></span> modul selesai</p>
							</div>
							<div class="d-flex align-items-center">
								<div class="progress flex-grow-1 me-2 " style="height: 5px;">
									<div class="progress-bar" role="progressbar" :style="`width: ${data?.student?.progress}%`"></div>
								</div>
								<span class="fw-bold" x-text="`${data?.student?.progress}%`"></span>
							</div>
							<a 
								:href="`/courses/intro/${data.course.id}/${data.course.slug}/lessons`" 
								class="btn btn-primary hover rounded-pill p-1 fs-6">Lihat Materi</a>
							<img src="https://ik.imagekit.io/56xwze9cy/jagoansiber/Vector%20(1).png" class="position-absolute end-0" style="top: 12px;opacity: .3;" width="70" alt="">
						</div>
					</div>

					<div class="col-md-6">
						<div id="card-progress-live" 
							class="card border-0 shadow-none rounded-4  p-3 d-flex flex-column justify-content-between position-relative"
							style="min-height: 210px"
							:class="{'live-completed bg-success bg-opacity-50': data.live_attendance > 0, 
							'bg-light-secondary': data.live_attendance == 0}">
							<div class="me-3 bg-white rounded-4 p-2 d-flex align-items-center  justify-content-center" style="width: 50px;height: 50px">
								<i class="bi h3 m-0" :class="data.live_attendance > 0 ? 'bi-check-circle text-success' : 'bi-camera-video text-secondary'"></i>
							</div>
							<div 
								:class="data.student.progress == 100 ? 'd-flex' : 'd-none'"
								class="d-flex align-items-end gap-2 mt-3 mb-4">
								<h1 class="mb-0 display-6 fw-bold" x-text="data?.live_attendance"></h1>
								<p class="mb-1">Live session diikuti</p>
							</div>
							<div x-show="data.student.progress < 100">
								<div class="mb-1 position-relative">Selesaikan materi untuk dapat mengikuti sesi live</div>
							</div>
							<a :href="`/courses/intro/${data?.course?.id}/${data?.course?.slug}/live_session`" class="btn btn-secondary hover rounded-pill p-1 w-100 fs-6">Lihat Jadwal</a>
							<img src="https://ik.imagekit.io/56xwze9cy/jagoansiber/Vector%20(1).png" class="position-absolute end-0" style="top: 12px;opacity: .3;" width="70" alt="">
						</div>
					</div>
				</div>

			</div>


			<!-- Final Task -->
			<!-- <div class="section p-3 mb-3 bg-white rounded-4">
				<h4 class="fw-bold mb-3" style="color: #222;">Tugas Akhir</h4>
				<div class="card border-0 rounded-4" style="background: #7db9d2;">
					<div class="card-body d-flex align-items-center gap-3 p-4">
						<div class="rounded-3 d-flex align-items-center justify-content-center" style="width:64px;height:64px;background:#fff;">
							<i class="bi bi-clipboard" style="font-size:2.5rem; color:#7db9d2;"></i>
						</div>
						<div class="flex-grow-1">
							<div class="fw-bold mb-1" style="font-size:1.2rem; color:#fff;">Tugas Akhir - Berkenalan Dengan AI</div>
							<div style="font-size:1rem; color:#eaf6fa;">30 Soal pilihan ganda</div>
						</div>
					</div>
				</div>
			</div> -->

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

			<!-- Klaim Reward -->
			<div class="section p-3 mb-3 bg-white rounded-4">
				<h4 class="fw-bold mb-3" style="color: #222;">Klaim Reward</h4>

				<div class="card border-0 rounded-4 cursor-pointer"
					style="background: #e91e95;"
					@click="claimReward()"
					:class="data.course_completed ? '' : 'bg-dark bg-opacity-10'">
					<div class="card-body d-flex align-items-center gap-3 p-4">
						<div class="rounded-3 d-flex align-items-center justify-content-center px-3" style="min-width:64px;height:64px;background:#fff;">
							<i class="bi bi-gift fs-2" :class="data.course_completed ? '' : 'text-dark opacity-50'" style="font-size:2.5rem; color:#e91e95;"></i>
						</div>
						<div class="flex-grow-1" :class="data.course_completed ? 'text-white' : 'opacity-50'">
							<!-- <div class="fw-bold mb-1" style="font-size:1.2rem;">Bonus Kelas Lanjutan</div> -->
							<h5 class="h6 mb-0" style="font-size:1rem;">Pilih salah satu dari 4 kelas lanjutan yang paling cocok buatmu</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('courses/intro/script') ?>
</div>