<div id="kelas" x-data="kelas()" class="header-mobile-only rd-page">

	<style>
		#kelas .kl-heading {
			padding: 18px 20px 6px;
		}
		#kelas .kl-title {
			font-size: 1.75rem;
			font-weight: 800;
			color: var(--rd-text);
			line-height: 1.2;
			margin: 0;
		}
		#kelas .appContent { padding-bottom: 120px; }

		/* ===== Terakhir dipelajari ===== */
		#kelas .kl-last-label {
			font-size: 0.95rem;
			font-weight: 700;
			color: var(--rd-text);
			margin-bottom: 10px;
		}
		#kelas .kl-last-card {
			display: flex;
			align-items: center;
			gap: 14px;
			padding: 14px;
			border-radius: 18px;
			text-decoration: none;
			color: inherit;
			background: linear-gradient(135deg, rgba(255, 122, 26, 0.22), rgba(255, 122, 26, 0.06));
			border: 1px solid rgba(255, 122, 26, 0.4);
		}
		#kelas .kl-last-thumb {
			width: 54px;
			height: 54px;
			flex: 0 0 54px;
			border-radius: 14px;
			background-color: rgba(255, 255, 255, 0.1);
			background-size: cover;
			background-position: center;
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--rd-primary);
			font-size: 1.4rem;
		}
		#kelas .kl-last-body { min-width: 0; flex: 1; }
		#kelas .kl-last-cta {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			font-size: 0.95rem;
			font-weight: 700;
			color: var(--rd-primary);
		}
		#kelas .kl-last-course {
			font-size: 0.85rem;
			color: var(--rd-text-muted);
			margin-top: 2px;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		/* ===== Progress bar ===== */
		#kelas .kl-progress-track {
			height: 6px;
			border-radius: 999px;
			background: var(--rd-border);
			overflow: hidden;
			margin-top: 8px;
		}
		#kelas .kl-progress-fill {
			height: 100%;
			border-radius: 999px;
			background: linear-gradient(90deg, var(--rd-primary), var(--rd-primary-hover));
			transition: width 0.5s ease;
		}
		#kelas .kl-last-card .kl-progress-track { background: rgba(255, 255, 255, 0.14); }
		#kelas .kl-last-percent {
			font-size: 0.72rem;
			font-weight: 700;
			color: var(--rd-text-muted);
			margin-top: 4px;
		}

		/* ===== Daftar kelas ===== */
		#kelas .kl-list-title {
			font-size: 0.95rem;
			font-weight: 700;
			color: var(--rd-text);
			margin-bottom: 10px;
		}
		#kelas .kl-list {
			display: flex;
			flex-direction: column;
			gap: 12px;
		}
		#kelas .kl-card {
			display: flex;
			gap: 14px;
			padding: 12px;
			border-radius: 18px;
			background: var(--rd-surface);
			border: 1px solid var(--rd-border);
			text-decoration: none;
			color: inherit;
			transition: border-color 0.15s ease, transform 0.15s ease;
		}
		#kelas .kl-card:hover {
			border-color: var(--rd-primary);
			transform: translateY(-2px);
		}
		#kelas .kl-thumb {
			width: 96px;
			height: 96px;
			flex: 0 0 96px;
			border-radius: 14px;
			background-color: var(--rd-surface-2);
			background-size: cover;
			background-position: center;
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--rd-text-muted);
			font-size: 1.8rem;
			overflow: hidden;
		}
		#kelas .kl-card-body {
			min-width: 0;
			flex: 1;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}
		#kelas .kl-badge {
			align-self: flex-start;
			font-size: 0.68rem;
			font-weight: 700;
			padding: 4px 10px;
			border-radius: 999px;
			border: 1px solid currentColor;
			line-height: 1.2;
			margin-bottom: 8px;
		}
		#kelas .kl-badge-live { color: var(--rd-green); }
		#kelas .kl-badge-online { color: var(--rd-primary); }
		#kelas .kl-card-title {
			font-size: 0.98rem;
			font-weight: 700;
			color: var(--rd-text);
			line-height: 1.3;
		}
		#kelas .kl-card-sub {
			font-size: 0.82rem;
			color: var(--rd-text-muted);
			margin-top: 4px;
		}
		#kelas .kl-card-meta {
			font-size: 0.82rem;
			color: var(--rd-text-muted);
			margin-top: 4px;
			display: flex;
			align-items: center;
			gap: 6px;
		}
		#kelas .kl-card-meta i { color: var(--rd-green); }

		/* ===== Skeleton & empty ===== */
		#kelas .kl-skeleton-card {
			display: flex;
			gap: 14px;
			padding: 12px;
			border-radius: 18px;
			background: var(--rd-surface);
			border: 1px solid var(--rd-border);
			margin-bottom: 12px;
		}
		#kelas .kl-skeleton-thumb {
			width: 96px;
			height: 96px;
			flex: 0 0 96px;
			border-radius: 14px;
			background: var(--rd-surface-2);
		}
		#kelas .kl-skeleton-line {
			height: 12px;
			border-radius: 8px;
			background: var(--rd-surface-2);
			margin-top: 10px;
		}
		#kelas .kl-empty {
			text-align: center;
			padding: 60px 24px;
			color: var(--rd-text-muted);
		}
		#kelas .kl-empty i {
			font-size: 2.6rem;
			display: block;
			margin-bottom: 12px;
			opacity: 0.6;
		}
		#kelas .kl-empty-title {
			font-size: 1rem;
			font-weight: 700;
			color: var(--rd-text);
		}
	</style>

	<!-- Heading -->
	<div class="kl-heading">
		<h1 class="kl-title">Kelas Saya</h1>
	</div>

	<div id="appCapsule">
		<div class="appContent py-3">

			<!-- Skeleton -->
			<template x-if="ui.loading && !(data?.my_courses?.length)">
				<div>
					<template x-for="i in 3" :key="i">
						<div class="kl-skeleton-card">
							<div class="kl-skeleton-thumb"></div>
							<div style="flex:1">
								<div class="kl-skeleton-line" style="width:35%"></div>
								<div class="kl-skeleton-line" style="width:75%"></div>
								<div class="kl-skeleton-line" style="width:50%"></div>
							</div>
						</div>
					</template>
				</div>
			</template>

			<!-- ===== Terakhir dipelajari ===== -->
			<section class="mb-3" x-cloak x-show="data?.last_course">
				<div class="kl-last-label">Terakhir Dipelajari</div>
				<a class="kl-last-card" :href="data?.last_course?.url" @click.prevent="goCourse(data.last_course)">
					<div class="kl-last-thumb"
						:style="data?.last_course?.thumbnail ? `background-image:url('${data.last_course.thumbnail}')` : ''">
						<i class="bi bi-play-circle-fill" x-show="!data?.last_course?.thumbnail"></i>
					</div>
					<div class="kl-last-body">
						<div class="kl-last-cta"><i class="bi bi-play-fill"></i> Lanjutkan Belajar</div>
						<div class="kl-last-course" x-text="data?.last_course?.course_title"></div>
						<div class="kl-progress-track">
							<div class="kl-progress-fill" :style="`width:${data?.last_course?.progress || 0}%`"></div>
						</div>
						<div class="kl-last-percent" x-text="(data?.last_course?.progress || 0) + '% selesai'"></div>
					</div>
				</a>
			</section>

			<!-- ===== Daftar kelas ===== -->
			<section>
				<div class="kl-list-title">Semua Kelas</div>

				<div class="kl-list">
					<template x-for="course in (data?.my_courses || [])" :key="(course.is_live ? 'live' : 'course') + '-' + course.id">
						<a class="kl-card" :href="course.url" @click.prevent="goCourse(course)">
							<div class="kl-thumb"
								:style="course.thumbnail ? `background-image:url('${course.thumbnail}')` : ''">
								<i class="bi bi-mortarboard" x-show="!course.thumbnail"></i>
							</div>
							<div class="kl-card-body">
								<span class="kl-badge"
									:class="course.is_live ? 'kl-badge-live' : 'kl-badge-online'"
									x-text="course.is_live ? 'Live Class' : 'Online Class'"></span>

								<div class="kl-card-title" x-text="course.course_title"></div>

								<!-- Live class: batch + jumlah pertemuan -->
								<template x-if="course.is_live">
									<div>
										<div class="kl-card-sub" x-show="course.batch_name" x-text="course.batch_name"></div>
										<div class="kl-card-meta">
											<i class="bi bi-calendar-event"></i>
											<span x-text="(course.total_materials || 0) + ' pertemuan'"></span>
										</div>
									</div>
								</template>

								<!-- Online course: progres materi -->
								<template x-if="!course.is_live">
									<div>
										<div class="kl-card-meta">
											<i class="bi bi-journal-check" style="color:var(--rd-primary)"></i>
											<span x-text="(course.total_completed || 0) + ' dari ' + (course.total_module || 0) + ' materi selesai'"></span>
										</div>
										<div class="kl-progress-track">
											<div class="kl-progress-fill" :style="`width:${course.progress || 0}%`"></div>
										</div>
									</div>
								</template>
							</div>
						</a>
					</template>
				</div>

				<!-- Empty state -->
				<template x-if="!ui.loading && (data?.my_courses?.length ?? 0) === 0">
					<div class="kl-empty">
						<i class="bi bi-mortarboard"></i>
						<div class="kl-empty-title">Kamu belum memiliki kelas</div>
						<p style="margin:8px 0 0;font-size:0.9rem">Yuk daftar kelas sekarang!</p>
					</div>
				</template>
			</section>

		</div>
	</div>
	<!-- * App Capsule -->

	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('kelas/script') ?>
