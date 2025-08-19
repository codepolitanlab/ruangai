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

		.bg-warning-2 {
			background-color: #fe9500;
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
		<div class="appContent pt-2 pb-4" style="min-height:90vh">

			<!-- Header -->
			<div class="p-4 px-3 mb-3 bg-white rounded-4 position-relative overflow-hidden" style="min-height:110px">
				<div class="d-flex align-items-center gap-3 position-relative" style="z-index: 99; position: absolute !important; bottom: 10px;">
					<div class="avatar">
						<img :src="data?.user?.avatar && data?.user?.avatar != '' ? data?.user?.avatar : `https://ui-avatars.com/api/?name=${data?.name ?? 'El'}&background=79B2CD&color=FFF`" alt="avatar" class="imaged w48 rounded-circle">
					</div>
					<div>
						<h4 class="mb-0 text-muted fw-normal">Selamat Belajar,</h4>
						<h5 class="mb-0" x-text="data?.name"></h5>
					</div>
				</div>
				<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%206633.png" class="position-absolute bottom-0 end-0 w-25" alt="">
				<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Group%208476.png" class="position-absolute me-2" width="45%" style="top: 10px;right: 10px" alt="">
			</div>

			<!-- Pengumuman -->
			<?= $this->include('home/pengumuman'); ?>

			<div x-show="!meta.isValidEmail" class="rounded-20 p-3 py-4 bg-white my-4">
				<div class="row justify-content-center">
					<div class="col-lg-10">
						<h5 class="m-0">Kamu belum melakukan verifikasi email nih, silahkan lakukan verifikasi email terlebih dahulu.</h5>
						<button x-show="!meta.loading" type="button" x-on:click="showPopupVerification()" class="btn btn-primary rounded-pill px-4 my-3 fw-bold">Verifikasi Email Sekarang</button>
						<button x-show="meta.loading" type="button" disabled class="btn btn-primary rounded-pill px-4 my-3 fw-bold">
							<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
							Sedang mengirim OTP...
						</button>
					</div>
				</div>
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
			<div class="mb-3">
				<div class="bg-white p-4 rounded-4 g-3 mb-4">
					<h5 class="fw-semibold">Progres Belajar</h5>
					<div class="row">

						<div class="col-md-6 mb-3">
							<a href="/courses">
								<div class="class-card h-100 p-3 d-flex flex-column justify-content-between position-relative" style="min-height: 220px;">
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
							<div class="card text-white bg-primary position-relative" style="min-height: 200px; border-radius: 18px; overflow: hidden; z-index: 1">
								<img src="https://ik.imagekit.io/56xwze9cy/ruangai/card%20class.png" class="w-100 position-relative" alt="Kelas AI" style="z-index: 1">
								<div class="p-3 d-flex flex-column justify-content-end position-relative" style="background: linear-gradient(to top, #79B2CD 50%, rgba(255, 255, 255, 0));height: 100%;margin-top: -50px;z-index: 1000">
									<h5 
										class="card-title text-white mb-1 mt-3" 
										style="font-size: 1.1rem; font-weight: 500;" 
										x-text="data?.last_course.title"></h5>
									<div class="d-flex align-items-center mb-2">
										<i class="bi bi-play-fill fs-3 me-2"></i>
										<div class="progress flex-grow-1 me-2" style="height: 5px;">
											<div class="progress-bar bg-warning" role="progressbar" :style="`width: ${Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100)}%`"></div>
										</div>
										<span x-text="Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100)"></span>%
									</div>
									<a x-show="Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100) < 100" :href="`/courses/intro/${data?.last_course.id}/${data?.last_course?.slug}/lessons`" class="btn bg-white rounded-pill p-1 text-secondary hover">Mulai Belajar</a>
									<a x-show="Math.round(data?.last_course.lesson_completed/data?.last_course.total_lessons*100) >= 100 && data?.total_live_session > 0" :href="`/certificate/claim/${data?.last_course.id}`" class="btn bg-white rounded-pill p-1 text-success hover">Klaim Sertifikat</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Join Grup -->
				<div class="p-3 mb-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
					<span>Belum gabung Komunitas RuangAI?</span>
					<a href="https://t.me/codepolitan/102492" target="_blank" class="btn btn-primary rounded-pill"><i class="bi bi-telegram"></i> Gabung Grup</a>
				</div>

				<!-- Referral -->
				<div class="p-3 rounded-4 bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
					<span>Pengen dapet hadiah menarik?</span>
					<a href="https://ruangai.id/referral" target="_blank" class="btn btn-success rounded-pill"><i class="bi bi-coin"></i> Program Referral</a>
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
				<div class="modal-body">
					<p>Mohon cek kembali email berikut, pastikan sudah benar supaya OTP dapat diterima untuk aktivasi.</p>
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" x-model="meta.email" :disabled="emailSent">
							<button type="button" class="btn btn-primary" x-on:click="sendEmailVerification()" :disabled="meta.loading || emailSent">
								<span x-show="meta.loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								<span x-show="!meta.loading">Kirim OTP</span>
							</button>
						</div>
					</div>
					<div x-show="emailSent">
						<hr>
						<p>Cek email anda (inbox/spam), dan masukkan kode OTP yang anda terima di bawah ini.</p>
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
								<a href="#" @click.prevent="resendOtp()">Kirim Ulang</a>
							</span>
							<span x-show="resendCooldown > 0" class="text-muted">
								Kirim ulang dalam <strong x-text="resendCooldown"></strong> detik...
							</span>
						</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
					<button
						type="button"
						class="btn btn-primary"
						@click="verifyEmail()"
						:disabled="isVerifying || otp.join('').length !== 6">
						<span x-text="isVerifying ? 'Memverifikasi...' : 'Verifikasi'"></span>
					</button>
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('home/script') ?>
</div>