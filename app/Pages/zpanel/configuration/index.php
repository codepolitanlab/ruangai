<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href="/zpanel">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
                <h3><?= $page_title .' - '. $currentSetting['title'] ?></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/zpanel/course/form" class="btn btn-primary me-2"><i class="bi bi-download"></i> Ekspor</a> -->
                <!-- <a href="/zpanel/user/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Pengguna</a> -->
            </div>
        </div>
    </div>

    <section>
        <div class="d-flex">
            <div class="col-md-2 pe-3">
                <div class="list-group rounded-3">
                    <?php foreach ($settingPaths as $settingName => $settingConfig): ?>
                        <a class="list-group-item <?= $settingName == $currentSetting['name'] ? 'active' : '' ?>" href="/zpanel/configuration/<?= $settingName ?>">
                            <?= $settingConfig['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card rounded-xl shadow-sm">
                    <div class="card-body">
                        <?php foreach ($Form->fields as $fieldName => $FieldObject): ?>
                            <div class="form-group">
                                <?= $FieldObject->renderLabel() ?>
                                <?= $FieldObject->renderInput(setting($fieldName), $FieldObject->context ?? null) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->