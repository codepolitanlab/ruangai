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
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/user">User</a></li>
                        <li class="breadcrumb-item active">Token</li>

                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/<?= urlScope() ?>/user/token/import" class="btn btn-primary"><i class="bi bi-plus"></i> Generate Token</a>
                <!-- <a href="/<?= urlScope() ?>/course/token/add" class="btn btn-primary"><i class="bi bi-plus"></i> Buat Token</a> -->
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <div class="mb-4">
                    <div class="row mx-1">
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Total</strong>
                            <br><?= $total_token ?> token
                        </div>
                    </div>
                    <a class="resetcache m-2 h5" href="/<?= urlScope() ?>/course/product/reset_cache"><span class="bi bi-arrow-repeat"></span></a>
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
                                <th>Code</th>
                                <th>Name</th>
                                <th>Reward From</th>
                                <th>Claimed At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form method="GET">
                                    <td><input type="text" class="form-control form-control-sm" name="filter_code" value="<?= $filter_code ?? '' ?>"  placeholder="Code"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_name" value="<?= $filter_name ?? '' ?>"  placeholder="Name"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_reward_from" value="<?= $filter_reward_from ?? '' ?>"  placeholder="Reward From"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_claimed_at" value="<?= $filter_claimed_at ?? '' ?>"  placeholder="Claimed At"></td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/<?= urlScope() ?>/user/token" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </form>
                            </tr>

                            <?php foreach ($userRewardTokens as $token): ?>
                                <tr>
                                    <!-- use numbering -->
                                    <td><?= $token->code ?></td>
                                    <td><?= $token->name ?></td>
                                    <td><?= $token->reward_from ?></td>
                                    <td><?= $token->claimed_at ?></td>
                                    
                                    <td class="text-end" width="20%">

                                        <!-- <a class="btn btn-sm btn-outline-success text-nowrap"
                                            href="/<?= urlScope() ?>/course/product/<?= $token->id ?>/edit">
                                            <span class="bi bi-pencil-square"></span> Edit
                                        </a>

                                        <form action="/<?= urlScope() ?>/course/product/delete" method="post" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <input type="hidden" name="id" value="<?= $token->id ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger text-nowrap">
                                                <span class="bi bi-x-lg"></span> Delete
                                            </button>
                                        </form> -->
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