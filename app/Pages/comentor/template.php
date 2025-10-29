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
			background-color: #ecba73ff;
		}

		.bg-primary-2 {
			background-color: #e6f1f6;
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
			color: #fff !important;
		}

		/* .custom-table tbody tr:nth-child(odd) {
			background-color: #e6f1f6 !important;
		} */

		/* .custom-table tbody tr:nth-child(even) {
			background-color: #f9f9f9 !important;
		} */

		.custom-table th,
		.custom-table td {
			vertical-align: middle;
		}

		.custom-table {
			border-radius: 12px;
			overflow: hidden;
		}

		.custom-table th,
		.custom-table td {
			padding: 12px 16px;
			/* atas-bawah 12px, kiri-kanan 16px */
		}

		@media (min-width: 992px) {
			#appCapsule {
				max-width: 1100px;
			}

			.appContent {
				margin-left: 200px;
			}
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
						<div class="d-flex flex-column flex-md-row gap-2 mb-3">
							<!-- Card Total Invite -->
							<div class="flex-fill p-3 rounded-4 d-flex align-items-center justify-content-between" style="background-color: #FFE8E1;">
								<div class="d-flex align-items-center gap-2">
									<div class="p-3 rounded-3 d-flex align-items-center justify-content-center" style="background-color: #FDD6C9; width:60px; height:60px;">
										<i class="bi bi-people-fill fs-3 text-secondary"></i>
									</div>
									<div>
										<div>Total Peserta</div>
										<div class="fw-bold fs-5 text-secondary" x-text="data?.total_member ?? 0">0</div>
									</div>
								</div>
							</div>

							<!-- Card Total Lulus -->
							<div class="flex-fill p-3 rounded-4 d-flex align-items-center justify-content-between" style="background-color: #DCFCE6;">
								<div class="d-flex align-items-center gap-2">
									<div class="p-3 rounded-3 d-flex align-items-center justify-content-center" style="background-color: #B9F8CF; width:60px; height:60px;">
										<i class="bi bi-person-check-fill fs-3 text-success"></i>
									</div>
									<div>
										<div>Total Peserta Tuntas</div>
										<div class="fw-bold fs-5 text-success" x-text="data?.total_graduated ?? 0">0</div>
									</div>
								</div>
							</div>
						</div>
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
					</div>

					<div class="p-3 rounded-4 bg-white d-flex flex-column gap-2 justify-content-between">
						<h5 class="fw-bold">Daftar Peserta</h5>
						<div class="mb-2">
							<input
								type="text"
								class="form-control"
								placeholder="Cari peserta..."
								x-model="search">
						</div>

						<div class="table-responsive">
							<div class="d-flex gap-3 mb-3">
								<div class="d-flex align-items-center gap-2">
									<div style="width: 20px;height: 13px;background-color: #ecba73ff;"></div>
									<span>Peserta Lama</span>
								</div>
								<div class="d-flex align-items-center gap-2">
									<div style="width: 20px;height: 13px;background-color: #e6f1f6;"></div>
									<span>Peserta Baru</span>
								</div>
								<div class="ms-auto d-flex align-items-center gap-2">
									<label for="sort" class="mb-0">Urutkan:</label>
									<select id="sort" class="form-select form-select-sm w-auto" x-model="sortOrder" @change="sortMembers">
										<option value="desc">Terbaru</option>
										<option value="asc">Terlama</option>
									</select>
									<button @click="downloadCSV" class="btn btn-sm btn-outline-primary">
										<i class="bi bi-download"></i> Unduh Data
									</button>
								</div>
							</div>
							<table class="w-100 mb-0 align-middle custom-table">
								<thead>
									<tr>
										<th>Nama</th>
										<th class="d-none d-md-table-cell">Email</th>
										<th>Status & Progres</th>
									</tr>
								</thead>
								<tbody>
									<template x-for="member in filteredMembers" :key="member.user_id">
										<tr :class="member.from == 'mapping' ? 'bg-warning-2' : 'bg-primary-2'">
											<td>
												<div class="fw-semibold" x-text="member.fullname"></div>
												<a :href="`https://wa.me/${member.whatsapp}`"
													target="_blank"
													class="small"
													x-text="member.whatsapp"></a>
												<div class="d-block d-md-none" x-text="member.email"></div>
											</td>
											<td class="d-none d-md-table-cell">
												<span x-text="member.email"></span>
											</td>
											<td>
												<!-- badge status -->
												<div class="mb-1">
													<template x-if="member.graduate == 1">
														<span class="badge bg-success fw-semibold">Tuntas</span>
													</template>
													<template x-if="member.progress == 100 && member.total_live_session >= 1 && member.graduate != 1">
														<span class="badge bg-secondary fw-semibold">Belum Klaim Sertifikat</span>
													</template>
													<template x-if="member.progress == 100 && member.total_live_session == 0 && member.graduate != 1">
														<span class="badge bg-warning fw-semibold">Belum Live</span>
													</template>
													<template x-if="member.progress != 100 && member.total_live_session >= 1 && member.graduate != 1">
														<span class="badge bg-warning fw-semibold">Belum Course</span>
													</template>
													<template x-if="member.progress < 100 && member.total_live_session == 0 && member.graduate != 1">
														<span class="badge bg-secondary-subtle text-dark fw-semibold">Masih Belajar</span>
													</template>
												</div>

												<!-- statistik progres -->
												<div class="d-flex align-items-center gap-2 text-muted small">
													<span><i class="bi bi-journal-bookmark text-success"></i> <span x-text="member.progress + '%'"></span></span>
													<span><i class="bi bi-broadcast text-danger"></i> <span x-text="member.total_live_session + 'x'"></span></span>
												</div>
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