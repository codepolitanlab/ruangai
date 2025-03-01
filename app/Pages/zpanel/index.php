<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">Summary and shortcut</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="index.html">Dashboard</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Table</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h1>Welcome to HeroicAdmin!</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti tenetur expedita perferendis facere ab. Molestias, officia! Laboriosam amet hic recusandae cupiditate dolores nulla, eveniet saepe, corrupti debitis quibusdam velit tempora!</p>
                <a href="#" class="btn btn-primary btn-progress">Processing...</a>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->
