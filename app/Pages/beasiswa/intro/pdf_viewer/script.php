<script>
  Alpine.data("pdfViewer", function() {
    return {
      isScrolledToBottom: false,
      scrollProgress: 0,
      pdfUrl: '/pdf/Modul Belajar Dasar dan Penggunaan Kecerdasan Buatan - RuangAI.pdf',
      pdfLoaded: false,

      init() {
        this.setupScrollListener();
        this.loadPdfJs().then(() => {
          if (!this.pdfLoaded) {
            this.pdfLoaded = true;
            this.loadPdf();
          }
        });
      },

      loadPdfJs() {
        return new Promise((resolve) => {
          if (typeof pdfjsLib !== 'undefined') {
            resolve();
            return;
          }
          const script = document.createElement('script');
          // ← Ganti ke cdnjs
          script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
          script.onload = () => {
            // ← Worker dari cdnjs juga, versi harus sama
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
            resolve();
          };
          document.head.appendChild(script);
        });
      },

      loadPdf() {
        const url = this.pdfUrl;
        const container = document.getElementById('pdf-container');

        // Clear container sebelum render
        container.innerHTML = '';

        pdfjsLib.getDocument(url).promise.then((pdf) => {
          let renderedPages = 0;
          const totalPages = pdf.numPages;

          const renderPage = (pageNum) => {
            pdf.getPage(pageNum).then((page) => {
              const containerWidth = container.clientWidth;

              // Hitung scale otomatis berdasarkan lebar container
              const viewport = page.getViewport({ scale: 1 });
              const scale = containerWidth / viewport.width;
              const scaledViewport = page.getViewport({ scale: scale });

              const canvas = document.createElement('canvas');
              const context = canvas.getContext('2d');
              canvas.height = scaledViewport.height;
              canvas.width = scaledViewport.width;

              // Biar canvas responsive
              canvas.style.width = '100%';
              canvas.style.display = 'block';
              canvas.style.marginBottom = '4px';

              page.render({ canvasContext: context, viewport: scaledViewport }).promise.then(() => {
                container.appendChild(canvas);
                renderedPages++;
                if (renderedPages < totalPages) {
                  renderPage(pageNum + 1);
                }
              });
            });
          };

          renderPage(1);
        }).catch((error) => {
          console.error('Error loading PDF:', error);
          container.innerHTML = '<p class="p-3 text-danger">Error loading PDF. Please try again.</p>';
        });
        },

      setupScrollListener() {
        window.addEventListener('scroll', () => {
          const scrollTop = window.scrollY;
          const docHeight = document.documentElement.scrollHeight;
          const winHeight = window.innerHeight;
          const totalScroll = docHeight - winHeight;

          // Calculate scroll progress percentage
          this.scrollProgress = totalScroll > 0 ? Math.round((scrollTop / totalScroll) * 100) : 0;

          this.isScrolledToBottom = (scrollTop + winHeight >= docHeight - 50);
        });
      },

      async markPdfRead() {
        if (!this.isScrolledToBottom) return;

        try {
          const token = localStorage.getItem('heroic_token');
          const response = await fetch('/beasiswa/intro/markPdfRead', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify({})
          });

          const data = await response.json();
          if (data.response_code === 200) {
            $heroicHelper.toastr("Modul PDF berhasil ditandai sebagai telah dibaca", "success", "bottom");
            setTimeout(() => {
              window.location.href = '/beasiswa/intro';
            }, 1000);
          } else {
            $heroicHelper.toastr("Error: " + (data.response_message || 'Unknown error'), "error", "bottom");
          }
        } catch (err) {
          console.error('Error marking as read:', err);
          $heroicHelper.toastr("Error: " + err.message, "error", "bottom");
        }
      }
    };
  });
</script>