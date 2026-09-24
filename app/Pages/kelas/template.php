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

		/* ===== Kelas yang bisa diikuti ===== */
		#kelas .kl-section-gap { margin-top: 26px; }
		#kelas .kl-sub-label {
			font-size: 0.78rem;
			font-weight: 700;
			letter-spacing: 0.02em;
			text-transform: uppercase;
			color: var(--rd-text-muted);
			margin: 0 0 8px 2px;
		}
		#kelas .kl-sub-group + .kl-sub-group { margin-top: 16px; }
		#kelas .kl-card--static { cursor: default; }
		#kelas .kl-card--static:hover {
			transform: none;
			border-color: var(--rd-border);
		}
		#kelas .kl-card-desc {
			font-size: 0.82rem;
			color: var(--rd-text-muted);
			margin-top: 6px;
			display: -webkit-box;
			line-clamp: 2;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}
		#kelas .kl-card-foot {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			gap: 10px;
			margin-top: 10px;
		}
		#kelas .kl-join-btn {
			border: none;
			border-radius: 999px;
			padding: 8px 18px;
			font-size: 0.82rem;
			font-weight: 700;
			color: #fff;
			background: linear-gradient(90deg, var(--rd-primary), var(--rd-primary-hover));
			display: inline-flex;
			align-items: center;
			gap: 6px;
			white-space: nowrap;
		}
		#kelas .kl-join-btn:disabled { opacity: 0.7; }
		#kelas .kl-avail-cta {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			font-size: 0.85rem;
			font-weight: 700;
			color: var(--rd-primary);
			margin-top: 8px;
		}

		/* ===== Modal kode akses kelas ===== */
		#kelas .kl-modal-overlay {
			position: fixed;
			inset: 0;
			z-index: 1050;
			background: rgba(2, 13, 28, 0.7);
			display: flex;
			align-items: flex-end;
			justify-content: center;
		}
		#kelas .kl-modal-sheet {
			width: 100%;
			max-width: 480px;
			background: var(--rd-surface);
			border: 1px solid var(--rd-border);
			border-radius: 22px 22px 0 0;
			padding: 20px 20px 28px;
		}
		#kelas .kl-modal-head {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 14px;
		}
		#kelas .kl-modal-title {
			font-size: 1.2rem;
			font-weight: 700;
			color: var(--rd-text);
		}
		#kelas .kl-modal-close {
			border: none;
			background: none;
			font-size: 1.4rem;
			color: var(--rd-text-muted);
			line-height: 1;
		}
		#kelas .kl-modal-desc {
			margin: 0 0 14px;
			color: var(--rd-text-muted);
			font-size: 0.92rem;
		}
		#kelas .kl-code-input {
			border: 1.5px solid var(--rd-border);
			border-radius: 999px;
			padding: 14px 20px;
			font-size: 1.05rem;
			font-weight: 600;
			text-align: center;
			letter-spacing: 0.3em;
			text-transform: uppercase;
			width: 100%;
			background: var(--rd-surface-2);
			color: var(--rd-text);
			outline: none;
		}
		#kelas .kl-code-input:focus { border-color: var(--rd-primary); }
		#kelas .kl-submit-btn {
			border: none;
			border-radius: 999px;
			padding: 14px;
			font-size: 1rem;
			font-weight: 700;
			width: 100%;
			margin-top: 14px;
			color: #fff;
			background: linear-gradient(90deg, var(--rd-primary), var(--rd-primary-hover));
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
		}
		#kelas .kl-submit-btn:disabled { opacity: 0.7; }

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

			<!-- ===== Bootcamp yang sedang berlangsung (yang saya ikuti) ===== -->
			<section x-cloak x-show="(data?.my_bootcamps?.length ?? 0) > 0">
				<div class="kl-list-title">Bootcamp yang Sedang Berlangsung</div>

				<div class="kl-list">
					<template x-for="bootcamp in data.my_bootcamps" :key="'my-bootcamp-' + bootcamp.id">
						<a class="kl-card" :href="bootcamp.url" @click.prevent="goCourse(bootcamp)">
							<div class="kl-thumb"
								:style="bootcamp.thumbnail ? `background-image:url('${bootcamp.thumbnail}')` : ''">
								<i class="bi bi-mortarboard" x-show="!bootcamp.thumbnail"></i>
							</div>
							<div class="kl-card-body">
								<span class="kl-badge kl-badge-live">Live Class</span>

								<div class="kl-card-title" x-text="bootcamp.course_title"></div>

								<div class="kl-card-sub" x-show="bootcamp.batch_name" x-text="bootcamp.batch_name"></div>

								<div class="kl-card-meta">
									<i class="bi bi-calendar-event"></i>
									<span x-text="(bootcamp.total_materials || 0) + ' pertemuan'"></span>
								</div>
							</div>
						</a>
					</template>
				</div>
			</section>

			<!-- ===== Kelas Saya (kursus online) ===== -->
			<section class="kl-section-gap">
				<div class="kl-list-title">Kelas Saya</div>

				<div class="kl-list" x-show="(data?.my_courses?.length ?? 0) > 0">
					<template x-for="course in data.my_courses" :key="'my-course-' + course.id">
						<a class="kl-card" :href="course.url" @click.prevent="goCourse(course)">
							<div class="kl-thumb"
								:style="course.thumbnail ? `background-image:url('${course.thumbnail}')` : ''">
								<i class="bi bi-mortarboard" x-show="!course.thumbnail"></i>
							</div>
							<div class="kl-card-body">
								<span class="kl-badge kl-badge-online">Online Class</span>

								<div class="kl-card-title" x-text="course.course_title"></div>

								<div class="kl-card-meta">
									<i class="bi bi-journal-check" style="color:var(--rd-primary)"></i>
									<span x-text="(course.total_completed || 0) + ' dari ' + (course.total_module || 0) + ' materi selesai'"></span>
								</div>
								<div class="kl-progress-track">
									<div class="kl-progress-fill" :style="`width:${course.progress || 0}%`"></div>
								</div>
							</div>
						</a>
					</template>
				</div>

				<!-- Empty state (belum punya kelas sama sekali / belum ada kursus online) -->
				<template x-if="!ui.loading && (data?.my_courses?.length ?? 0) === 0">
					<div class="kl-empty">
						<i class="bi bi-mortarboard"></i>
						<div class="kl-empty-title"
							x-text="(data?.my_bootcamps?.length ?? 0) > 0 ? 'Belum ada kursus online' : 'Kamu belum memiliki kelas'"></div>
						<p style="margin:8px 0 0;font-size:0.9rem" x-show="(data?.my_bootcamps?.length ?? 0) === 0">Yuk daftar kelas sekarang!</p>
					</div>
				</template>
			</section>

			<!-- ===== Kelas lainnya (bootcamp & kursus online) ===== -->
			<section class="kl-section-gap" x-cloak
				x-show="(data?.available_bootcamps?.length ?? 0) > 0 || (data?.available_courses?.length ?? 0) > 0">
				<div class="kl-list-title">Kelas Lainnya</div>

				<!-- Bootcamp -->
				<template x-if="(data?.available_bootcamps?.length ?? 0) > 0">
					<div class="kl-sub-group">
						<div class="kl-sub-label">Bootcamp</div>
						<div class="kl-list">
							<template x-for="bootcamp in data.available_bootcamps" :key="'bootcamp-' + bootcamp.id">
								<div class="kl-card kl-card--static">
									<div class="kl-thumb"
										:style="bootcamp.thumbnail ? `background-image:url('${bootcamp.thumbnail}')` : ''">
										<i class="bi bi-mortarboard" x-show="!bootcamp.thumbnail"></i>
									</div>
									<div class="kl-card-body">
										<span class="kl-badge kl-badge-live">Bootcamp</span>

										<div class="kl-card-title" x-text="bootcamp.title"></div>

										<div class="kl-card-sub" x-show="bootcamp.syllabus_name" x-text="bootcamp.syllabus_name"></div>

										<div class="kl-card-meta" x-show="bootcamp.start_date">
											<i class="bi bi-calendar-event"></i>
											<span x-text="$heroicHelper.formatDate(bootcamp.start_date)"></span>
										</div>
										<div class="kl-card-meta">
											<i class="bi bi-collection"></i>
											<span x-text="(bootcamp.total_materials || 0) + ' pertemuan'"></span>
										</div>

										<div class="kl-card-foot">
											<button type="button" class="kl-join-btn" @click="openRedeem()">
												<i class="bi bi-key"></i> Daftar
											</button>
										</div>
									</div>
								</div>
							</template>
						</div>
					</div>
				</template>

				<!-- Kursus online -->
				<template x-if="(data?.available_courses?.length ?? 0) > 0">
					<div class="kl-sub-group mt-3">
						<div class="kl-sub-label">Kursus Online</div>
						<div class="kl-list">
							<template x-for="course in data.available_courses" :key="'available-' + course.id">
								<a class="kl-card" :href="course.url" @click.prevent="goCourse(course)">
									<div class="kl-thumb"
										:style="course.thumbnail ? `background-image:url('${course.thumbnail}')` : ''">
										<i class="bi bi-mortarboard" x-show="!course.thumbnail"></i>
									</div>
									<div class="kl-card-body">
										<span class="kl-badge kl-badge-online">Online Class</span>
										<div class="kl-card-title" x-text="course.course_title"></div>
										<div class="kl-card-desc" x-show="course.description" x-text="course.description"></div>
										<div class="kl-avail-cta">
											<i class="bi bi-box-arrow-up-right"></i> Lihat Kelas
										</div>
									</div>
								</a>
							</template>
						</div>
					</div>
				</template>
			</section>

		</div>
	</div>
	<!-- * App Capsule -->

	<!-- Modal Kode Akses Kelas -->
	<div class="kl-modal-overlay" x-show="showModal" x-cloak x-transition.opacity @click="showModal = false" @keydown.escape.window="showModal = false">
		<div class="kl-modal-sheet" @click.stop>
			<div class="kl-modal-head">
				<div class="kl-modal-title">Kode Akses Kelas</div>
				<button type="button" class="kl-modal-close" @click="showModal = false">&times;</button>
			</div>
			<p class="kl-modal-desc">
				Masukkan kode akses yang Anda terima untuk bergabung ke kelas bootcamp.
			</p>
			<input type="text" class="kl-code-input" x-model="code" placeholder="XXXX-XXXX" maxlength="20"
				autocomplete="off" autocapitalize="characters" @keydown.enter="redeem()">
			<button type="button" class="kl-submit-btn" :disabled="redeeming" @click="redeem()">
				<span x-show="redeeming" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
				<i x-show="!redeeming" class="bi bi-check2-circle"></i>
				Gunakan Kode
			</button>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('kelas/script') ?>
