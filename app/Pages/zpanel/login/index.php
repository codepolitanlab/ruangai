<?= $this->extend('layouts/admin_auth') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="mb-5">
                <a href="/"><img src="https://image.web.id/images/logo-ruangai.png" style="width: 200px; height: auto;"></a>
            </div>
            <p class="auth-subtitle mb-5">Admin Login</p>

            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert bg-warning text-light"><?= session()->getFlashdata('message') ?></div>
            <?php endif; ?>
            
            <form action="<?= site_url('zpanel/login') ?>" method="post">
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
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p><a class="font-bold" href="https://www.ruangai.id/forgot-password">Forgot password?</a></p>
            </div>
        </div>
    </div>
        
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>

<?= $this->endSection() ?>