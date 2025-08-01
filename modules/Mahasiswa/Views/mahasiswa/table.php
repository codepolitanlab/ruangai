<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/<?= urlScope() ?>/course/form" class="btn btn-primary me-2"><i class="bi bi-download"></i> Ekspor</a> -->
                <a href="/<?= urlScope() ?>/mahasiswa/create" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Mahasiswa</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body table-responsive">

                <div x-data="tableFilter()" x-init="loadTable()">

                    <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>perpage: </span>
                            <select id="perpage" x-model="perpage" class="form-select form-select-sm" @change="page=1; loadTable()">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="200">200</option>
                            </select>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Pilih Kolom
                            </button>
                            <ul class="dropdown-menu p-2" style="min-width: 200px;">
                                <template x-for="(visible, key) in visibleColumns" :key="key">
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center gap-2">
                                            <input type="checkbox"
                                                class="form-check-input"
                                                x-model="visibleColumns[key]"
                                                @change="loadTable()">
                                            <span x-text="labelMap[key] || key"></span>
                                        </label>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th x-show="visibleColumns.nama">Nama</th>
                                <th x-show="visibleColumns.nomor_induk">Nomor Induk</th>
                                <th x-show="visibleColumns.jenis_kelamin">Jenis Kelamin</th>
                                <th x-show="visibleColumns.nama_jurusan">Jurusan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            <tr class="filters">
                                <th></th>
                                <th x-show="visibleColumns.nama">
                                    <input type="text" class="form-control" placeholder="Cari Nama" x-model="filters.nama" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.nomor_induk">
                                    <input type="text" class="form-control" placeholder="Cari NIM" x-model="filters.nomor_induk" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.jenis_kelamin">
                                    <input type="text" class="form-control" placeholder="Cari JK" x-model="filters.jenis_kelamin" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th x-show="visibleColumns.nama_jurusan">
                                    <input type="text" class="form-control" placeholder="Cari Jurusan" x-model="filters.nama_jurusan" @keydown.enter="page=1; loadTable()" />
                                </th>
                                <th>
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-outline-primary text-nowrap" @click="page=1; loadTable()"><i class="bi bi-search"></i> Filter</button>
                                        <button class="btn btn-sm btn-outline-secondary text-nowrap" @click="resetFilter()"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-ref="tableBody">
                            <!-- akan diisi via ajax -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</div>

<script>
    function tableFilter() {
        return {
            filters: {
                nama: '',
                nomor_induk: '',
                jenis_kelamin: '',
                nama_jurusan: ''
            },

            visibleColumns: {
                nama: true,
                nomor_induk: true,
                jenis_kelamin: true,
                nama_jurusan: true,
            },

            labelMap: {
                nama: 'Nama',
                nomor_induk: 'Nomor Induk',
                jenis_kelamin: 'Jenis Kelamin',
                nama_jurusan: 'Jurusan',
            },

            page: 1,
            perpage: 5,
            timeout: null,

            resetFilter() {
                this.filters = {
                    nama: '',
                    nomor_induk: '',
                    jenis_kelamin: '',
                    nama_jurusan: ''
                };
                this.page = 1;
                this.loadTable();
            },

            async loadTable() {
                const params = new URLSearchParams();

                // Encode filter as filter[nama]=... etc
                for (const key in this.filters) {
                    params.append(`filter[${key}]`, this.filters[key]);
                }

                for (const key in this.visibleColumns) {
                    if (this.visibleColumns[key]) {
                        params.append(`visible[${key}]`, '1');
                    }
                }

                params.append('page', this.page);
                params.append('perpage', this.perpage);

                const response = await fetch(`<?= site_url(urlScope() . '/mahasiswa/table') ?>?${params}`);
                const html = await response.text();
                this.$refs.tableBody.innerHTML = html;
            }
        }
    }
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->