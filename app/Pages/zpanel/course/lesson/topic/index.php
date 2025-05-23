<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">


    <section class="section">
        <?= $this->include('zpanel/course/lesson/_header') ?>

        <div class="card card-block block-editor p-3">
            <div class="row">
                <?= $this->include('zpanel/course/lesson/_sidebar') ?>

                <div class="col-md-9 px-4">
                    <h3 class="mt-2 mb-4">🏷️ <?= isset($topic) ? 'Edit Topic' : 'New Topic' ?></h3>

                    <form action="<?= site_url('/zpanel/course/lesson/topic/'.$course['id']. '/' . ($topic['id'] ?? '')) ?>" method="POST" class="p-2">
                        <div class="row mb-3">
                            <input type="hidden" name="topic_order" value="10">
                            <div class="col-7">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="topic_title" name="topic_title" placeholder="Judul Topik" value="<?= $topic['topic_title'] ?? '' ?>">
                            </div>
                        </div>

                        <div class="d-flex justify-content-start">
                            <div class="pe-5">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" value="1" name="status" type="checkbox" role="switch" id="topic_status" <?= ($topic['status'] ?? null) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="topic_status">Publish Topic?</label>
                                </div>
                            </div>
                            <div class="pe-5">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" value="1" name="free" type="checkbox" role="switch" id="topic_free" <?= ($topic['free'] ?? null) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="topic_free">Is Topic Free?</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 pt-3 border-top">
                            <div class="col-6">
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn btn-secondary" href="<?= site_url('/zpanel/course/lesson/'.$course['id']) ?>"><span class="fa fa-arrow-left"></span> Cancel</a>
                                <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save Topic</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->