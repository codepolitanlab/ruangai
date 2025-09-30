<?php $this->extend('Heroicadmin\Views\_layouts\admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <form method="post">
            <div class="mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><?= isset($course_product) ? 'Edit' : 'New' ?> Course Product</h2>
                        <nav aria-label="breadcrumb" class="breadcrumb-header">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/<?= urlScope() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/course">Course</a></li>
                                <li class="breadcrumb-item"><a href="/<?= urlScope() ?>/course/product">Product</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-end">
                        <button type="submit" class="btn btn-success mb-0"><span class="bi bi-save"></span> Simpan</button>
                    </div>
                </div>
            </div>

            <!-- Session flashdata error -->
            <?php if(session()->has('error')):?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->get('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <!-- Session flashdata success -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Course Product</div>

                        <div class="card-body">
                            <?php if(isset($course_product)): ?>
                            <input type="hidden" name="id" value="<?= $course_product->id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" class="form-control" required>
                                    <option value="">Select..</option>
                                    <?php foreach($courses as $course): ?>
                                    <option value="<?= $course->id ?>" <?= (isset($course_product) && $course_product->course_id === $course->id) ? 'selected' : '' ?>><?= $course->course_title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="<?= $course_product->title ?? '' ?>" class="form-control" placeholder="Title" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subtitle <span class="text-danger">*</span></label>
                                <input type="text" name="subtitle" value="<?= $course_product->subtitle ?? '' ?>" class="form-control" placeholder="Subtitle" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                <input type="text" name="duration" value="<?= $course_product->duration ?? '' ?>" class="form-control" placeholder="Duration" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Normal Price <span class="text-danger">*</span></label>
                                <input type="number" name="normal_price" value="<?= $course_product->normal_price ?? '' ?>" class="form-control" placeholder="Normal Price" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discount <span class="text-danger">*</span></label>
                                <input type="number" name="discount" value="<?= $course_product->discount ?? '' ?>" class="form-control" placeholder="Discount" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" name="price" value="<?= $course_product->price ?? '' ?>" class="form-control" placeholder="Price" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Checkout Expire Duration (in seconds) <span class="text-danger">*</span></label>
                                <input type="number" name="exp_duration" value="<?= $course_product->exp_duration ?? '' ?>" class="form-control" placeholder="Exp duration" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5"><?= $course_product->description ?? '' ?></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card mb-5">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-success mb-0"><span class="bi bi-save"></span> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->