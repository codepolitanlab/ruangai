<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<style>
    th.sortable {
        cursor: pointer;
    }

    th.sortable:hover {
        background-color: #e8eaffa4;
    }

    th.sortable.asc:before {
        content: "▲ ";
        color: #ccc;
    }

    th.sortable.desc:before {
        content: "▼ ";
        color: #ccc;
    }
</style>

<div class="page-heading">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $page_title ?></h3>
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-fill"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shortener</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first text-end">
            <a href="/<?= urlScope() ?>/shortener/add" class="btn btn-primary"><i class="bi bi-plus"></i>
                Tambah
                Shortener</a>
        </div>
    </div>
</div>

<!-- Render entry table -->
<?= $table ?>

<?php $this->endSection() ?>
<!-- END Content Section -->