<div
	class="header-mobile-only"
	id="pdf_viewer"
	x-data="pdfViewer()"
	x-init="init()">

	<style>
		#pdf-container {
			width: 100%;
			background-color: white;
			margin-bottom: 20px;
		}

		#pdf-container canvas {
			display: block;
			margin: 10px auto;
			max-width: 100%;
			height: auto;
		}

		#understand-btn {
			padding: 12px 24px;
			background-color: #007bff;
			color: white;
			border: none;
			border-radius: 8px;
			cursor: not-allowed;
			font-size: 16px;
			font-weight: 500;
			width: 100%;
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
			<div class="mb-3">
				<button @click="history.back()" class="btn rounded-4 px-2 btn-white bg-white text-primary">
					<h6 class="h6 m-0"><i class="bi bi-arrow-left m-0"></i></h6>
				</button>
			</div>

			<div class="bg-white rounded-4 p-3 mb-3">
				<h4 class="mb-3">Modul PDF</h4>
				<div id="pdf-container"></div>
			</div>

			<div class="p-3 mb-4">
				<button id="understand-btn" @click="markPdfRead()" :disabled="!isScrolledToBottom" class="btn rounded-4">Saya sudah paham</button>
			</div>
		</div>
	</div>

	<?= $this->include('_bottommenu') ?>
</div>
<?= $this->include('beasiswa/intro/pdf_viewer/script') ?>