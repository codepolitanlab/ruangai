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
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/user">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Role Management</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/user/role/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Peran</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="60px">id</th>
                            <th>Role Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Form filter -->
                        <form></form>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="filter[id]" value="">
                            </td>

                            <td><input type="text" class="form-control form-control-sm" name="filter[role_name]" value="" placeholder="filter by role_name"></td>
                            <td><input type="text" class="form-control form-control-sm" name="filter[role_slug]" value="" placeholder="filter by role_name"></td>
                            <td><input type="text" class="form-control form-control-sm" name="filter[status]" value="" placeholder="filter by status"></td>

                            <td class="text-end">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="/<?= urlScope() ?>/user/role" class="btn btn-secondary">Reset</a>
                                </div>
                            </td>
                        </tr>
                        <!-- End form filter -->

                        <?php foreach ($roles as $role) : ?>
                        <tr>
                            <td><?= $role['id'] ?></td>
                            <td><?= $role['role_name'] ?></td>
                            <td><?= $role['role_slug'] ?></td>
                            <td><?= $role['status'] ?></td>
                            <td class="text-end">
                                <?php if($role['id'] === 1) : ?>
                                    <em>Superadmin dapat semua hak akses.</em>
                                <?php else: ?>
                                <a class="btn btn-sm btn-outline-secondary" href="/<?= urlScope() ?>/user/role/privileges/<?= $role['id'] ?>" title="Set Privilege"><span class="bi bi-key"></span> Atur Hak Akses</a>
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-success" href="/<?= urlScope() ?>/user/role/form/<?= $role['id'] ?>" title="Edit"><span class="bi bi-pencil"></span> Edit</a>
                                    <a class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')" href="/<?= urlScope() ?>/user/role/delete/<?= $role['id'] ?>" title="Hapus"><span class="bi bi-x-lg"></span> Delete</a>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

                <div class="pagination">
                </div>

            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->