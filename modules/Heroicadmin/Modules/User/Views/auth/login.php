<?php $this->extend('Heroicadmin\Views\_layouts\auth') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<form method="post">
    <div class="form-group position-relative has-icon-left mb-4">
        <input type="text" class="form-control form-control-xl" placeholder="Username" name="identity">
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
        </div>
    </div>
    <div class="form-group position-relative has-icon-left mb-4">
        <input type="password" class="form-control form-control-xl" placeholder="Password" name="password">
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
    </div>
    <div class="form-check form-check-lg d-flex align-items-end">
        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label text-gray-600" for="flexCheckDefault">
            Keep me logged in
        </label>
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
</form>
<div class="text-center mt-5 text-lg fs-4">
    <p><a class="font-bold" href="https://www.ruangai.id/forgot-password">Forgot password?</a></p>
</div>

<?= $this->endSection() ?>