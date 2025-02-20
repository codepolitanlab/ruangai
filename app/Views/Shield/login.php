<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div id="auth-left">
    <div class="auth-logo text-center">
        <a href="/"><img src="https://image.web.id/images/logo-ruangai.png" style="width: 200px; height: auto;"></a>
    </div>
    <h1 class="auth-title"><?= lang('Auth.login') ?></h1>
    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

    <?php if (session('error') !== null) : ?>
        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
    <?php elseif (session('errors') !== null) : ?>
        <div class="alert alert-danger" role="alert">
            <?php if (is_array(session('errors'))) : ?>
                <?php foreach (session('errors') as $error) : ?>
                    <?= $error ?>
                    <br>
                <?php endforeach ?>
            <?php else : ?>
                <?= session('errors') ?>
            <?php endif ?>
        </div>
    <?php endif ?>

    <?php if (session('message') !== null) : ?>
        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
    <?php endif ?>

    <form action="<?= url_to('login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group position-relative has-icon-left mb-4">
            <input name="email" type="text" class="form-control form-control-xl" placeholder="<?= lang('Auth.email') ?>">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input name="password" type="password" class="form-control form-control-xl" placeholder="<?= lang('Auth.password') ?>">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>

        <!-- Remember me -->
        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
            <div class="form-check form-check-lg d-flex align-items-end">
                <input name="remember" class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" <?php if (old('remember')): ?> checked<?php endif ?>>
                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                    <?= lang('Auth.rememberMe') ?>
                </label>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?= lang('Auth.login') ?></button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
            <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
        <?php endif ?>
        <?php if (setting('Auth.allowRegistration')) : ?>
            <p class="text-center"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
        <?php endif ?>
    </div>
</div>

<?= $this->endSection() ?>