<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div id="zpanel_test" x-data="zpanel_test()">
    <h1>Welcome to zpanel/test</h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="<?= current_url() ?>">
                        <?php foreach ($form as $field) : ?>
                            <div class="form-group">
                                <label for="<?= $field['name'] ?>"><?= $field['label'] ?></label>
                                <?= $field['class']->renderInput() ?>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="border-top mt-4 pt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->