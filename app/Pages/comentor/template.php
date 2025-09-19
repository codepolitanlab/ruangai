<div
	class="header-mobile-only"
	id="comentor"
	x-data="comentor()">

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
		<div class="appContent pt-2 pb-4" style="min-height:90vh">

			<div class="my-3">
				<button @click="history.back()" class="btn rounded-4 px-2 btn-white bg-white text-primary">
					<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
				</button>
			</div>

			<template x-if="data?.leader?.role_id == 4">
				<div>
					<!-- Referral Co-Mentor -->
					<div class="p-3 mb-3 rounded-4 bg-white d-flex flex-column gap-2 justify-content-between">
						<span>Kode Referral kamu</span>
						<div class="p-2 bg-light rounded-3 d-flex align-items-center">
							<!-- Input link -->
							<input
								type="text"
								class="form-control border-0 bg-transparent shadow-none"
								:value="`https://ruangai.id/cmref/${data?.leader?.referral_code_comentor}`"
								readonly>

							<!-- Tombol copy -->
							<button
								class="btn btn-sm btn-light ms-2 border-0 d-flex align-items-center gap-1"
								@click="copyToClipboard(data?.leader?.referral_code_comentor)">
								<i class="bi bi-clipboard"></i> Copy Link
							</button>
						</div>
						<!-- <input type="text" class="form-control rounded-3" :value="data?.leader?.referral_code_comentor" placeholder="Kode referral kamu" disabled> -->
					</div>

					<div class="p-3 rounded-4 bg-white d-flex flex-column gap-2 justify-content-between">
						<h5 class="fw-bold">List Referral</h5>
						<div class="table-responsive">
							<table class="w-100 mb-0 text-center align-middle custom-table">
								<thead>
									<tr>
										<th>Nama</th>
										<!-- <th>Email</th> -->
										<th>Whatsapp</th>
										<th>Graduate</th>
										<th>Progres</th>
										<th>Join Live Session</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<template x-for="member in data?.members" :key="member.id">
										<tr>
											<td x-text="member.fullname"></td>
											<!-- <td x-text="member.email"></td> -->
											<td>
												<a :href="`https://wa.me/${member.whatsapp}`" target="_blank" x-text="member.whatsapp"></a>
											</td>
											<td x-text="member.graduate"></td>
											<td x-text="member.progress + '%'"></td>
											<td x-text="member.total_live_session + 'x'"></td>
											<td>
												<template x-if="member.status === 'Lulus'">
													<span class="text-success fw-semibold">✔ Lulus</span>
												</template>
												<template x-if="member.status !== 'Lulus'">
													<span class="text-secondary">✔ Terdaftar</span>
												</template>
											</td>
										</tr>
									</template>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</template>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
	<?= $this->include('comentor/script') ?>
</div>