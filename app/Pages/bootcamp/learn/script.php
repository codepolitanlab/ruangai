<script>
    Alpine.data('bootcamp_learn', function (classId) {
        let base = $heroic({
            title: 'Belajar Bootcamp',
            url: `/bootcamp/learn/data/${classId}`,
        });

        return {
            ...base,
            classId,
            tab: 'materi',
            openMaterials: {},
            openResources: {},
            activeResource: null,
            activeCm: null,
            modalOpen: false,
            progressSubmitting: {},
            submitSubmitting: {},
            submitFiles: {},
            submitUrls: {},
            topicClaiming: {},
            feedbackSubmitting: false,
            claiming: false,
            feedback: {
                profession: '',
                city: '',
                condition_before: '',
                condition_before_other: '',
                reason_choice: '',
                favorite_moment: '',
                rating: 0,
                concrete_skill: '',
                message_to_friend: '',
                allow_testimonial: false,
            },
            feedbackFields: [
                { key: 'profession', label: 'Profesi Anda saat ini', placeholder: 'cth: Mahasiswa, Web Developer, Guru...' },
                { key: 'city', label: 'Kota domisili', placeholder: 'cth: Jakarta' },
                { key: 'condition_before', label: 'Kondisi Anda sebelum mengikuti bootcamp' },
                { key: 'condition_before_other', label: 'Jika memilih "Lainnya", jelaskan' },
                { key: 'reason_choice', label: 'Alasan mengikuti bootcamp ini', placeholder: 'Tuliskan alasan Anda...' },
                { key: 'favorite_moment', label: 'Momen paling berkesan selama bootcamp', placeholder: 'Tuliskan momennya...' },
                { key: 'rating', label: 'Rating pengalaman Anda (1–5)' },
                { key: 'concrete_skill', label: 'Skill konkret yang Anda dapatkan', placeholder: 'cth: Mampu membuat landing page responsif' },
                { key: 'message_to_friend', label: 'Pesan untuk calon peserta lain', placeholder: 'Tuliskan pesan Anda...' },
                { key: 'allow_testimonial', label: 'Izinkan testimoni saya ditampilkan' },
            ],

            init() {
                base.init.call(this);
            },

            // ===== navigasi tab & accordion =====
            toggleMaterial(cmId) {
                this.openMaterials[cmId] = !this.openMaterials[cmId];
            },
            toggleResource(cmId, rid) {
                const key = cmId + '-' + rid;
                this.openResources[key] = !this.openResources[key];
            },

            // ===== modal resource =====
            openResource(cm, res) {
                if (!cm || cm.is_open != 1 || !res) return;
                this.activeCm = cm;
                this.activeResource = res;
                this.modalOpen = true;
            },
            closeResource() {
                this.modalOpen = false;
            },
            isViewType(type) {
                return ['text', 'video', 'pdf', 'slide', 'audio', 'url', 'book_ref', 'meeting'].includes(type);
            },
            typeLabel(type) {
                const map = {
                    text: 'Teks', video: 'Video', pdf: 'PDF', slide: 'Slide', audio: 'Audio',
                    url: 'Tautan', book_ref: 'Referensi Buku', quiz: 'Kuis', submission: 'Tugas', meeting: 'Sesi Meeting',
                };
                return map[type] || type || '';
            },
            async markProgressFromModal() {
                if (!this.activeCm || !this.activeResource) return;
                await this.markProgress(this.activeCm.id, this.activeResource.id);
                this.closeResource();
            },
            async submitFromModal() {
                if (!this.activeCm || !this.activeResource) return;
                const cmId = this.activeCm.id;
                const rid  = this.activeResource.id;
                await this.submitTask(cmId, rid);
                // Sinkronkan ulang resource agar status submission terbaru tampil di modal
                const cm  = (this.data.materials || []).find(c => c.id == cmId);
                const res = cm ? cm.resources.find(r => r.id == rid) : null;
                if (res) {
                    this.activeCm = cm;
                    this.activeResource = res;
                }
            },

            // ===== sertifikat per pertemuan =====
            async claimTopicCertificate(cmId) {
                if (this.topicClaiming[cmId]) return;

                this.topicClaiming[cmId] = true;
                try {
                    const response = await $heroicHelper.post(`/bootcamp/learn/claimtopic/${cmId}`, {});
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message || 'Sertifikat berhasil diklaim.', 'success', 'bottom');
                        this.loadPage(`/bootcamp/learn/data/${this.classId}?t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal klaim sertifikat.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.topicClaiming[cmId] = false;
                }
            },

            // ===== helper =====
            resIcon(type) {
                const map = {
                    text: 'bi-file-text',
                    video: 'bi-play-circle',
                    pdf: 'bi-file-earmark-pdf',
                    slide: 'bi-easel',
                    audio: 'bi-music-note',
                    url: 'bi-link-45deg',
                    book_ref: 'bi-book',
                    quiz: 'bi-patch-question',
                    submission: 'bi-upload',
                    meeting: 'bi-camera-video',
                };
                return map[type] || 'bi-file-earmark';
            },
            // Tipe meeting punya field link sendiri (content.meeting_url) — tidak diambil
            // dari deskripsi/instruksi.
            meetingUrl(res) {
                const url = ((res && res.content) || {}).meeting_url || '';
                return /^https?:\/\//i.test(url) ? url : '';
            },
            meetingModeLabel(mode) {
                const map = { offline: 'Offline', offline_online: 'Offline + Online', online: 'Online' };
                return map[mode] || (mode ? 'Mode: ' + mode : '');
            },
            // Link rekaman sesi (diisi dari admin, tipe meeting). Boleh berupa URL saja
            // atau tempelan utuh kode embed Bunny — URL-nya yang diambil.
            cleanUrl(value) {
                const raw   = String(value || '').trim();
                const match = raw.match(/<iframe[^>]*\ssrc\s*=\s*["']([^"']+)["']/i);
                const url   = (match ? match[1] : raw).replace(/&amp;/g, '&').trim();
                return /^https?:\/\//i.test(url) ? url : '';
            },
            recordingUrl(res) {
                return this.cleanUrl(((res && res.content) || {}).recording_url);
            },
            // Akhir sesi = jadwal pertemuan + durasi (menit). null bila datanya tidak lengkap.
            meetingEndAt(cm, res) {
                const start    = cm && cm.scheduled_at ? String(cm.scheduled_at).replace(' ', 'T') : '';
                const duration = parseInt(((res && res.content) || {}).duration, 10) || 0;
                if (!start || duration <= 0) return null;
                const startedAt = new Date(start).getTime();
                return isNaN(startedAt) ? null : startedAt + (duration * 60000);
            },
            meetingEnded(cm, res) {
                const end = this.meetingEndAt(cm, res);
                return end !== null && Date.now() > end;
            },
            // Batas akhir sesi untuk klaim sertifikat & tombol "sudah paham": jadwal mulai
            // + durasi; bila durasi tidak diisi → berakhir tepat di jadwal mulai. Aturan ini
            // harus sama dengan PageController::sessionEndAt().
            sessionEndAt(cm, res) {
                const start = cm && cm.scheduled_at ? String(cm.scheduled_at).replace(' ', 'T') : '';
                if (!start) return null;

                const startedAt = new Date(start).getTime();
                if (isNaN(startedAt)) return null;

                const duration = parseInt(((res && res.content) || {}).duration, 10) || 0;
                return startedAt + (duration * 60000);
            },
            sessionEnded(cm, res) {
                const end = this.sessionEndAt(cm, res);
                return end === null || Date.now() > end;
            },
            // Resource boleh ditandai "sudah paham": sesi meeting baru bisa setelah sesi berakhir.
            isResourceReady(cm, res) {
                if (! cm || ! res) return false;
                return res.type !== 'meeting' || this.sessionEnded(cm, res);
            },
            // Jadikan URL di dalam teks (deskripsi/instruksi) bisa diklik.
            linkify(text) {
                const escaped = String(text || '').replace(/[&<>"']/g, ch => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
                }[ch]));

                return escaped.replace(/https?:\/\/[^\s<>"']+/g, url =>
                    `<a href="${url}" target="_blank" rel="noopener">${url}</a>`);
            },
            // Kembalikan boolean eksplisit supaya binding :disabled tidak salah
            isSubmitting(cmId, rid) {
                return !!this.progressSubmitting[cmId + '-' + rid];
            },
            isSubmitSubmitting(rid) {
                return !!this.submitSubmitting[rid];
            },
            // Nilai harus boolean tegas: `undefined` membuat :disabled terpasang di Alpine.
            isTopicClaiming(cmId) {
                return !!this.topicClaiming[cmId];
            },
            // Ubah link media apa pun (YouTube/Bunny/Drive/Docs) jadi URL yang cocok
            // ditempel di iframe. Dipakai video, PDF, dan rekaman meeting.
            embedUrl(url) {
                const src = this.cleanUrl(url) || String(url || '').trim();
                if (!src) return '';

                const yt = src.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([\w-]{6,})/);
                if (yt) return 'https://www.youtube.com/embed/' + yt[1];

                // Bunny Stream: link share (/play/) atau domain lama tetap diarahkan ke
                // /embed/ supaya bisa masuk iframe. Query (?token=&expires=) ikut dibawa.
                const bunny = src.match(/^(?:https?:\/\/)?(?:[\w-]+\.)*(?:mediadelivery\.net|bunnycdn\.com)\/(?:embed|play)\/(\d+)\/([\w-]+)(.*)$/i);
                if (bunny) return `https://iframe.mediadelivery.net/embed/${bunny[1]}/${bunny[2]}${bunny[3]}`;

                // Google Drive/Docs tidak bisa di-embed lewat URL /view atau /edit.
                const drive = src.match(/drive\.google\.com\/(?:file\/d\/|open\?id=|uc\?(?:export=\w+&)?id=)([\w-]{10,})/);
                if (drive) return `https://drive.google.com/file/d/${drive[1]}/preview`;

                const docs = src.match(/docs\.google\.com\/(document|presentation|spreadsheets)\/d\/([\w-]{10,})/);
                if (docs) return `https://docs.google.com/${docs[1]}/d/${docs[2]}/preview`;

                return src;
            },
            // Provider yang sudah pasti bisa diputar di dalam iframe.
            isEmbeddableUrl(url) {
                return /(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)/i.test(url)
                    || /mediadelivery\.net\/|bunnycdn\.com\//i.test(url)
                    || /drive\.google\.com\//i.test(url)
                    || /docs\.google\.com\//i.test(url);
            },
            videoEmbedUrl(res) {
                return this.embedUrl((res.content || {}).url || '');
            },
            // URL file PDF: biarkan URL absolut (http…) apa adanya, sisanya jadi path relatif root.
            pdfUrl(path) {
                if (!path) return '';
                return /^https?:\/\//i.test(path) ? path : ('/' + path.replace(/^\//, ''));
            },
            pdfEmbedUrl(path) {
                return /^https?:\/\//i.test(String(path || '')) ? this.embedUrl(path) : this.pdfUrl(path);
            },
            // Link rekaman berupa file video langsung (.mp4/.webm/…) atau halaman embed.
            isDirectVideoUrl(url) {
                return /\.(mp4|webm|ogv|ogg|mov|m3u8|mpd)(\?|#|$)/i.test(String(url || ''));
            },
            // Tipe rekaman: dari pilihan admin ('embed' / 'direct'); data lama
            // dideteksi otomatis dari bentuk URL-nya.
            recordingKind(res) {
                const content  = (res && res.content) || {};
                const explicit = String(content.recording_type || '').toLowerCase();
                if (explicit === 'embed' || explicit === 'direct') return explicit;

                const url = this.recordingUrl(res);
                if (!url) return '';

                return this.isDirectVideoUrl(url) ? 'direct' : 'embed';
            },
            // Rekaman tipe video langsung → diputar dengan <video>.
            recordingVideoUrl(res) {
                return this.recordingKind(res) === 'direct' ? this.recordingUrl(res) : '';
            },
            // Rekaman tipe embed → diputar dengan <iframe>. Data lama (tanpa pilihan
            // tipe) hanya di-embed kalau providernya dikenal.
            recordingEmbedUrl(res) {
                if (this.recordingKind(res) !== 'embed') return '';

                const url = this.recordingUrl(res);
                if (!url) return '';

                const explicit = String(((res && res.content) || {}).recording_type || '').toLowerCase();
                if (explicit !== 'embed' && ! this.isEmbeddableUrl(url)) return '';

                return this.embedUrl(url);
            },
            materialOverallPercent() {
                const mats = this.data.materials || [];
                let done = 0, total = 0;
                mats.forEach(m => { done += m.completed_count || 0; total += m.required_count || 0; });
                return total > 0 ? Math.round((done / total) * 100) : 0;
            },

            // ===== progres =====
            async markProgress(cmId, rid) {
                const key = cmId + '-' + rid;
                this.progressSubmitting[key] = true;
                try {
                    const response = await $heroicHelper.post(`/bootcamp/learn/progress/${cmId}/${rid}`, {});
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr('Materi ditandai selesai.', 'success', 'bottom');
                        this.loadPage(`/bootcamp/learn/data/${this.classId}?t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal menyimpan progres.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.progressSubmitting[key] = false;
                }
            },

            // ===== submission =====
            async submitTask(cmId, rid) {
                const cm = (this.data.materials || []).find(c => c.id === cmId);
                const res = cm ? cm.resources.find(r => r.id === rid) : null;
                if (!res) return;

                const isUpload = (res.content.submission_type || 'upload') === 'upload';
                const file = this.submitFiles[rid];
                const url = (this.submitUrls[rid] || '').trim();

                if (isUpload && !file) {
                    $heroicHelper.toastr('Pilih file terlebih dahulu.', 'warning', 'bottom');
                    return;
                }
                if (!isUpload && !url) {
                    $heroicHelper.toastr('Masukkan URL tugas terlebih dahulu.', 'warning', 'bottom');
                    return;
                }

                this.submitSubmitting[rid] = true;
                try {
                    const payload = isUpload ? { file } : { url };
                    const response = await $heroicHelper.post(`/bootcamp/learn/submit/${cmId}/${rid}`, payload);
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                        this.submitFiles[rid] = null;
                        this.submitUrls[rid] = '';
                        this.loadPage(`/bootcamp/learn/data/${this.classId}?t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal mengumpulkan tugas.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.submitSubmitting[rid] = false;
                }
            },

            // ===== feedback =====
            async sendFeedback() {
                const f = this.feedback;
                const required = ['profession', 'city', 'condition_before', 'reason_choice', 'favorite_moment', 'rating', 'concrete_skill', 'message_to_friend'];
                for (const key of required) {
                    const val = f[key];
                    if (val === null || String(val).trim() === '') {
                        $heroicHelper.toastr('Mohon lengkapi semua pertanyaan feedback.', 'warning', 'bottom');
                        return;
                    }
                }

                this.feedbackSubmitting = true;
                try {
                    const payload = {
                        ...f,
                        rating: parseInt(f.rating, 10) || 0,
                        allow_testimonial: f.allow_testimonial ? 1 : 0,
                    };
                    const response = await $heroicHelper.post(`/bootcamp/learn/feedback/${this.classId}`, payload);
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                        this.loadPage(`/bootcamp/learn/data/${this.classId}?t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal mengirim feedback.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.feedbackSubmitting = false;
                }
            },

            // ===== klaim sertifikat =====
            async claimCertificate() {
                if (!this.data.can_claim || !this.data.can_claim.allowed) return;
                this.claiming = true;
                try {
                    const response = await $heroicHelper.post(`/bootcamp/learn/claim/${this.classId}`, {});
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                        this.loadPage(`/bootcamp/learn/data/${this.classId}?t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Belum bisa klaim sertifikat.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.claiming = false;
                }
            },
        }
    })
</script>
