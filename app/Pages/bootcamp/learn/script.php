<script>
    Alpine.data('bootcamp_learn', function (classId) {
        let base = $heroic({
            title: 'Belajar Bootcamp',
            url: `/bootcamp/learn/data/${classId}`,
        });

        return {
            ...base,
            classId,
            tab: 'info',
            openMaterials: {},
            openResources: {},
            activeResource: null,
            activeCm: null,
            modalOpen: false,
            progressSubmitting: {},
            submitSubmitting: {},
            submitFiles: {},
            submitUrls: {},
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
            // Kembalikan boolean eksplisit supaya binding :disabled tidak salah
            isSubmitting(cmId, rid) {
                return !!this.progressSubmitting[cmId + '-' + rid];
            },
            isSubmitSubmitting(rid) {
                return !!this.submitSubmitting[rid];
            },
            videoEmbedUrl(res) {
                const url = (res.content || {}).url || '';
                if (!url) return '';
                const yt = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([\w-]{6,})/);
                if (yt) return 'https://www.youtube.com/embed/' + yt[1];
                const vimeo = url.match(/vimeo\.com\/(\d+)/);
                if (vimeo) return 'https://player.vimeo.com/video/' + vimeo[1];
                return url;
            },
            // URL file PDF: biarkan URL absolut (http…) apa adanya, sisanya jadi path relatif root.
            pdfUrl(path) {
                if (!path) return '';
                return /^https?:\/\//i.test(path) ? path : ('/' + path.replace(/^\//, ''));
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
