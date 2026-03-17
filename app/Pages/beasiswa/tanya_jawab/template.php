<div id="tanya_jawab" x-data="tanya_jawab()">

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh;">
			<style>
				#appCapsule {
					padding-top: 0;
				}

				.swiper-slide {
					height: auto !important;
				}

				.card {
					height: 100%;
				}

				.page-banner {
					background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('https://madrasahdigital.id//uploads/madrasahdigital/sources/BG-MD-GD.png');
					background-size: cover;
					background-position: top;
				}

				.course-attr {
					line-height: 18px;
				}
			</style>
			<section>

				<section>
					<div class="p-2">
						<div class="position-relative">
							<img src="https://ik.imagekit.io/56xwze9cy/ruangai/Redesign/Group%205231%20(2).png" class="w-100" alt="">
							<div class="position-absolute start-0 m-2" style="top: 50px;">
								<h5 class="text-white mb-1">RuangAI</h5>
								<div class="text-white">Belajar mandiri secara <br> online dan terarah</div>
							</div>
						</div>

						<div class="d-flex gap-3 mt-3">
							<a href="/courses" class="btn btn-ultra-light-primary w-100 p-3 rounded-pill">
								<div class="m-0 h6 text-primary">Kelas Online</div>
							</a>
							<a href="/courses/tanya_jawab" class="btn btn-primary w-100 p-3 rounded-pill text-white">
								<div class="m-0 h6 text-white">Tanya Jawab</div>
							</a>
						</div>
					</div>
				</section>

				<section>
					<div class="container py-4">
						<template x-for="article in Array(3)">
							<div class="card shadow-none rounded-20 p-2 border mb-2">
								<div class="d-flex justify-content-between">
									<div class="d-flex gap-3 align-items-center">
										<img src="https://cdn-icons-png.flaticon.com/512/8792/8792047.png" class="rounded-circle" style="width: 50px;height: 50px" alt="">
										<div>
											<h5 class="m-0 mb-1">Badar Abdi Mulya</h5>
											<h6 class="m-0">UI & UX Designer - 04 Maret</h6>
										</div>
									</div>
									<div class="d-flex flex-column flex-lg-row align-items-center gap-2">
										<div class="d-flex btn-primary align-items-center justify-content-center h5 m-0 rounded" style="width: 50px;height: 40px">1</div>
										<div class="h6 m-0">Jawaban</div>
									</div>
								</div>
								<div class="card-body d-flex align-items-center gap-lg-2 px-1">
									<a href="/courses/tanya_jawab/1">
										<div class="bg-light rounded-20 p-3 w-100">
											<h5>Tidak dapat menemukan URL Laravel</h5>
											<div class="bg-white p-2 rounded-20 text-muted">
												Ditanyakan di kelas <a href="" class="text-pink">Pengembangan Web Fullstack dengan Laravel 11</a>, Topik <a class="text-pink" href="">Setup kebutuhan untuk install project Laravel</a>
											</div>
										</div>
									</a>
								</div>
							</div>
						</template>
					</div>
				</section>
			</section>
		</div>
	</div>
	<?= $this->include('_bottommenu') ?>
</div>