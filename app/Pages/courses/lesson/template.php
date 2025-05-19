<div
	class="container-large"
	id="lesson_detail"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `courses/lesson/data/${$params.id}`
    })"
	x-effect="loadPage(`courses/lesson/data/${$params.id}`)">

	<div id="app-header" class="appHeader main border-0">
		<div class="left">
			<a class="headerButton" :href="`/courses/intro/${data.course.id}/${data.course.slug}`"><i class="bi bi-chevron-left"></i></a>
			<span x-text="data.course.course_title"></span>
		</div>
		<div class="pageTitle"></div>
	</div>

	<div id="appCapsule" class="appCapsule-lg">
		<div class="appContent px-0 bg-white rounded-4" style="min-height:95vh">

			<section>
				<!-- If player Youtube -->
				<div x-show="data.lesson?.player == 'youtube'" class="ratio ratio-16x9">
					<iframe width="560" height="315" :src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>

				<!-- If player Bunny -->
				<div x-show="data.lesson?.player == 'bunnystream'" class="ratio ratio-16x9">
					<!-- <iframe width="560" height="315" :src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
				</div>

				<!-- If player Diupload -->
				<div x-show="data.lesson?.player == 'diupload'" class="ratio ratio-16x9">
					<!-- <iframe width="560" height="315" :src="`https://www.youtube.com/embed/${data.lesson?.youtube_id}`" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
				</div>

				<div class="container px-3">
					<div class="mt-4">
						<h2 x-text="data.lesson?.lesson_title"></h2>
						<p class="">Pelajari dasar-dasar Artificial Intelligence (AI), bagaimana cara kerjanya, serta peranannya dalam kehidupan sehari-hari. Kursus ini akan membimbing Anda memahami konsep AI secara sederhana sebelum mendalami topik lebih lanjut di setiap lesson!</p>

						<!-- Action Buttons -->
						<div class="d-flex gap-3 mb-5">
							<!-- <button class="btn btn-ultra-light-primary rounded-pill px-4">
								Forum
							</button> -->
							<a :href="`/courses/lessons/${data.lesson?.next_lesson_id}`" class="btn btn-primary rounded-pill px-4 ms-auto">
								<i class="bi bi-skip-forward-fill me-2"></i>
								Berikutnya
							</a>
						</div>
					</div>
				</div>
			</section>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>