<?= $this->extend('template/mobile') ?>

<!-- START Content Section -->
<?php $this->section('content') ?>

    <!-- Alpinejs Routers -->
    <div id="app" x-data></div>

    <?= $this->include('router') ?>

<?php $this->endSection() ?>
<!-- END Content Section -->