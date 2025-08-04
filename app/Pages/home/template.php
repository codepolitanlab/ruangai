<div
	class="header-mobile-only"
	id="home"
	x-data="home()">

	<?= $this->include('_appHeader'); ?>

	<style>
		.announcement {
			background-color: #FFF6F2;
			border: 1px solid #eeeeee;
			border-radius: 15px;
			padding: 15px;
		}

		.announcement-icon {
			border-radius: 15px;
			width: 75px;
			height: 75px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 30px;
			color: #000;
		}

		.class-card {
			border-radius: 20px;
			padding: 20px;
			color: white;
			background: #EAF8FF;
		}

		.btn-voucher {
			border: none;
			border-radius: 20px;
			padding: 10px 20px;
			color: #063548;
			font-weight: bold;
		}

		.btn-voucher:hover {
			opacity: 0.8;
		}

		.progress-bar {
			background-color: #063548;
		}
	</style>

	<div id="appCapsule">

		<div class="appContent py-4">
			<!-- Header -->
			<div class="p-4 px-3 bg-white rounded-4 position-relative overflow-hidden">
				<div class="d-flex align-items-center gap-3 position-relative" style="z-index: 99;">
					<div class="avatar">
						<img :src="data?.user?.avatar && data?.user?.avatar != '' ? data?.user?.avatar : `https://ui-avatars.com/api/?name=${data?.name ?? 'El'}&background=79B2CD&color=FFF`" alt="avatar" class="imaged w64 rounded-circle">
					</div>
					<div>
						<h5 class="mb-1 fw-normal">Selamat Belajar,</h5>
						<h4 class="mb-0" x-text="data?.name"></h4>
					</div>
				</div>
				<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206633.png" class="position-absolute bottom-0 end-0 w-25" alt="">
			</div>

		</div>

		<div class="swiper swiper-notif pb-3">
			<div class="swiper-wrapper">
				<template x-for="i in 3" :key="i">
					<div class="swiper-slide">
						<!-- Pengumuman -->
						<div class="announcement d-flex align-items-top gap-3 shadow-sm border-secondary">
							<div class="announcement-icon bg-white" style="min-width:64px; height:64px">
								<img src="<?= base_url('mobilekit/assets/img/ruangai/speaker.svg') ?>" width="35" alt="">
							</div>
							<div>
								<h5 class="mb-1 fw-bold">Live Session Terdekat</h5>
								<p class="mb-1 line-height">Mencegah AI Merajalela di Muka Bumi</p>
								<div class="text-muted">
									<div class="text-nowrap">
										<i class="bi bi-calendar me-1"></i>
										<span class="me-3">23 April 2025, 12:00 WIB</span>
									</d>
								</div>
							</div>
						</div>
					</div>
				</template>
			</div>
		</div>

		<div class="appContent pt-2 pb-4" style="min-height:90vh">
			<!-- Card Kelas -->
			<div class="mb-3">
				<div class="bg-white p-4 rounded-4 g-3 mb-4">
					<h5 class="fw-semibold">Progres Belajar</h5>
					<div class="row">

						<div class="col-md-6">
							<a href="/courses">
								<div class="class-card h-100 p-3 d-flex flex-column justify-content-between position-relative">
									<div class="me-3 bg-white text-dark rounded p-2 d-flex align-items-center  justify-content-center" style="width: 50px;height: 50px">
										<img src="<?= base_url('mobilekit/assets/img/ruangai/module.svg') ?>" width="20" alt="">
									</div>
									<div class="d-flex align-items-end gap-2 mt-4 mb-2 text-dark">
										<h1 class="mb-0 display-6 fw-bold" x-text="data?.courses ?? 0"></h1>
										<p class="mb-1">kelas yang kamu miliki</p>
									</div>
									<a href="/courses" class="btn btn-primary hover rounded-pill p-1">Lihat kelas saya</a>
									<img src="https://ik.imagekit.io/56xwze9cy/jagoansiber/Vector%20(1).png" class="position-absolute end-0" style="top: 12px;opacity: .1;" width="70" alt="">
								</div>
							</a>
						</div>

						<!-- Lanjutkan Belajar -->
						<div class="col-md-6">
							<div class="card text-white bg-primary position-relative" style="min-height: 200px; border-radius: 18px; overflow: hidden;">
								<img src="https://ik.imagekit.io/56xwze9cy/ruangai/card%20class.png" class="w-100 position-relative" alt="Kelas AI" style="z-index: 1">
								<div class="p-3 d-flex flex-column justify-content-end position-relative" style="background: linear-gradient(to top, #79B2CD 50%, rgba(255, 255, 255, 0));height: 100%;margin-top: -50px;z-index: 1000">
									<h5 class="card-title text-white mb-1 mt-3" style="font-size: 1.1rem; font-weight: 500;" x-text="data?.last_lesson.course_title"></h5>
									<div class="d-flex align-items-center mb-2">
										<i class="bi bi-play-fill fs-3 me-2"></i>
										<div class="progress flex-grow-1 me-2" style="height: 5px;">
											<div class="progress-bar bg-warning" role="progressbar" :style="`width: ${data?.last_lesson.progress}%`"></div>
										</div>
										<span x-text="data?.last_lesson.progress"></span>%
									</div>
									<a :href="`/courses/intro/${data?.last_lesson.course_id}/${data?.last_lesson?.slug}`" class="btn bg-white rounded-pill p-1 text-secondary hover">Mulai Belajar</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Join Grup -->
				<div class="p-3 mb-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
					<span>Belum Gabung Komunitas RuangAI?</span>
					<a href="/voucher" class="btn btn-primary rounded-pill"><i class="bi bi-telegram"></i> Gabung Sekarang</a>
				</div>

				<!-- Referral -->
				<div class="p-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
					<span>Pengen Dapet Hadiah Menarik?</span>
					<a href="/voucher" class="btn btn-success rounded-pill">Ikuti Program Referral</a>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalVerifyEmail" tabindex="-1" aria-labelledby="modalVerifyEmailLabel" aria-hidden="true" x-ref="modalVerify">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="modalVerifyEmailLabel">Verifikasi Email Anda</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-center">
					<p>Kami telah mengirimkan kode OTP ke email Anda. Silakan masukkan 6 digit kode di bawah ini.</p>

					<div id="otp-container" class="d-flex justify-content-center gap-2 mb-3">
						<input
							type="tel"
							class="form-control text-center fs-4"
							style="width: 45px; height: 50px;"
							maxlength="1"
							x-model="otp[0]"
							x-ref="otp0"
							x-init="$el.focus()"
							@input="handleOtpInput($event, 0)"
							@keydown.backspace="handleBackspace($event, 0)"
							:disabled="isVerifying"
							autocomplete="off">
						<input
							type="tel"
							class="form-control text-center fs-4"
							style="width: 45px; height: 50px;"
							maxlength="1"
							x-model="otp[1]"
							x-ref="otp1"
							@input="handleOtpInput($event, 1)"
							@keydown.backspace="handleBackspace($event, 1)"
							:disabled="isVerifying"
							autocomplete="off">
						<input
							type="tel"
							class="form-control text-center fs-4"
							style="width: 45px; height: 50px;"
							maxlength="1"
							x-model="otp[2]"
							x-ref="otp2"
							@input="handleOtpInput($event, 2)"
							@keydown.backspace="handleBackspace($event, 2)"
							:disabled="isVerifying"
							autocomplete="off">
						<input
							type="tel"
							class="form-control text-center fs-4"
							style="width: 45px; height: 50px;"
							maxlength="1"
							x-model="otp[3]"
							x-ref="otp3"
							@input="handleOtpInput($event, 3)"
							@keydown.backspace="handleBackspace($event, 3)"
							:disabled="isVerifying"
							autocomplete="off">
						<input
							type="tel"
							class="form-control text-center fs-4"
							style="width: 45px; height: 50px;"
							maxlength="1"
							x-model="otp[4]"
							x-ref="otp4"
							@input="handleOtpInput($event, 4)"
							@keydown.backspace="handleBackspace($event, 4)"
							:disabled="isVerifying"
							autocomplete="off">
						<input
							type="tel"
							class="form-control text-center fs-4"
							style="width: 45px; height: 50px;"
							maxlength="1"
							x-model="otp[5]"
							x-ref="otp5"
							@input="handleOtpInput($event, 5)"
							@keydown.backspace="handleBackspace($event, 5)"
							:disabled="isVerifying"
							autocomplete="off">
					</div>
					<div x-show="errorMessage" class="text-danger mb-3" x-text="errorMessage"></div>

					<p class="mb-0">
						<span x-show="resendCooldown <= 0">
							Tidak menerima kode?
							<a x-show="!meta.loading" href="#" @click.prevent="resendOtp()">Kirim Ulang</a>
							<span x-show="meta.loading" class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
						</span>
						<span x-show="resendCooldown > 0" class="text-muted">
							Kirim ulang dalam <strong x-text="resendCooldown"></strong> detik...
						</span>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button
						type="button"
						class="btn btn-primary"
						@click="verifyEmail()"
						:disabled="isVerifying || otp.join('').length !== 6">
						<span x-show="isVerifying" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
						<span x-text="isVerifying ? 'Memverifikasi...' : 'Verifikasi'"></span>
					</button>
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('home/script') ?>
</div>