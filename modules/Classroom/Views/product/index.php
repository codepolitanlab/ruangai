<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<?php $this->section('main') ?>

<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/classroom">Classroom</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/classroom/products/add" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Product</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <div class="mb-4">
                    <div class="row mx-1">
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Total Product</strong>
                            <br><?= $total_product ?> product
                        </div>
                    </div>
                </div>

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->get('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->get('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kelas</th>
                                <th>Product Title</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Checkout Expire (menit)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form method="GET">
                                    <td><input type="text" class="form-control form-control-sm" name="filter_id" value="<?= $filter_id ?? '' ?>" placeholder="ID"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_class_name" value="<?= $filter_class_name ?? '' ?>" placeholder="Kelas"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_title" value="<?= $filter_title ?? '' ?>" placeholder="Title"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/<?= urlScope() ?>/classroom/products" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </form>
                            </tr>

                            <?php foreach ($classProducts as $product): ?>
                            <tr>
                                <!-- use numbering -->
                                <td width="5%"><?= $product->id ?></td>
                                <td><?= $product->class_name ?></td>
                                <td>
                                    <div><?= $product->title ?></div>
                                    <span class="text-muted"><?= $product->subtitle ?></span>
                                </td>
                                <td>
                                    <?php if ($product->normal_price !== $product->price) : ?>
                                        <div class="fw-bold text-secondary"><del>Rp<?= number_format($product->normal_price, 0, ',', '.') ?></del></div>
                                    <?php endif ?>
                                    <div class="fw-bold">Rp<?= number_format($product->price, 0, ',', '.') ?></div>
                                </td>
                                <td>
                                    <span class="text-muted">Rp<?= number_format($product->discount, 0, ',', '.') ?></span>
                                </td>
                                <td>
                                    <?php if ((int) $product->status === 1) : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td width="10%"><?= $product->exp_duration ? round($product->exp_duration / 60) : '-' ?></td>
                                <td class="text-end" width="20%">

                                    <?php if ((int) $product->status === 1) : ?>
                                    <a class="btn btn-sm btn-outline-info text-nowrap"
                                        target="_blank"
                                        href="/checkout/class/<?= $product->id ?>">
                                        <span class="bi bi-credit-card"></span> Checkout
                                    </a>
                                    <?php endif; ?>

                                    <a class="btn btn-sm btn-outline-success text-nowrap"
                                        href="/<?= urlScope() ?>/classroom/products/<?= $product->id ?>/edit">
                                        <span class="bi bi-pencil-square"></span> Edit
                                    </a>

                                    <form action="/<?= urlScope() ?>/classroom/products/delete" method="post" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <input type="hidden" name="id" value="<?= $product->id ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger text-nowrap">
                                            <span class="bi bi-x-lg"></span> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <?= $pager->links('default', 'bootstrap') ?>
            </div>
        </div>
</div>

<?php $this->endSection() ?>
