<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Peserta — <?= esc($class['name']) ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom/classes">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Peserta</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/classes" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal"><i class="bi bi-person-plus"></i> Tambah</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bulkMemberModal"><i class="bi bi-upload"></i> Import CSV</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card card-block rounded-xl shadow">
            <div class="card-header"><strong>Daftar Peserta</strong>
                <span class="badge text-bg-info ms-2"><?= count($members) ?> peserta</span>
            </div>
            <div class="table-responsive px-2 pb-2">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username / NPA</th>
                            <th>Email</th>
                            <th>HP</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($members)) : ?>
                            <?php foreach ($members as $i => $m) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($m['user_name'] ?? '-') ?></td>
                                    <td><?= esc($m['username'] ?? '-') ?></td>
                                    <td><?= esc($m['email'] ?? '-') ?></td>
                                    <td><?= esc($m['phone'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($m['role'] === 'instructor') : ?>
                                            <span class="badge text-bg-success">Instruktur</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-secondary">Peserta</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($m['status'] === 'active') : ?>
                                            <span class="badge text-bg-success">Active</span>
                                        <?php else : ?>
                                            <span class="badge text-bg-danger">Dropped</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $m['enrolled_at'] ? date('d M Y', strtotime($m['enrolled_at'])) : '-' ?></td>
                                    <td class="text-end text-nowrap">
                                        <?php if ($m['status'] === 'active') : ?>
                                            <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/members/<?= $m['id'] ?>/drop"
                                                class="d-inline" onsubmit="return confirm('Drop peserta ini?')">
                                                <button class="btn btn-sm btn-outline-danger" title="Drop"><i class="bi bi-person-dash"></i></button>
                                            </form>
                                        <?php else : ?>
                                            <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/members/<?= $m['id'] ?>/restore" class="d-inline">
                                                <button class="btn btn-sm btn-outline-success" title="Aktifkan kembali"><i class="bi bi-person-check"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada peserta. Tambahkan via tombol "Tambah" atau "Import CSV".</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Member -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/members/add">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Cari User (nama / username / email / HP)</label>
                        <input type="text" id="member_search" class="form-control" placeholder="Ketik minimal 2 huruf..."
                            oninput="memberSearchUser(this.value)">
                        <ul id="member_search_result" class="list-group mt-2" style="max-height:240px;overflow:auto"></ul>
                        <input type="hidden" name="user_id" id="member_user_id">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="member">Member / Peserta</option>
                            <option value="instructor">Instruktur</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="add_member_submit" disabled>Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import CSV -->
<div class="modal fade" id="bulkMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/<?= urlScope() ?>/classroom/classes/<?= $class['id'] ?>/members/bulk" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Import Member Massal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="member">Member / Peserta</option>
                            <option value="instructor">Instruktur</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File CSV <small class="text-muted">(kolom pertama = email / username / HP)</small></label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Atau tempel daftar (satu per baris, pisahkan koma jika perlu)</label>
                        <textarea name="emails" class="form-control" rows="5" placeholder="user@example.com&#10;085123456789"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const MEMBER_CLASS_ID = <?= (int) $class['id'] ?>;
let memberSearchTimer = null;

function memberEsc(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function memberSearchUser(q) {
    const box = document.getElementById('member_search_result');
    const submit = document.getElementById('add_member_submit');
    document.getElementById('member_user_id').value = '';
    submit.disabled = true;
    clearTimeout(memberSearchTimer);

    if (q.trim().length < 2) { box.innerHTML = ''; return; }

    memberSearchTimer = setTimeout(() => {
        fetch('/<?= urlScope() ?>/classroom/classes/' + MEMBER_CLASS_ID + '/members/search?q=' + encodeURIComponent(q), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    box.innerHTML = '<li class="list-group-item text-muted">Tidak ditemukan</li>';
                    return;
                }
                box.innerHTML = data.map(u =>
                    '<li class="list-group-item list-group-item-action" style="cursor:pointer" onclick="memberSelect(' + u.id + ', \'' + memberEsc(u.name) + '\')">' +
                    '<strong>' + memberEsc(u.name) + '</strong> <small class="text-muted">' + memberEsc(u.username || u.email || u.phone) + '</small>' +
                    '</li>'
                ).join('');
            });
    }, 300);
}

function memberSelect(id, name) {
    document.getElementById('member_user_id').value = id;
    document.getElementById('member_search').value = name;
    document.getElementById('member_search_result').innerHTML = '';
    document.getElementById('add_member_submit').disabled = false;
}
</script>

<?php $this->endSection() ?>
