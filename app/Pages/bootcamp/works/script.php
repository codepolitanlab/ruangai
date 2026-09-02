<script>
    Alpine.data('bootcamp_works', function () {
        let base = $heroic({
            title: 'Karya Saya',
            url: '/bootcamp/works/data',
        });

        return {
            ...base,
            filter: '',
            showModal: false,
            editing: null,
            saving: false,
            form: {
                title: '',
                short_description: '',
                description: '',
                thumbnail: '',
                photos: [''],
                url_project: '',
            },

            init() {
                base.init.call(this);
            },

            setFilter(status) {
                this.filter = status;
                this.loadPage(`/bootcamp/works/data?status=${status}&t=${Date.now()}`);
            },

            openCreate() {
                this.editing = null;
                this.form = { title: '', short_description: '', description: '', thumbnail: '', photos: [''], url_project: '' };
                this.showModal = true;
            },

            openEdit(work) {
                this.editing = work;
                this.form = {
                    title: work.title || '',
                    short_description: work.short_description || '',
                    description: work.description || '',
                    thumbnail: work.thumbnail || '',
                    photos: (work.photos_arr && work.photos_arr.length ? work.photos_arr : ['']),
                    url_project: work.url_project || '',
                };
                this.showModal = true;
            },

            async save() {
                const title = (this.form.title || '').trim();
                if (!title) {
                    $heroicHelper.toastr('Judul karya wajib diisi.', 'warning', 'bottom');
                    return;
                }
                if ((this.form.short_description || '').length > 500) {
                    $heroicHelper.toastr('Deskripsi singkat maksimal 500 karakter.', 'warning', 'bottom');
                    return;
                }

                this.saving = true;
                try {
                    const url = this.editing
                        ? `/bootcamp/works/update/${this.editing.id}`
                        : '/bootcamp/works/store';

                    const response = await $heroicHelper.post(url, this.form);

                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                        this.showModal = false;
                        this.loadPage(`/bootcamp/works/data?status=${this.filter}&t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal menyimpan karya.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                } finally {
                    this.saving = false;
                }
            },

            async remove(work) {
                if (!confirm(`Hapus karya "${work.title}"?`)) return;
                try {
                    const response = await $heroicHelper.post(`/bootcamp/works/delete/${work.id}`, {});
                    if (response.data.status === 'success') {
                        $heroicHelper.toastr(response.data.message, 'success', 'bottom');
                        this.loadPage(`/bootcamp/works/data?status=${this.filter}&t=${Date.now()}`);
                    } else {
                        $heroicHelper.toastr(response.data.message || 'Gagal menghapus karya.', 'danger', 'bottom');
                    }
                } catch (error) {
                    console.error(error);
                    $heroicHelper.toastr('Terjadi kesalahan. Silakan coba lagi.', 'danger', 'bottom');
                }
            },
        }
    })
</script>
