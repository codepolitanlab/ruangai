<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <div class="d-flex mb-4">
        <a href="/admin/user" class="btn text-success rounded-pill px-4 me-2"><i class="bi bi-person-fill"></i> Pengguna</a>
        <a href="/admin/user/role" class="btn btn-white text-success rounded-pill px-4 me-2"><i class="bi bi-person-fill-gear"></i> Peran</a>
    </div>

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Role</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/admin/user/role/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Peran</a>
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
                            <th>Role Status</th>
                            <th>Created at</th>
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
                            <td><input type="text" class="form-control form-control-sm" name="filter[status]" value="" placeholder="filter by status"></td>

                            <td></td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="https://madrasahdigital.id/admin/user/role" class="btn btn-secondary">Reset</a>
                                </div>
                            </td>
                        </tr>

                        <!-- End form filter -->


                        <tr>
                            <td>1</td>

                            <td>Super</td>
                            <td>active</td>

                            <td title="Senin, 13 Mei">
                                13-05-2013, 10:10 </td>
                            <td class="text-end">

                                <em>Superadmin dapat semua hak akses.</em>

                            </td>
                        </tr>
                        <tr>
                            <td>2</td>

                            <td>Writer</td>
                            <td>active</td>

                            <td title="Senin, 13 Mei">
                                13-05-2013, 10:10 </td>
                            <td class="text-end">

                                <a class="btn btn-sm btn-outline-secondary" href="https://madrasahdigital.id/admin/user/role/privileges/2" title="Set Privilege"><span class="bi bi-key"></span> Atur Hak Akses</a>

                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-success" href="https://madrasahdigital.id/admin/user/role/edit/2" title="Edit"><span class="bi bi-pencil"></span> Edit</a>

                                    <a class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/role/delete/2" title="Hapus"><span class="bi bi-x-lg"></span> Delete</a>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>3</td>

                            <td>Member</td>
                            <td>active</td>

                            <td title="Senin, 13 Mei">
                                13-05-2013, 10:10 </td>
                            <td class="text-end">

                                <a class="btn btn-sm btn-outline-secondary" href="https://madrasahdigital.id/admin/user/role/privileges/3" title="Set Privilege"><span class="bi bi-key"></span> Atur Hak Akses</a>

                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-success" href="https://madrasahdigital.id/admin/user/role/edit/3" title="Edit"><span class="bi bi-pencil"></span> Edit</a>

                                    <a class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/role/delete/3" title="Hapus"><span class="bi bi-x-lg"></span> Delete</a>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>4</td>

                            <td>Admin</td>
                            <td>active</td>

                            <td title="Senin, 28 Desember">
                                28-12-2020, 11:11 </td>
                            <td class="text-end">

                                <a class="btn btn-sm btn-outline-secondary" href="https://madrasahdigital.id/admin/user/role/privileges/4" title="Set Privilege"><span class="bi bi-key"></span> Atur Hak Akses</a>

                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-success" href="https://madrasahdigital.id/admin/user/role/edit/4" title="Edit"><span class="bi bi-pencil"></span> Edit</a>

                                    <a class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/role/delete/4" title="Hapus"><span class="bi bi-x-lg"></span> Delete</a>
                                </div>

                            </td>
                        </tr>


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