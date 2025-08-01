<!-- Alerts -->
<?php if (session()->has('error_message')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <span class="bi bi-exclamation-triangle"></span> <?= session()->get('error_message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('success_message')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <span class="bi bi-check-circle"></span> <?= session()->get('success_message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('info_message')): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <span class="bi bi-info-circle"></span> <?= session()->get('info_message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('warning_message')): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <span class="bi bi-exclamation-diamond"></span> <?= session()->get('warning_message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>