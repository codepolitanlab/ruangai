<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<?php $vBase = '/' . urlScope() . '/voucher'; ?>

<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= admin_url() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Vouchers</li>
                        <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="<?= $vBase ?>/generate" class="btn btn-primary">
                    <i class="bi bi-ticket-perforated"></i> Generate Voucher
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">
                <form method="GET" action="<?= $vBase ?>/sales">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0">Total Voucher Terpakai : <b><?= $total_vouchers ?></b></p>
                        <div class="d-flex align-items-center gap-2">
                            <small class="fw-bold">Order By:</small>
                            <select name="filter[field]" class="form-select form-select-sm" style="width: auto;">
                                <option value="" <?= empty($filter['field']) ? 'selected' : '' ?>>--Select--</option>
                                <option value="id" <?= ($filter['field'] ?? '') === 'id' ? 'selected' : '' ?>>ID</option>
                                <option value="name" <?= ($filter['field'] ?? '') === 'name' ? 'selected' : '' ?>>Nama</option>
                                <option value="claimed" <?= ($filter['field'] ?? '') === 'claimed' ? 'selected' : '' ?>>Waktu Klaim</option>
                            </select>
                            <select name="filter[order]" class="form-select form-select-sm" style="width: auto;">
                                <option value="desc" <?= ($filter['order'] ?? 'desc') === 'desc' ? 'selected' : '' ?>>Desc</option>
                                <option value="asc" <?= ($filter['order'] ?? '') === 'asc' ? 'selected' : '' ?>>Asc</option>
                            </select>
                            <small class="fw-bold">Perpage:</small>
                            <input type="number" name="perpage" class="form-control form-control-sm" style="width: 70px;" value="<?= $perpage ?>">
                            <div class="btn-group ms-3">
                                <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                <a href="<?= $vBase ?>/sales" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fa fa-file-export"></span> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" id="export_excel">To Excel (.xlsx)</a></li>
                                        <li><a class="dropdown-item" href="#" id="export_csv">To CSV (.csv)</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Voucher Code</th>
                                    <th>Kelas</th>
                                    <th>Batch</th>
                                    <th>Nama Pemilik</th>
                                    <th>Email</th>
                                    <th>WhatsApp</th>
                                    <th>Claimed By</th>
                                    <th>Waktu Klaim</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[id]" value="<?= esc($filter['id'] ?? '') ?>" placeholder="ID"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[voucher_code]" value="<?= esc($filter['voucher_code'] ?? '') ?>" placeholder="Code"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[course_title]" value="<?= esc($filter['course_title'] ?? '') ?>" placeholder="Kelas"></td>
                                    <td></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[name]" value="<?= esc($filter['name'] ?? '') ?>" placeholder="Nama"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[email]" value="<?= esc($filter['email'] ?? '') ?>" placeholder="Email"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter[phone]" value="<?= esc($filter['phone'] ?? '') ?>" placeholder="WhatsApp"></td>
                                    <td></td>
                                    <td><input type="date" class="form-control form-control-sm" name="filter[claimed]" value="<?= esc($filter['claimed'] ?? '') ?>"></td>
                                    <td></td>
                                </tr>

                                <?php foreach ($vouchers as $voucher): ?>
                                    <tr>
                                        <td><?= $voucher['id'] ?></td>
                                        <td><code><?= esc($voucher['voucher_code'] ?? '-') ?></code></td>
                                        <td><?= esc($voucher['course_title'] ?? '-') ?></td>
                                        <td><?= esc($voucher['live_batch_name'] ?? '-') ?></td>
                                        <td><?= esc($voucher['name'] ?? '-') ?></td>
                                        <td><?= esc($voucher['email'] ?? '-') ?></td>
                                        <td>
                                            <?php if (! empty($voucher['phone']) && $voucher['phone'] !== '-'): ?>
                                                <a href="https://wa.me/<?= esc($voucher['phone']) ?>" target="_blank"><?= esc($voucher['phone']) ?></a>
                                            <?php else: ?>
                                                -
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if (! empty($voucher['claimed_by_email'])): ?>
                                                <small><?= esc($voucher['claimed_by_email']) ?></small>
                                            <?php else: ?>
                                                -
                                            <?php endif ?>
                                        </td>
                                        <td><?= esc($voucher['claimed'] ?? '-') ?></td>
                                        <td><span class="badge bg-success">Claimed</span></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php if (empty($vouchers)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">Belum ada voucher yang digunakan.</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Pagination -->
                <?php if (($total_pages ?? 1) > 1): ?>
                <nav class="mt-3">
                    <ul class="pagination pagination-sm justify-content-center flex-wrap">
                        <?php
                        $queryBase = array_merge($_GET, []);
                        for ($p = 1; $p <= $total_pages; $p++):
                            $queryBase['page'] = $p;
                            $url = $vBase . '/sales?' . http_build_query($queryBase);
                        ?>
                        <li class="page-item <?= $p === $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $url ?>"><?= $p ?></a>
                        </li>
                        <?php endfor ?>
                    </ul>
                </nav>
                <?php endif ?>

            </div>
        </div>
    </section>

</div>

<script>
    const vouchersData = <?= json_encode($vouchers) ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
    function generateFilename(extension) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const dateString = `${year}-${month}-${day}`;
        const hours = String(today.getHours()).padStart(2, '0');
        const minutes = String(today.getMinutes()).padStart(2, '0');
        const seconds = String(today.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        return `JagoanSiber - Vouchers Terpakai - ${dateString} ${timeString}.${extension}`;
    }

    function getExportData() {
        return vouchersData.map(voucher => ({
            "ID": voucher.id,
            "Voucher Code": voucher.voucher_code || '-',
            "Kelas": voucher.course_title || '-',
            "Batch": voucher.live_batch_name || '-',
            "Nama Pemilik": voucher.name || '-',
            "Email": voucher.email || '-',
            "WhatsApp": voucher.phone || '-',
            "Claimed By": voucher.claimed_by_email || '-',
            "Waktu Klaim": voucher.claimed || '-',
            "Status": "Claimed",
        }));
    }

    document.getElementById('export_excel').addEventListener('click', function(e) {
        e.preventDefault();
        const ws = XLSX.utils.json_to_sheet(getExportData());
        ws['!cols'] = Array(10).fill({ wch: 25 });
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Vouchers Terpakai");
        XLSX.writeFile(wb, generateFilename('xlsx'));
    });

    document.getElementById('export_csv').addEventListener('click', function(e) {
        e.preventDefault();
        const ws = XLSX.utils.json_to_sheet(getExportData());
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Vouchers Terpakai");
        XLSX.writeFile(wb, generateFilename('csv'), { bookType: "csv" });
    });
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->
