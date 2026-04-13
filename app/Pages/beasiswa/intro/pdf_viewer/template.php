<div
	class="header-mobile-only"
	id="pdf_viewer"
	x-data="pdfViewer()"
	x-init="init()">

	<style>
		#appCapsule {
			max-width: 780px !important;
		}
		@media (max-width: 768px) {
			#appCapsule {
				max-width: 100% !important;
			}
		}

		#pdf-progress-bar {
			position: absolute;
			top: 0;
			left: 0;
			height: 5px;
			background-color: #79b2cd;
			z-index: 1000;
			transition: width 0.1s ease;
		}

		#pdf-container {
			width: 100%;
			background-color: white;
			margin-bottom: 20px;
		}

		#pdf-container .pdf-image-link {
			display: block;
			margin: 0;
			text-decoration: none;
		}

		#pdf-container .pdf-image {
			display: block;
			margin: 10px auto;
			max-width: 100%;
			height: auto;
			border-radius: 8px;
		}

		#understand-btn-container {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			padding: 20px 20px 15px;
			background-color: white;
			box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
			margin: 0;
			text-align: center;
			z-index: 1000;
		}
		
		#understand-btn {
			padding: 12px 24px;
			background-color: #007bff;
			color: white;
			border: none;
			border-radius: 8px;
			font-size: 16px;
			font-weight: 500;
			width: 100%;
			max-width: 400px;
			margin: 0 auto;
			transition: all 0.3s ease;
		}

		#understand-btn:disabled {
			background-color: #ccc;
			opacity: 0.6;
		}

		#understand-btn.enabled {
			cursor: pointer;
			background-color: #0056b3;
		}

		#understand-btn.enabled:hover {
			background-color: #003a99;
			transform: translateY(-2px);
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		}
	</style>

	<div id="appCapsule">
		<div class="appContent py-4">
			<div class="mb-3 d-flex align-items-center gap-3">
				<button @click="history.back()" class="btn rounded-4 px-2 btn-white bg-white text-primary">
					<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
				</button>
				<h4 class="m-0">Modul</h4>
			</div>

			<div class="bg-white rounded-4 p-3 mb-3">
				<div id="pdf-container"></div>
			</div>

			<div id="understand-btn-container">
				<div id="pdf-progress-bar" :style="`width: ${scrollProgress}%`"></div>

				<span @click="!isScrolledToBottom && $heroicHelper.toastr('Baca modul sampai slide terakhir terlebih dahulu', 'warning', 'bottom')" style="display:inline-block; width:100%">
					<button id="understand-btn" @click="markPdfRead()" :disabled="!isScrolledToBottom" class="btn btn-primary hover rounded-pill p-1 fs-6">Saya sudah paham</button>
				</span>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('beasiswa/intro/pdf_viewer/script') ?>