<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('/ruangpanel'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('/ruangpanel/user/token/'); ?>">Token</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Import</li>
                        </ol>
                    </nav>
                    <h2><a href="/zpanel/user"><?= $page_title ?></a> • <?= isset($event) ? 'Edit' : 'New' ?></h2>
                </div>
            </div>
        </div>

        <!-- Session flashdata error -->
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->get('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!-- Session flashdata success -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->get('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">

            <!-- Form CSV Upload -->
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Import via CSV</div>

                    <form
                        method="post"
                        enctype="multipart/form-data"
                        action="/<?= urlScope() ?>/user/token/generate">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Reward From <span class="text-danger">*</span></label>
                                <input type="text" name="reward_from" value="" class="form-control" required placeholder="Reward From">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Token <span class="text-danger">*</span></label>
                                <input type="number" name="token_amount" value="1" class="form-control" required placeholder="Jumlah Token" min="1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Peruntukan <span class="text-danger">*</span>
                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" 
                                       title="User Umum: Hanya generate token jika user belum pernah menerima token dari reward yang sama. User Khusus: Generate token tanpa pengecekan, user bisa menerima multiple token dari reward yang sama."></i>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="peruntukan" id="userUmum" value="umum" checked>
                                    <label class="form-check-label" for="userUmum">
                                        User Umum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="peruntukan" id="userKhusus" value="khusus">
                                    <label class="form-check-label" for="userKhusus">
                                        User Khusus
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CSV File <span class="text-danger">*</span></label>
                                <p class="text-muted">Format column: <code>email</code></p>
                                <input type="file" name="userfile" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success mb-0"><span class="bi bi-upload"></span> Upload CSV</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Input Email -->
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Generate by Email</div>

                    <form
                        method="post"
                        action="/<?= urlScope() ?>/user/token/generate-by-email">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Reward From <span class="text-danger">*</span></label>
                                <input type="text" name="reward_from" value="" class="form-control" required placeholder="Reward From">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Token <span class="text-danger">*</span></label>
                                <input type="number" name="token_amount" value="1" class="form-control" required placeholder="Jumlah Token" min="1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Peruntukan <span class="text-danger">*</span>
                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" 
                                       title="User Umum: Hanya generate token jika user belum pernah menerima token dari reward yang sama. User Khusus: Generate token tanpa pengecekan, user bisa menerima multiple token dari reward yang sama."></i>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="peruntukan" id="userUmumEmail" value="umum" checked>
                                    <label class="form-check-label" for="userUmumEmail">
                                        User Umum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="peruntukan" id="userKhususEmail" value="khusus">
                                    <label class="form-check-label" for="userKhususEmail">
                                        User Khusus
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required placeholder="user@example.com">
                            </div>

                            <button type="submit" class="btn btn-primary mb-0"><span class="bi bi-plus-circle"></span> Generate Token</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->