<div
	class="header-mobile-only"
	id="course_feedback"
	x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `/courses/feedback/data/${$params.meeting_code}`,
		meta: {
			videoTeaser: null,
		}
    })">

	<style>
		.disabled {
			pointer-events: none;
			opacity: 0.6;
			cursor: not-allowed;
		}

		.lesson-item {
			background-color: #F6F6F6;
		}

		.lesson-item.completed {
			background-color: #7BCC94 !important;
			color: #eee;
		}

		.lesson-item.active.completed {
			border: 0 !important;
		}

		.lesson-item.active {
			border: 2px solid #79B2CD !important;
		}

		.lesson-item.completed h4,
		.lesson-item.completed h5,
		.lesson-item.completed .bi {
			color: #fff !important;
		}

		.bg-warning-2 {
			background-color: #fe9500;
		}
	</style>

	<div id="appCapsule" class="">
		<template x-if="data.meeting">
			<div id="course-features" class="d-flex gap-2 px-3 pt-4 pb-1">
				<a :href="`/courses/intro/${data.course?.id}/${data.course?.slug}/live_session`"
					class="btn rounded-4 px-2"
					:class="data.active_page == 'intro' ? `btn-primary` : `btn-white bg-white text-primary`">
					<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
				</a>
			</div>
		</template>

		<div class="appContent" style="min-height:90vh" x-data="feedback()">

			<template x-if="!data.meeting">
				<div class="card mt-5 mb-4 rounded-4 shadow-none">
					<div class="card-body text-center">
						<p>Form feedback belum tersedia atau tautan salah.</p>
						<a href="/"><i class="bi bi-arrow-left"></i> Kembali</a>
					</div>
				</div>
			</template>

			<template x-if="data.meeting">
				<div class="card mt-2 mb-4 rounded-4 shadow-none">
					<div class="card-body d-flex justify-content-start align-items-center gap-2 px-4 py-3">
						<div>
							<h4 class="h4 fw-normal">Live Session Feedback</h4>
							<p class="text-dark opacity-50 mb-0">Isi form feedback di bawah ini untuk mengonfirmasi kehadiranmu</p>
						</div>
					</div>
				</div>
			</template>

			<template x-if="data.user?.name">
				<div class="card shadow-none">
					<div class="card-body">
						<iframe
							onload="javascript:parent.scrollTo(0,0);"
							height="1002"
							allowTransparency="true"
							scrolling="no"
							frameborder="0"
							sandbox="allow-forms allow-modals allow-orientation-lock allow-pointer-lock allow-popups allow-popups-to-escape-sandbox allow-presentation allow-same-origin allow-scripts allow-top-navigation allow-top-navigation-by-user-activation"
							style="width:100%;border:none"
							:src="`https://form.tarbiyya.id/embed.php?id=14575&element_1=${data.user.name}&element_8=${data.meeting.id}&element_9=${data.meeting.subtitle}&element_7=${data.user.id}`"
							title="RuangaAI Feedback Chapter 2">
							<a href="https://form.tarbiyya.id/view.php?id=14575" title="RuangaAI Feedback Chapter 2">RuangaAI Feedback Chapter 2</a>
						</iframe>
					</div>
				</div>
			</template>

		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('courses/feedback/script') ?>