<div
	class="header-mobile-only"
	id="student"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
		url: `courses/intro/student/data/${$params.course_id}`
    })">

	<?= $this->include('_appHeader'); ?>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh">
			
			<?= $this->include('courses/intro/_header'); ?>

			<section>
				<div class="">
					<div class="d-flex justify-content-between align-items-center">
						<div class="d-flex align-items-center h6">
							<span>Filter</span>
							<button class="btn btn-sm" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas" aria-controls="offcanvasExample">
								<i class="bi bi-sort-alpha-down text-primary"></i>
							</button>
						</div>
						<div class="d-flex align-items-center h6">
							<span>Sort</span>
							<button class="btn btn-sm" data-bs-toggle="offcanvas" data-bs-target="#sortCanvas" aria-controls="offcanvasExample">
								<i class="bi bi-filter text-primary"></i>
							</button>
						</div>
					</div>

					<!-- Student Cards -->
					<template x-for="student in data.students">
						<div class="card shadow-none border rounded-20 p-2 mb-2">
							<div class="d-flex gap-3 align-items-center">
								<div style="width: 100px; height: 150px">
									<img :src="student.avatar" class="cover w-100 rounded" alt="Student">
								</div>
								<div class="flex-grow-1">
									<div class="d-flex justify-content-between align-items-start mb-2">
										<div class="">Enroll : <span x-text="student.joined_at.slice(0, 10)"></span></div>
									</div>
									<h5 class="mb-2">
										<a :href="`/courses/intro/${$params.course_id}/${$params.slug}/student/${student.user_id}`" x-text="student.name"></a>
									</h5>
									<div class="d-flex align-items-center gap-3">
										<div class="progress flex-grow-1" style="height: 8px">
											<div class="progress-bar bg-primary" role="progressbar" style="width: 80%"></div>
										</div>
										<div class="text-primary" style="min-width: 45px">80%</div>
									</div>
								</div>
							</div>
						</div>
					</template>

				</div>
			</section>
		</div>
	</div>

	<!-- Offcanvas share -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="shareCanvas" aria-labelledby="shareCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title" id="shareCanvasLabel">Bagikan Tautan</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body small"></div>
	</div>

	<!-- Offcanvas Filter -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="filterCanvas" aria-labelledby="filterCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h4 class="m-0" id="filterCanvasLabel">Filter</h4>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body small">
			<h5>Nama</h5>
			<div class="d-flex gap-3">
				<button class="btn btn-primary rounded-20">Urutkan Nama A - Z</button>
				<button class="btn btn-primary rounded-20">Urutkan Nama Z - A</button>
			</div>
		</div>
	</div>

	<!-- Offcanvas Sort -->
	<div class="offcanvas offcanvas-bottom" tabindex="-1" id="sortCanvas" aria-labelledby="sortCanvasLabel" style="max-width:768px;margin:0 auto;" aria-modal="true" role="dialog">
		<div class="offcanvas-header">
			<h4 class="m-0" id="sortCanvasLabel">Sort</h4>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body text-white">
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h4 class="m-0">Tanggal Bergabung</h4>
				<input type="radio" class="form-check-input h5" name="sort" id="sortJoin" checked>
			</div>
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h4 class="m-0">Terakhir Online</h4>
				<input type="radio" class="form-check-input h5" name="sort" id="sortOnline">
			</div>
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h4 class="m-0">Progress Belajar</h4>
				<input type="radio" class="form-check-input h5" name="sort" id="sortProgress">
			</div>
		</div>
	</div>
	<?= $this->include('_bottommenu') ?>
</div>