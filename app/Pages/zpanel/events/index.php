<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/zpanel">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Events</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/zpanel/events/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Event</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <div class="mb-4">
                    <div class="row mx-1">
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Total Events</strong>
                            <br><?= $total_events ?>
                        </div>
                    </div>
                    <a class="resetcache m-2 h5" href="/zpanel/events/reset_cache"><span class="bi bi-arrow-repeat"></span></a>
                </div>

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->get('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Quota</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="GET" action="/zpanel/events">
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_title" value="<?= $filter_title ?? '' ?>" placeholder="Title"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_code" value="<?= $filter_code ?? '' ?>" placeholder="Code"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="filter_description" value="<?= $filter_description ?? '' ?>" placeholder="Description"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="filter_quota" value="<?= $filter_quota ?? '' ?>" placeholder="Quota"></td>
                                    <td></td>
                                    <td>
                                        <select name="filter_status" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            <option value="published" <?= $filter_status === 'published' ? 'selected' : ''?>>Active</option>
                                            <option value="draft" <?= $filter_status === 'draft' ? 'selected' : ''?>>Inactive</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="/zpanel/events" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </td>
                                </tr>
                            </form>

                            <?php
                            $no = ($current_page - 1) * $per_page + 1;

foreach ($events as $event) :
    ?>
                                <tr>
                                    <td width="5%"><?= $no++ ?></td>
                                    <td><?= $event->title ?></td>
                                    <td><?= $event->code ?></td>
                                    <td><?= $event->description ?? '-' ?></td>
                                    <td><?= $event->quota ?? '-' ?></td>
                                    <td><?= date('d M Y', strtotime($event->date_start)) ?> - <?= date('d M Y', strtotime($event->date_end)) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $event->status === 'published' ? 'success' : 'danger'?>">
                                            <?= $event->status === 'published' ? 'Active' : 'Inactive'?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">

                                            <a class="btn btn-sm btn-outline-secondary text-nowrap"
                                                href="/zpanel/events/form?id=<?= $event->id ?>">
                                                <span class="bi bi-pencil-square"></span> Edit
                                            </a>

                                            <form action="/zpanel/events/form/delete" method="post" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <input type="hidden" name="id" value="<?= $event->id ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger text-nowrap">
                                                    <span class="bi bi-x-lg"></span> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <?= $pager->links('default', 'bootstrap') ?>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->