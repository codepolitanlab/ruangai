<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $page_title ?></h3>
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/<?= urlScope() ?>"><i class="bi bi-house-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/scholarship">Events</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Render form -->
<?= $form ?>

<?php $this->endSection() ?>
<!-- END Content Section -->