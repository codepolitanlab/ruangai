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
                        <li class="breadcrumb-item active" aria-current="page">Daftar Generate</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="<?= $vBase ?>/generate" class="btn btn-primary">
                    <i class="bi bi-ticket-perforated"></i> Generate Voucher Baru
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">
                <form method="GET" action="<?= $vBase ?>/generated">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0">Total : <b><?= $total_vouchers ?></b></p>
                        <div class="d-flex align-items-center gap-2">
                            <small class="fw-bold">Order By:</small>
                            <select name="filter[field]" class="form-select form-select-sm" style="width: auto;">
                                <option value="" <?= empty($filter['field']) ? 'selected' : '' ?>>--Select--</option>
                                <option value="id" <?= ($filter['field'] ?? '') === 'id' ? 'selected' : '' ?>>ID</option>
                                <option value="course_title" <?= ($filter['field'] ?? '') === 'course_title' ? 'selected' : '' ?>>Kelas</option>
                                <option value="created_at" <?= ($filter['field'] ?? '') === 'created_at' ? 'selected' : '' ?>>Waktu Generate</option>
                                <option value="claimed" <?= ($filter['field'] ?? '') === 'claimed' ? 'selected' : '' ?>>Status</option>
                            </select>
                            <select name="filter[order]" class="form-select form-select-sm" style="width: auto;">
                                <option value="desc" <?= ($filter['order'] ?? 'desc') === 'desc' ? 'selected' : '' ?>>Desc</option>
                                <option value="asc" <?= ($filter['order'] ?? '') === 'asc' ? 'selected' : '' ?>>Asc</option>
                            </select>
                            <small class="fw-bold">Perpage:</small>
                            <input type="number" name="perpage" class="form-control form-control-sm" style="width: 70px;" value="<?= $perpage ?>">
                            <div class="btn-group ms-3">
                                <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                <a href="<?= $vBase ?>/generated" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>
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
                        <table class="table table-striped table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Voucher Code</th>
                                    <th>Kelas</th>
                                    <th>Batch</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Waktu Generate</th>
                                    <th>Status</th>
                                    <th>Claimed By</th>
                                    <th></th>
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
                                    <td><input type="date" class="form-control form-control-sm" name="filter[created_at]" value="<?= esc($filter['created_at'] ?? '') ?>"></td>
                                    <td>
                                        <select name="filter[claimed]" class="form-select form-select-sm">
                                            <option value="" <?= ($filter['claimed'] ?? '') === '' ? 'selected' : '' ?>>--All--</option>
                                            <option value="1" <?= ($filter['claimed'] ?? '') === '1' ? 'selected' : '' ?>>Claimed</option>
                                            <option value="0" <?= ($filter['claimed'] ?? '') === '0' ? 'selected' : '' ?>>Unclaimed</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php foreach ($vouchers as $v): ?>
                                <tr>
                                    <td><?= $v['id'] ?></td>
                                    <td><code><?= esc($v['voucher_code']) ?></code></td>
                                    <td><?= esc($v['course_title'] ?? '-') ?></td>
                                    <td><?= esc($v['batch_name'] ?? '-') ?></td>
                                    <td><?= esc($v['name'] ?? '-') ?></td>
                                    <td><?= esc($v['email'] ?? '-') ?></td>
                                    <td><?= esc($v['created_at'] ?? '-') ?></td>
                                    <td>
                                        <?php if (! empty($v['claimed'])): ?>
                                            <span class="badge bg-success">Claimed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Unclaimed</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if (! empty($v['claimed_by_email'])): ?>
                                            <small><?= esc($v['claimed_by_email']) ?></small>
                                        <?php else: ?>
                                            -
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if (empty($v['claimed'])): ?>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger btn-delete"
                                            data-id="<?= $v['id'] ?>"
                                            data-code="<?= esc($v['voucher_code']) ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>

                                <?php if (empty($vouchers)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">Belum ada voucher hasil generate.</td>
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
                            $url = $vBase . '/generated?' . http_build_query($queryBase);
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
    const VOUCHER_BASE = '<?= $vBase ?>';
    const generatedData = <?= json_encode($vouchers) ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
    function generateFilename(extension) {
        const today = new Date();
        const pad = n => String(n).padStart(2, '0');
        const date = `${today.getFullYear()}-${pad(today.getMonth()+1)}-${pad(today.getDate())}`;
        const time = `${pad(today.getHours())}:${pad(today.getMinutes())}:${pad(today.getSeconds())}`;
        return `JagoanSiber - Vouchers Generated - ${date} ${time}.${extension}`;
    }

    function getExportData() {
        return generatedData.map(v => ({
            'ID':             v.id,
            'Voucher Code':   v.voucher_code,
            'Kelas':          v.course_title || '-',
            'Batch':          v.batch_name || '-',
            'Nama':           v.name || '-',
            'Email':          v.email || '-',
            'Waktu Generate': v.created_at || '-',
            'Status':         v.claimed ? 'Claimed' : 'Unclaimed',
            'Claimed By':     v.claimed_by_email || '-',
        }));
    }

    document.getElementById('export_excel').addEventListener('click', function(e) {
        e.preventDefault();
        const ws = XLSX.utils.json_to_sheet(getExportData());
        ws['!cols'] = Array(9).fill({ wch: 25 });
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Generated Vouchers');
        XLSX.writeFile(wb, generateFilename('xlsx'));
    });

    document.getElementById('export_csv').addEventListener('click', function(e) {
        e.preventDefault();
        const ws = XLSX.utils.json_to_sheet(getExportData());
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Generated Vouchers');
        XLSX.writeFile(wb, generateFilename('csv'), { bookType: 'csv' });
    });

    // Delete
    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id   = this.dataset.id;
            const code = this.dataset.code;
            if (! confirm(`Hapus voucher ${code}?`)) return;

            const row = this.closest('tr');
            fetch(VOUCHER_BASE + '/generated/delete', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: new URLSearchParams({ id }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                } else {
                    alert(data.message);
                }
            });
        });
    });
</script>

<?php $this->endSection() ?>
<!-- END Content Section -->
