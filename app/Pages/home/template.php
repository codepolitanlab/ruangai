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


		/* kasih prioritas ke tabel custom */
		.custom-table thead tr {
			background-color: #6bb1ce !important;
			/* biru header */
			color: #fff !important;
		}

		.custom-table tbody tr:nth-child(odd) {
			background-color: #e6f1f6 !important;
			/* biru muda */
		}

		.custom-table tbody tr:nth-child(even) {
			background-color: #f9f9f9 !important;
			/* abu muda */
		}

		.custom-table th,
		.custom-table td {
			vertical-align: middle;
		}

		.custom-table {
			border-radius: 12px;
			overflow: hidden;
		}
	</style>

	<div id="appCapsule">
		<!-- Show loading / retry until dataReady is true -->
		<template x-if="!dataReady">
			<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 50vh; gap: 1rem;">
				<div x-show="loadingData" class="d-flex justify-content-center align-items-center">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>

				<div x-show="!loadingData" class="text-center text-muted">
					<p>Gagal memuat data. <button class="btn btn-link" @click="reloadData(true)">Coba lagi</button></p>
				</div>
			</div>
		</template>

		<!-- Comentor view -->
		<template x-if="dataReady && data.is_comentor">
			<?= $this->include('home/comentor'); ?>
		</template>

		<!-- User view -->
		<template x-if="dataReady && !data.is_comentor">
			<?= $this->include('home/user'); ?>
		</template>
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
	<div class="modal fade" id="modalTutorial" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalTutorialLabel" aria-hidden="true" x-ref="modalTutorial">
		<div class="modal-dialog modal-dialog-centered mod modal-lg">
			<div class="modal-content bg-transparent border-0">
				<div class="modal-header bg-transparent border-0 pe-0">
					<button type="button" @click="setVideoTutorial(null)" class="btn-close btn-close-white fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-0">
					<div class="ratio ratio-16x9" x-html="meta?.videoTutorial">
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('home/script') ?>
</div>