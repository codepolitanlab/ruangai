<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>
<!-- Tambahkan jQuery dan DataTables di head -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
            <div class="card-body">

                <form action="<?= site_url(urlScope() . '/mahasiswa/update/' . $mahasiswa['id']) ?>" method="post">
                    <div class="form-group mb-3">
                        <label class="form-label" for="nama">Nama:</label>
                        <input class="form-control" type="text" name="nama" value="<?= esc($mahasiswa['nama']) ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="nomor_induk">Nomor Induk:</label>
                        <input class="form-control" type="text" name="nomor_induk" value="<?= esc($mahasiswa['nomor_induk']) ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin:</label><br>
                        <input type="radio" name="jenis_kelamin" value="L" <?= $mahasiswa['jenis_kelamin'] === 'L' ? 'checked' : '' ?>> Laki-laki
                        <input type="radio" name="jenis_kelamin" value="P" <?= $mahasiswa['jenis_kelamin'] === 'P' ? 'checked' : '' ?>> Perempuan
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="jurusan_id">Jurusan:</label>
                        <select class="form-select" name="jurusan_id" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <?php foreach ($jurusan as $j): ?>
                                <option value="<?= $j['id'] ?>" <?= $mahasiswa['jurusan_id'] === $j['id'] ? 'selected' : '' ?>>
                                    <?= esc($j['nama_jurusan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-outline-secondary" href="<?= base_url('mahasiswa') ?>">Kembali</a>
                    </div>
                </form>


            </div>
        </div>
    </section>

</div>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#mahasiswaTable tfoot th').each(function() {
            var title = $(this).text();
            if (title !== 'Aksi') {
                $(this).html('<input type="text" placeholder="Cari ' + title + '" />');
            } else {
                $(this).html('');
            }
        });

        // DataTable
        var table = $('#mahasiswaTable').DataTable();

        // Apply the search
        table.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->