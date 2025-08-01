<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/zpanel">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/zpanel/user">Users</a></li>
                        <li class="breadcrumb-item" aria-current="page">Scholarship</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/zpanel/course/form" class="btn btn-primary me-2"><i class="bi bi-download"></i> Ekspor</a> -->
                <a href="/zpanel/user/scholarship/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Pengguna</a>
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

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->get('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Program</th>
                                <th>Status</th>
                                <th>Joined At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="GET" action="/zpanel/user/scholarship">
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_fullname" value="<?= $filter_fullname ?? '' ?>" placeholder="Name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_email" value="<?= $filter_email ?? '' ?>" placeholder="Email"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_program" value="<?= $filter_program ?? '' ?>" placeholder="Email"></td>
                                    <td>
                                        <select class="form-control form-control-sm" name="filter_status">
                                            <option value="">- Status -</option>
                                            <option value="terdaftar" <?= $filter_status === 'terdaftar' ? 'selected' : ''?>>Terdaftar</option>
                                            <option value="lulus" <?= $filter_status === 'lulus' ? 'selected' : ''?>>Lulus</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/zpanel/user/scholarship" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </tr>
                            </form>

                            <?php
                            $no = ($current_page - 1) * $per_page + 1;

foreach ($scholarships as $scholarship) :
    ?>
                                <tr>
                                    <!-- use numbering -->
                                    <td width="5%"><?= $no++ ?></td>
                                    <td><?= $scholarship->fullname ?></td>
                                    <td><?= $scholarship->email ?></td>
                                    <td><?= $scholarship->program ?? '-' ?></td>
                                    <!-- use badge status -->
                                    <td>
                                        <?php if ($scholarship->status === 'terdaftar'): ?>
                                            <span class="badge bg-primary">Terdaftar</span>
                                        <?php elseif ($scholarship->status === 'lulus'): ?>
                                            <span class="badge bg-success">Lulus</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($scholarship->created_at)) ?></td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <?php if ($scholarship->status !== 'active'): ?>
                                                <!-- <a class="btn btn-sm btn-outline-success text-nowrap"
                                           href="/zpanel/user/activate/<?= $scholarship->id ?>"
                                           onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')">
                                            <span class="bi bi-star"></span> Activate
                                        </a> -->
                                            <?php endif; ?>

                                            <a class="btn btn-sm btn-outline-secondary text-nowrap"
                                                href="/zpanel/user/scholarship/form?id=<?= $scholarship->id ?>">
                                                <span class="bi bi-pencil-square"></span> Edit
                                            </a>

                                            <form action="/zpanel/user/scholarship/form/delete" method="post" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                <input type="hidden" name="id" value="<?= $scholarship->id ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger text-nowrap">
                                                    <span class="bi bi-x-lg"></span> Delete
                                                </button>
                                            </form>
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