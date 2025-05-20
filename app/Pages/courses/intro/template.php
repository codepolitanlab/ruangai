<div
	class="header-mobile-only"
	id="course_intro"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/courses/intro/data/${$params.course_id}`
    })"
	x-effect="loadPage(`/courses/intro/data/${$params.course_id}`)">

	<?= $this->include('_appHeader'); ?>

	<style>
		.accordion-body {
			padding: 0 .25rem;
		}

		.list-group-item {
			border: 0;
		}

		.accordion-body,
		.accordion-body .list-group-item {
			background: #fff !important;
		}

		.hovered:hover {
			background: #eee !important;
		}

		.cover {
			object-fit: cover;
			width: 100%;
			height: 100%;
		}

		.progress,
		.progress-bar {
			height: 22px;
		}

		.lessons a {
			color: #009688;
			font-weight: 400;
			font-size: 1rem;
		}

		.author img {
			width: 80px;
		}
	</style>

	<div id="appCapsule" class="">
		<div class="appContent" style="min-height:90vh">

			<?= $this->include('courses/intro/_header'); ?>

			<section class="mb-4 mt-3 bg-white p-3 rounded-4">
				<div class="h5 mb-3">Lanjutkan Belajar</div>
				<a href="/courses/lessons/1">
					<div class="card shadow-none bg-light-secondary card-hover rounded-20">
						<div class="card-body d-flex align-items-center gap-3 p-3">
							<div class="d-flex align-items-center justify-content-center rounded-20" style="width: 90px;height: 70px;background: #f5cebb">
								<i class="bi bi-journal-bookmark-fill display-5 text-secondary"></i>
							</div>
							<div class="w-100">
								<h5 class="m-0">Lesson 02 - Pengenalan</h5>
								<div class="mb-1">Potensi Dan Tantangan AI</div>
							</div>
						</div>
					</div>
				</a>
			</section>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>