<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <section class="section">
        <?= $this->include('Course\Views\lesson\_header') ?>

        <div class="card card-block block-editor p-3">
            <div class="row">
                <?= $this->include('Course\Views\lesson\_sidebar') ?>

                <div class="col-md-9">
                    <h3 class="mt-2 mb-4"></h3>

                    <div class="text-center mt-5">
                        <h4 class="mb-4">You can start by creating new topic</h4>
                        <a href="<?= site_url(urlScope() . '/course/' . $course['id'] . '/topic') ?>" class="btn btn-primary"><span class="bi bi-plus-circle"></span> Create Topic</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->