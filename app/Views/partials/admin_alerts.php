<!-- Alerts -->
<?php if ($errorMsg = session()->getFlashdata('error_message')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <span class="bi bi-exclamation-triangle"></span> <?= $errorMsg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($successMsg = session()->getFlashdata('success_message')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <span class="bi bi-check"></span> <?= $successMsg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($infoMsg = session()->getFlashdata('info_message')): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <span class="bi bi-check"></span> <?= $infoMsg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($warningMsg = session()->getFlashdata('warning_message')): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <span class="bi bi-check"></span> <?= $warningMsg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>