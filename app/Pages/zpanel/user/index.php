<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <div class="d-flex mb-4">
       <a href="/zpanel/user" class="btn btn-white text-success rounded-pill px-4 me-2"><i class="bi bi-person-fill"></i> Pengguna</a>
       <a href="/zpanel/user/role" class="btn text-success rounded-pill px-4 me-2"><i class="bi bi-person-fill-gear"></i> Peran</a>
    </div>

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/zpanel/course/form" class="btn btn-primary me-2"><i class="bi bi-download"></i> Ekspor</a>
                <a href="/zpanel/user/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Pengguna</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">
                <div class="mb-4">
                    <div class="row mx-1">
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Total Users</strong>
                            <br><?= $total_users ?> orang
                        </div>
                    </div>
                    <a class="resetcache m-2 h5" href="/zpanel/user/reset_cache"><span class="bi bi-arrow-repeat"></span></a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="GET" action="/zpanel/user">
                                <tr>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_id" value="<?= $filter_id ?? '' ?>" placeholder="id"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_name" value="<?= $filter_name ?? '' ?>" placeholder="Name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_email" value="<?= $filter_email ?? '' ?>" placeholder="Email"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_role" value="<?= $filter_role ?? '' ?>" placeholder="Role"></td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/zpanel/user" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </tr>
                            </form>

                            <?php 
                            $no = ($current_page - 1) * $per_page + 1;
                            foreach ($users as $user) : 
                            ?>
                            <tr>
                                <!-- use numbering -->
                                <td><?= $user->id ?></td>
                                <td><?= $user->name ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->role_name ?? '-' ?></td>
                                <td><?= date('Y-m-d H:i:s', strtotime($user->created_at)) ?></td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <?php if($user->status != 'active'): ?>
                                        <a class="btn btn-sm btn-outline-success text-nowrap" 
                                           href="/zpanel/user/activate/<?= $user->id ?>" 
                                           onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')">
                                            <span class="bi bi-star"></span> Activate
                                        </a>
                                        <?php endif; ?>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" 
                                           href="/zpanel/user/edit/<?= $user->id ?>">
                                            <span class="bi bi-pencil-square"></span> Edit
                                        </a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" 
                                           onclick="return confirm('are you sure?')" 
                                           href="/zpanel/user/delete/<?= $user->id ?>">
                                            <span class="bi bi-x-lg"></span> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <?= $pager->links('default', 'bootstrap') ?>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->