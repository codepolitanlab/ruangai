<script>
  Alpine.data("pdfViewer", function() {
    return {
      isScrolledToBottom: false,
      scrollProgress: 0,
      imageBasePath: '/module-pdf',
      totalImages: 76,
      imagesLoaded: false,

      init() {
        this.setupScrollListener();
        this.loadFancyboxAssets().then(() => {
          if (!this.imagesLoaded) {
            this.imagesLoaded = true;
            this.renderImages();
          }
        });
      },

      loadFancyboxAssets() {
        return new Promise((resolve) => {
          const cssId = 'fancybox-css';
          const jsId = 'fancybox-js';

          const hasCss = document.getElementById(cssId);
          const hasJs = document.getElementById(jsId);

          if (typeof Fancybox !== 'undefined' && hasCss && hasJs) {
            resolve();
            return;
          }

          if (!hasCss) {
            const css = document.createElement('link');
            css.id = cssId;
            css.rel = 'stylesheet';
            css.href = 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css';
            document.head.appendChild(css);
          }

          if (!hasJs) {
            const script = document.createElement('script');
            script.id = jsId;
            script.src = 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js';
            script.onload = () => {
              resolve();
            };
            document.head.appendChild(script);
          } else {
            const checkFancybox = () => {
              if (typeof Fancybox !== 'undefined') {
                resolve();
              } else {
                requestAnimationFrame(checkFancybox);
              }
            };
            checkFancybox();
          }
        });
      },

      renderImages() {
        const container = document.getElementById('pdf-container');
        container.innerHTML = '';

        for (let index = 1; index <= this.totalImages; index++) {
          const imagePath = `${this.imageBasePath}/${index}.png`;

          const link = document.createElement('a');
          link.href = imagePath;
          link.className = 'pdf-image-link';
          link.setAttribute('data-fancybox', 'module-images');
          link.setAttribute('data-caption', `Halaman ${index}`);

          const image = document.createElement('img');
          image.src = imagePath;
          image.alt = `Modul halaman ${index}`;
          image.className = 'pdf-image';
          image.loading = 'lazy';

          image.onerror = () => {
            link.remove();
          };

          link.appendChild(image);
          container.appendChild(link);
        }

        if (typeof Fancybox !== 'undefined') {
          Fancybox.bind('[data-fancybox="module-images"]', {
            dragToClose: false,
            Toolbar: {
              display: {
                left: ['infobar'],
                middle: [],
                right: ['zoomIn', 'zoomOut', 'toggle1to1', 'close']
              }
            }
          });
        } else {
          container.innerHTML = '<p class="p-3 text-danger">Gagal memuat fitur zoom gambar. Silakan refresh halaman.</p>';
        }
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
            $heroicHelper.toastr("Modul berhasil ditandai sebagai telah dibaca", "success", "bottom");
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