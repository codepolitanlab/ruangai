<div id="profile" x-data="profile()">
	<div class="appHeader">
		<div class="pageTitle ">
			<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/logo-1.png" width="150" alt="">
		</div>
	</div>

	<!-- App Capsule -->
	<div id="appCapsule" class="shadow">
		<div class="appContent" style="min-height:90vh">
			<section class="mb-5">
				<div class="position-relative">
					<div class="card ps-3 bg-primary shadow-none container-fluid pt-3 pb-3" style="height: 150px;">
						<div class="d-flex align-items-center justify-content-start gap-3">
							<div>
								<img :src="data?.profile?.avatar ? data?.profile?.avatar : `<?= $themeURL ?>assets/img/icon/default-avatar-user.webp`"
									class="rounded-circle"
									:alt="data?.profile?.name"
									style="width:65px">
							</div>
							<div class="text-white">
								<div class="h6 m-0" x-text="data?.profile?.name || 'Badar Abdi Mulya'"></div>
								<small x-text="data?.profile?.username || 'CODING IS A SHINOBI WAYS FOR ME!!!!!'"></small>
							</div>
						</div>
					</div>

					<div class="text-center bg-white rounded-top-5 position-relative p-1" style="margin-top: -40px;z-index: 1">
						<div class="listview-title">
							Personalisasi Akun
						</div>
						<ul class="listview image-listview flush transparent">
							<li>
								<a href="/profile/edit_info" class="item">
									<i class="fs-4 me-2 bi bi-pencil text-primary"></i>
									<span>Edit Profil</span>
								</a>
							</li>
						</ul>

						<div class="listview-title mt-2">
							Akun Anda
						</div>
						<ul class="listview image-listview flush transparent">
							<li>
								<a href="/profile/edit_account" class="item">
									<i class="fs-4 me-2 bi bi-person-vcard text-primary"></i>
									<span>Edit Akun</span>
								</a>
							</li>
						</ul>

						<template x-if="['super','admin'].includes(data?.profile?.role)">
							<div class="bg-success bg-opacity-10">
								<div class="listview-title mt-2">Administrasi PD</div>
								<ul class="listview image-listview flush transparent">
									<li>
										<a href="/admin/list_tagihan" class="item">
											<i class="bi bi-calendar2-check fs-4 text-primary me-2"></i>
											<span>Generate Iuran Anggota</span>
										</a>
									</li>
								</ul>
							</div>
						</template>

						<template x-if="['super','admin','admin-pc'].includes(data?.profile?.role)">
							<div class="bg-info bg-opacity-10">
								<div class="listview-title mt-2">Administrasi PC</div>
								<ul class="listview image-listview flush transparent">
									<li>
										<a href="/allsantri" class="item">
											<i class="bi bi-people-fill fs-4 text-primary me-2"></i>
											<span>Kode Aktivasi Anggota</span>
										</a>
									</li>
									<li>
										<a href="/presensi" class="item">
											<i class="bi bi-calendar2-check-fill fs-4 text-primary me-2"></i>
											<span>Rekap Iuran Anggota</span>
										</a>
									</li>
									<li>
										<a href="/settings" class="item">
											<i class="bi bi-wallet-fill fs-4 text-primary me-2"></i>
											<span>Pencairan</span>
										</a>
									</li>
								</ul>
							</div>
						</template>

						<div class="listview-title mt-2">
							Informasi dan Dukungan
							<!-- <span>v<?= $version; ?></span> -->
						</div>
						<ul class="listview image-listview flush transparent">
							<!-- <li>
								<a href="/page/about-app" class="item">
									<i class="bi bi-info-circle text-primary fs-4 me-2"></i>
									<span>Tentang Aplikasi</span>
								</a>
							</li>
							<li>
								<a href="/page/contact-us" class="item">
									<i class="bi bi-telephone text-primary fs-4 me-2"></i>
									<span>Kontak Kami</span>
								</a>
							</li> -->
							<li>
								<a href="/page/tnc" class="item">
									<i class="bi bi-file-earmark-ruled text-primary fs-4 me-2"></i>
									<span>Syarat dan Ketentuan</span>
								</a>
							</li>
							<li>
								<a href="/page/privacy" class="item">
									<i class="bi bi-shield-exclamation text-primary fs-4 me-2"></i>
									<span>Kebijakan Privasi</span>
								</a>
							</li>
							<!-- <li>
								<a href="/profile/delete" class="item">
									<i class="bi bi-door-closed text-danger fs-4 me-2"></i>
									<span>Tutup Akun</span>
								</a>
							</li>
							<li>
                                <a href="/page/faq" class="item">
                                    <i class="bi bi-patch-question text-primary fs-4 me-2"></i>
                                    <span>Pertanyaan Umum</span>
                                </a>
                            </li> -->
						</ul>

						<div class="listview-title mt-2"></div>
						<ul class="listview image-listview flush transparent border-top">
							<li>
								<a href="javascript:void()" x-on:click="logout" class="item">
									<i class="bi bi-lock text-danger fs-4 me-2"></i>
									<span class="text-danger">Keluar</span>
								</a>
							</li>
						</ul>
					</div>


				</div>
			</section>
		</div>
	</div>
	<!-- * App Capsule -->
	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('profile/script') ?>