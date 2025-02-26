<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Students</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/admin/course">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow pb-4">
            <div class="card-body table-responsive">

                <p>Total: <b>0</b></p>
                <div class="alert alert-danger" style="display: none;">There is no students ..</div>
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Progress</th>
                            <th>Joined</th>
                            <th width="15%">Last Update</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control form-control-sm" name="filter[name]" value="" placeholder="filter name"></td>
                            <td><input type="text" class="form-control form-control-sm" name="filter[email]" value="" placeholder="filter email"></td>
                            <td><input type="text" class="form-control form-control-sm" name="filter[phone]" value="" placeholder="filter phone"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filter</button>
                                    <a href="https://madrasahdigital.id/admin/course/student/index/1" class="btn btn-sm btn-secondary"><span class="fa fa-refresh"></span> Reset</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination">
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->