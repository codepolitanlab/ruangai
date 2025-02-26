<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">

    <div class="d-flex mb-4">
       <a href="/admin/user" class="btn btn-white text-success rounded-pill px-4 me-2"><i class="bi bi-person-fill"></i> Pengguna</a>
       <a href="/admin/user/role" class="btn text-success rounded-pill px-4 me-2"><i class="bi bi-person-fill-gear"></i> Peran</a>
    </div>

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/admin/course/form" class="btn btn-primary me-2"><i class="bi bi-download"></i> Ekspor</a>
                <a href="/admin/user/form" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Pengguna</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card rounded-xl shadow">
            <div class="card-body">

                <div class="mb-4">
                    <div class="row mx-1">
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Total Users</strong>
                            <br>141 orang
                        </div>
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Active Users</strong>
                            <br>57 orang
                        </div>
                        <div class="col-12 col-sm-4 text-center border p-2"><strong>Pending/Blocked</strong>
                            <br>84 orang
                        </div>
                    </div>
                    <a class="resetcache m-2 h5" href="/admin/user/reset_cache"><span class="bi bi-arrow-repeat"></span></a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <form></form>
                            <tr>
                                <td><input type="text" class="form-control form-control-sm" name="filter_id" value="" placeholder="id"></td>
                                <td><input type="text" class="form-control form-control-sm" name="filter_name" value="" placeholder="Name"></td>
                                <td><input type="text" class="form-control form-control-sm" name="filter_username" value="" placeholder="Username"></td>
                                <td>
                                    <select name="filter_role_id" class="form-control form-control-sm">
                                        <option value="" selected="selected">all</option>
                                        <option value="1">Super</option>
                                        <option value="2">Writer</option>
                                        <option value="3">Member</option>
                                        <option value="4">Admin</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm" name="filter_email" value="" placeholder="Email"></td>
                                <td></td>
                                <td>
                                    <select name="filter_status" class="form-control form-control-sm">
                                        <option value="" selected="selected">all</option>
                                        <option value="active">active</option>
                                        <option value="inactive">inactive</option>
                                        <option value="temporary">temporary</option>
                                    </select>
                                </td>
                                <td></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="https://madrasahdigital.id/admin/user" class="btn btn-secondary">Reset</a>
                                    </div>
                                </td>
                            </tr>



                            <tr>
                                <td>141</td>
                                <td>Sugeng Riyadi</td>
                                <td>sugengriyadi2810gmailcomakoPx</td>
                                <td>Member</td>
                                <td>sugengriyadi2810@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-25 09:38:00</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/141" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/141"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/141"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>140</td>
                                <td>Halija Pelupessy</td>
                                <td>pelupessyija84gmailcom1vjd8</td>
                                <td>Member</td>
                                <td>pelupessyija84@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-success">active</span>
                                </td>
                                <td>2025-02-24 08:21:27</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-secondary" href="https://madrasahdigital.id/admin/user/edit/140"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/block/140"><span class="bi bi-trash"></span> Block</a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>139</td>
                                <td>sahyani</td>
                                <td>sahyaniyani030786gmailcomT5N62</td>
                                <td>Member</td>
                                <td>sahyaniyani030786@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 20:32:53</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/139" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/139"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/139"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>138</td>
                                <td>fachri adly ghani</td>
                                <td>fachrifachri2703gmailcomJNfIw</td>
                                <td>Member</td>
                                <td>fachrifachri2703@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 11:02:12</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/138" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/138"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/138"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>137</td>
                                <td>FACHRI ADLY GHANI</td>
                                <td>fachrifachri2703gmailcomzDmE1</td>
                                <td>Member</td>
                                <td>fachrifachri2703@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 11:00:23</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/137" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/137"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/137"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>136</td>
                                <td>Ahmat Yuni</td>
                                <td>ahmatyunimadrasahkemenaggoid0rbdw</td>
                                <td>Member</td>
                                <td>ahmatyuni@madrasah.kemenag.go.id</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 10:35:38</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/136" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/136"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/136"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>135</td>
                                <td>Ahmat Yuni</td>
                                <td>ahmatyunimadrasahkemenaggoidBb3EY</td>
                                <td>Member</td>
                                <td>ahmatyuni@madrasah.kemenag.go.id</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 10:33:59</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/135" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/135"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/135"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>134</td>
                                <td>Ahmat Yuni</td>
                                <td>ahmatyunimadrasahkemenaggoidrIugq</td>
                                <td>Member</td>
                                <td>ahmatyuni@madrasah.kemenag.go.id</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 10:28:00</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/134" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/134"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/134"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>133</td>
                                <td>muhajir</td>
                                <td>gurumuhajirgmailcom7XdCe</td>
                                <td>Member</td>
                                <td>gurumuhajir@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-danger">inactive</span>
                                </td>
                                <td>2025-02-21 07:26:48</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-success text-nowrap" href="https://madrasahdigital.id/admin/user/activate/133" onclick="return confirm('Email belum tervalidasi. Lanjutkan aktivasi?')"><span class="bi bi-star"></span> Activate</a>

                                        <a class="btn btn-sm btn-outline-secondary text-nowrap" href="https://madrasahdigital.id/admin/user/edit/133"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger text-nowrap" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/delete/133"><span class="bi bi-x-lg"></span> Delete</a>

                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>132</td>
                                <td>Gumilar Arif Gunawan</td>
                                <td>newgugumgmailcom4dClJ</td>
                                <td>Member</td>
                                <td>new.gugum@gmail.com</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-success">active</span>
                                </td>
                                <td>2025-02-20 09:07:16</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-secondary" href="https://madrasahdigital.id/admin/user/edit/132"><span class="bi bi-pencil-square"></span> Edit</a>

                                        <a class="btn btn-sm btn-outline-danger" onclick="return confirm('are you sure?')" href="https://madrasahdigital.id/admin/user/block/132"><span class="bi bi-trash"></span> Block</a>
                                    </div>
                                </td>
                            </tr>



                        </tbody>
                    </table>

                    <div class="pagination">
                        <strong>1</strong><a href="https://madrasahdigital.id/admin/user/index/2" data-ci-pagination-page="2">2</a><a href="https://madrasahdigital.id/admin/user/index/3" data-ci-pagination-page="3">3</a><a href="https://madrasahdigital.id/admin/user/index/2" data-ci-pagination-page="2" rel="next">&gt;</a><a href="https://madrasahdigital.id/admin/user/index/15" data-ci-pagination-page="15">Terakhir ›</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->