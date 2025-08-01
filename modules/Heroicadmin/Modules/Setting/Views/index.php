<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<style>
    .nav .dropdown-item {
        display: block;
        border-radius: var(--bs-nav-pills-border-radius);
        padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
        font-size: var(--bs-nav-link-font-size);
        font-weight: var(--bs-nav-link-font-weight);
        color: var(--bs-nav-link-color);
        text-decoration: none;
        background: none;
        border: 0;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
    }
    .nav .dropdown-item.active {
        color: var(--bs-nav-pills-link-active-color);
        background-color: var(--bs-nav-pills-link-active-bg);
        box-shadow: 0 2px 10px rgba(67, 94, 190, .5);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
</style>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/zpanel/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a> -->
            </div>
        </div>
    </div>

    <section class="section">
        <form method="post">

            <div class="row">
                <!-- Sidebar untuk desktop -->
                <div class="nav col-lg-3 col-md-3 col-5 flex-column nav-pills mb-5 ps-2 d-none d-md-flex" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <div class="card rounded-xl shadow">
                        <div class="card-body">
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?= $this->include('Heroicadmin\Modules\Setting\Views\menu') ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Dropdown menu untuk mobile -->
                <div class="d-md-none mb-3 px-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu Setting
                        </button>
                        <ul class="dropdown-menu w-100 overflow-auto" aria-labelledby="mobileMenuButton" style="max-height: 200px;">
                            <?= $this->include('Heroicadmin\Modules\Setting\Views\menu') ?>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-9 col-md-9 col-12 tab-content px-3 pt-0" id="v-pills-tabContent">
                    <div class="card rounded-xl shadow mb-5 p-2">
                        <div class="card-body">

                            <div class="row justify-content-between mb-4">
                                <div class="col-md-8 d-flex justify-content-begin mb-4">
                                    <h2 class="text-dark"><?= $schemas[$current]->title ?></h2>
                                </div>
                                <div class="col-md-4 text-end mb-4">
                                    <button type="submit" class="btn btn-success rounded shadow-sm"><span class="bi bi-save"></span> Save</button>
                                </div>
                            </div>

                            <div class="tab-pane active" role="tabpanel">
                                <?= $form ?>
                            </div>

                            <div class="text-end mt-5 mb-2">
                                <button type="submit" class="btn btn-success rounded shadow-sm"><span class="bi bi-save"></span> Save</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </form>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->