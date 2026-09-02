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
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                        <li class="breadcrumb-item active" aria-current="page">Course</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/zpanel/products/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Product</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <div class="mb-4">
                    <div class="row mx-1">
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Total Product</strong>
                            <br><?= $total_course ?> course
                        </div>
                    </div>
                    <a class="resetcache m-2 h5" href="/zpanel/products/course/reset_cache"><span class="bi bi-arrow-repeat"></span></a>
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
                                <th>ID</th>
                                <th>Course</th>
                                <th>Product Title</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Course Duration</th>
                                <th>Checkout Expire (menit)</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form method="GET" action="/zpanel/products/course">
                                    <td><input type="text" class="form-control form-control-sm" name="filter_id" value="<?= $filter_id ?? '' ?>" placeholder="ID"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_course_title" value="<?= $filter_course_title ?? '' ?>" placeholder="Course"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_title" value="<?= $filter_title ?? '' ?>" placeholder="Title"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_subtitle" value="<?= $filter_subtitle ?? '' ?>" placeholder="Subtitle"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_duration" value="<?= $filter_duration ?? '' ?>" placeholder="Duration"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/zpanel/products/course" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </form>
                            </tr>

                            <?php foreach ($courseProducts as $course): ?>
                            <tr>
                                <!-- use numbering -->
                                <td width="5%"><?= $course->id ?></td>
                                <td><?= $course->course_title ?></td>
                                <td>
                                    <div><?= $course->title ?></div>
                                    <span class="text-muted"><?= $course->subtitle ?></span>
                                </td>
                                <td>
                                    <?php if ($course->normal_price !== $course->price) : ?>
                                        <div class="fw-bold text-secondary"><del>Rp<?= number_format($course->normal_price, 0, ',', '.') ?></del></div>
                                    <?php endif ?>
                                    <div class="fw-bold">Rp<?= number_format($course->price, 0, ',', '.') ?></div>
                                </td>
                                <td>
                                    <span class="text-muted">Rp<?= number_format($course->discount, 0, ',', '.') ?></span>
                                </td>
                                <td width="10%"><?= $course->duration ?></td>
                                <td width="10%"><?= $course->exp_duration ? round($course->exp_duration / 60) : '-' ?></td>
                                <td>
                                    <?php if ((int) $course->status === 1) : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end" width="20%">

                                    <?php if ((int) $course->status === 1) : ?>
                                    <a class="btn btn-sm btn-outline-info text-nowrap"
                                        target="_blank"
                                        href="/zpanel/products/course/checkout?id=<?= $course->id ?>">
                                        <span class="bi bi-credit-card"></span> Checkout
                                    </a>
                                    <?php endif; ?>

                                    <a class="btn btn-sm btn-outline-success text-nowrap"
                                        href="/zpanel/products/course/form?id=<?= $course->id ?>">
                                        <span class="bi bi-pencil-square"></span> Edit
                                    </a>

                                    <form action="/zpanel/products/course/form/delete" method="post" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <input type="hidden" name="id" value="<?= $course->id ?>">
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
</section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->