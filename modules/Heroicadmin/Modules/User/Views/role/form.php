<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-sm-10 col-md-8 col-xxl-6">

                <div class="mb-4">
                    <h2><?= isset($role['id']) ? 'Edit' : 'New' ?> Role Data</h2>
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                            <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/user">Users</a></li>
                            <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/user/role">Role Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form</li>
                        </ol>
                    </nav>
                </div>

                <div class="card p-3 card-block">

                    <form id="post-form" class="<?= ! isset($role['id']) ? 'slugify' : '' ?>" method="post" action="/<?= urlScope() ?>/user/role/form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $role['id'] ?? '' ?>">

                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="role_name" value="<?= $role['role_name'] ?? old('role_name') ?>" class="form-control title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role Slug</label>
                            <input type="text" name="role_slug" value="<?= $role['role_slug'] ?? old('role_slug') ?>" class="form-control slug" data-referer="title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option <?= isset($role['status']) && $role['status'] === 'active' ? 'selected' : '' ?> value="active">Active</option>
                                <option <?= isset($role['status']) && $role['status'] === 'inactive' ? 'selected' : '' ?>  value="inactive">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->