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

                <table id="mahasiswaTable" class="table display">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nomor Induk</th>
                            <th>Jenis Kelamin</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                        <tr class="filters">
                            <th><input type="text" placeholder="Cari Nama" /></th>
                            <th><input type="text" placeholder="Cari Nomor Induk" /></th>
                            <th><input type="text" placeholder="Cari Jenis Kelamin" /></th>
                            <th><input type="text" placeholder="Cari Jurusan" /></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

</div>

<script>
    $(function() {
        // DataTable
        var table = $('#mahasiswaTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            orderCellsTop: true,
            ajax: {
                url: "<?= site_url(urlScope() . '/mahasiswa/datatables') ?>",
                type: "POST",
                data: function(d) {
                    // Ambil nilai dari filter per kolom
                    $('.filters th input').each(function(i) {
                        d['columns_filter[' + i + ']'] = this.value;
                    });
                }
            },
            columns: [
                { data: 'nama' },
                { data: 'nomor_induk' },
                { data: 'jenis_kelamin' },
                { data: 'nama_jurusan' },
                { data: 'aksi', orderable: false, searchable: false }
            ]
        });

        $('.filters th input').each(function () {
            $(this).on('keyup change', debounce(function () {
                table.draw();
            }, 1000)); // ⏱️ 2000ms = 2 detik idle
        });
    });

    function debounce(fn, delay) {
        let timer = null;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->