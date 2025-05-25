<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-sm-10 col-md-8 col-xxl-6">

                <div class="mb-4">
                    <h2>New Role Data</h2>
                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/zpanel/user">User</a></li>
                            <li class="breadcrumb-item"><a href="/zpanel/user/role">Role</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form</li>
                        </ol>
                    </nav>
                </div>

                <div class="card p-3 card-block">


                    <form id="post-form" class="slugify" method="post" action="/zpanel/user/role/insert" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="role_name" value="" class="form-control title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role Slug</label>
                            <input type="text" name="role_slug" value="" class="form-control slug" data-referer="title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
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