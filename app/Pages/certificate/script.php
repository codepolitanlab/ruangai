<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>
    // Font loading dengan Promise
    function loadFonts() {
        return Promise.all([
            new Promise((resolve) => {
                const script = document.createElement('script');
                script.src = '/fonts/Ubuntu/Ubuntu-Regular-normal.js';
                script.onload = resolve;
                script.onerror = resolve; // Tetap resolve meski gagal
                document.head.appendChild(script);
            }),
            new Promise((resolve) => {
                const script = document.createElement('script');
                script.src = '/fonts/Ubuntu/Ubuntu-Bold-bold.js';
                script.onload = resolve;
                script.onerror = resolve;
                document.head.appendChild(script);
            }),
            new Promise((resolve) => {
                const script = document.createElement('script');
                script.src = '/fonts/Ubuntu/Ubuntu-Medium-medium.js';
                script.onload = resolve;
                script.onerror = resolve;
                document.head.appendChild(script);
            })
        ]);
    }

    // Fungsi untuk menunggu semua libraries siap
    function waitForLibraries() {
        return new Promise((resolve) => {
            const checkLibraries = () => {
                if (window.jspdf && window.QRCode && window.pdfjsLib) {
                    resolve();
                } else {
                    setTimeout(checkLibraries, 100);
                }
            };
            checkLibraries();
        });
    }

    Alpine.data('render_certificate', function() {
        return {
            _currentBlobUrl: null,
            _isLoading: false,
            _fontsLoaded: false,

            init() {
                this.$watch('data', (newData) => {
                    if (newData?.status === 'failed') {
                        this.$router.navigate('/notfound');
                    }

                    if (!newData?.is_feedback) {
                        this.$router.navigate(`/courses/claim_certificate/${newData?.claimer?.entity_id}`);
                    }
                });
                
                // Preload fonts saat init
                this.loadFonts();
            },

            async loadFonts() {
                if (!this._fontsLoaded) {
                    try {
                        await loadFonts();
                        this._fontsLoaded = true;
                    } catch (error) {
                        console.warn('Some fonts failed to load:', error);
                        this._fontsLoaded = true; // Continue anyway
                    }
                }
            },

            async makeQrDataUrl(text, qrCfg) {
                return await QRCode.toDataURL(text, {
                    width: 768,
                    margin: 2,
                    errorCorrectionLevel: qrCfg.ecl || 'M',
                    color: {
                        dark: qrCfg.dark || '#000000',
                        light: qrCfg.light || '#ffffff'
                    }
                });
            },

            async buildPdf() {
                // Pastikan semua library dan font sudah dimuat
                await waitForLibraries();
                await this.loadFonts();

                if (!this.data?.certificate) {
                    throw new Error('Konfigurasi certificate tidak tersedia');
                }

                const { jsPDF } = window.jspdf;
                const certCfg = this.data.certificate;
                const pageSize = certCfg.page || { w: 297, h: 210 };
                const pages = certCfg.pages || [];
                const qrCfg = certCfg.qr;

                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [pageSize.w, pageSize.h]
                });

                // Data mapping global
                const map = {
                    url: this.data.claimer.url ?? '',
                    name: this.data.claimer.name ?? '',
                    course: this.data.claimer.course ?? '',
                    publishDate: this.data.claimer.publishDate ?? '',
                    expiredDate: `${this.data.claimer.expiredDate ?? ''}`,
                    code: `No: ${this.data.claimer.number ?? ''}`,
                };

                // Pre-build QR (pakai sama di semua halaman; bisa override per halaman kalau mau)
                let qrDataUrl = null;
                if (qrCfg) {
                    qrDataUrl = await this.makeQrDataUrl(map.url, qrCfg);
                }

                for (let i = 0; i < pages.length; i++) {
                    const p = pages[i];
                    if (i > 0) {
                        doc.addPage([pageSize.w, pageSize.h], 'landscape');
                    }

                    // Background
                    const bgImg = await loadImage(p.bg);
                    doc.addImage(bgImg, 'JPEG', 0, 0, pageSize.w, pageSize.h, undefined, 'FAST');

                    // QR (optional)
                    if (qrCfg && qrDataUrl && (p.show_qr ?? true)) {
                        const qrSize = qrCfg.sizeMm;
                        const qrX = (pageSize.w * (qrCfg.xPct / 100)) - (qrSize / 2);
                        const qrY = (pageSize.h * (qrCfg.yPct / 100)) - (qrSize / 2);
                        doc.addImage(qrDataUrl, 'PNG', qrX, qrY, qrSize, qrSize);
                    }

                    // Text positions
                    const positions = p.positions || {};
                    for (const key of Object.keys(positions)) {
                        const cfg = positions[key];
                        let txt = map[key] ?? '';
                        txt = cfg.prefix + txt;
                        if (!txt) continue;

                        const x = pctToMm(cfg.xPct, pageSize.w);
                        const y = pctToMm(cfg.yPct, pageSize.h);
                        const maxW = pctToMm(cfg.maxWidthPct, pageSize.w);

                        doc.setFont('Ubuntu', cfg.weight || 'normal');
                        if (cfg.color) doc.setTextColor(cfg.color);
                        else doc.setTextColor('#000000');

                        let fontMm = cfg.fontMm;
                        if (cfg.autoshrink) {
                            fontMm = fitTextSizeByWidth(doc, txt, maxW, cfg.fontMm, cfg.minFontMm || cfg.fontMm);
                        }
                        doc.setFontSize(mmToPt(fontMm));

                        doc.text(txt, x, y, {
                            align: (cfg.align || 'left'),
                            maxWidth: maxW
                        });
                    }
                }

                return {
                    doc,
                    filename: (this.data.claimer.code || 'sertifikat') + '.pdf'
                };
            },

            async previewPDF() {
                if (this._isLoading) return;
                
                this._isLoading = true;
                const container = document.getElementById('pdf-pages');
                
                try {
                    // Show loading state
                    container.innerHTML = '<div style="padding: 60px; text-align: center; color: #666;"><div style="font-size: 18px;">Memuat sertifikat...</div><div style="margin-top: 10px; font-size: 14px;">Sedang mempersiapkan dokumen PDF</div></div>';
                    
                    const { doc } = await this.buildPdf();
                    const blob = doc.output('blob');
                    const url = URL.createObjectURL(blob);
                    
                    // Clean up previous blob
                    if (this._currentBlobUrl) {
                        URL.revokeObjectURL(this._currentBlobUrl);
                    }
                    this._currentBlobUrl = url;
                    
                    await showPdfMulti(url);
                } catch (error) {
                    console.error('Error generating PDF:', error);
                    container.innerHTML = '<div style="padding: 60px; text-align: center; color: #d33;"><div style="font-size: 18px;">Gagal memuat sertifikat</div><div style="margin-top: 10px; font-size: 14px;">Silakan refresh halaman dan coba lagi</div></div>';
                } finally {
                    this._isLoading = false;
                }
            },

            async downloadPDF() {
                try {
                    const { doc, filename } = await this.buildPdf();
                    doc.save(filename);
                } catch (error) {
                    console.error('Error downloading PDF:', error);
                    alert('Gagal mengunduh sertifikat. Silakan coba lagi.');
                }
            }
        }
    });

    // Utilities
    function loadImage(src) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = reject;
            img.src = src;
        });
    }

    function mmToPt(mm) {
        return mm / 25.4 * 72;
    }

    function pctToMm(pct, full) {
        return full * (pct / 100);
    }

    function fitTextSizeByWidth(doc, text, targetWidthMm, baseFontMm, minFontMm) {
        let sizeMm = baseFontMm;
        doc.setFontSize(mmToPt(sizeMm));
        let wPt = doc.getTextWidth(text);
        let wMm = wPt * 25.4 / 72;
        while (wMm > targetWidthMm && sizeMm > minFontMm) {
            sizeMm -= 0.2;
            doc.setFontSize(mmToPt(sizeMm));
            wPt = doc.getTextWidth(text);
            wMm = wPt * 25.4 / 72;
        }
        return sizeMm;
    }

    async function showPdfMulti(blobUrl) {
        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

        const loadingTask = pdfjsLib.getDocument(blobUrl);
        const pdf = await loadingTask.promise;

        const container = document.getElementById('pdf-pages');
        container.innerHTML = ''; // clear

        const scale = 1.5;

        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            const page = await pdf.getPage(pageNum);
            const viewport = page.getViewport({ scale });

            const canvas = document.createElement('canvas');
            canvas.style.display = 'block';
            canvas.classList.add('shadow');
            canvas.style.width = '100%';
            canvas.style.marginBottom = '16px';

            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            container.appendChild(canvas);

            await page.render({
                canvasContext: context,
                viewport
            }).promise;
        }
    }
</script>