<?php $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <form method="post" action="<?= isset($user) ? '/zpanel/user/form?id=' . $user->id : '/zpanel/user/form' ?>">
            <div class="mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><a href="/zpanel/user"><?= $page_title ?></a> • <?= isset($user) ? 'Edit' : 'New' ?></h2>
                        <nav aria-label="breadcrumb" class="breadcrumb-header">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/zpanel/user">User</a></li>
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
            <?php endif;?>
            <!-- Session flashdata success -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Account</div>

                        <div class="card-body">
                            <?php if(isset($user)): ?>
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="<?= $user->name ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="<?= $user->email ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <small>• Begin with country code, i.e. 62<span style="color:#aaa">8XXXXXXXXX</span></small>
                                <input type="text" name="phone" value="<?= $user->phone ?? '' ?>" class="form-control" required>
                            </div>

                            <!-- <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">Select ..</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive/Block</option>
                                </select>
                            </div> -->

                            <div class="mb-3">
                                <label class="form-label">Peran <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-control" required>
                                    <option value="">Select..</option>
                                    <?php foreach($roles as $role): ?>
                                    <option value="<?= $role->id ?>" <?= (isset($user) && $user->role_id == $role->id) ? 'selected' : '' ?>><?= $role->role_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3 mb-3">
                                <label class="form-label">Foto Profil</label>
                                <div class="form-group mb-3">
                                    <div class="input-group mb-3">
                                        <input type="text" id="image_avatar" name="avatar" class="form-control" placeholder="Choose file .." value="" data-caption="Avatar">
                                        <div class="input-group-append">
                                            <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="/filemanager/dialog.php?type=1&amp;field_id=image_avatar&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2" class="input-group-text btn-file-manager">Choose</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="mt-5 pt-4 pb-2 border-top">Password</h4>

                            <div class="mb-3">
                                <label class="form-label">Password <?= isset($user) ? '' : '<span class="text-danger">*</span>' ?></label>
                                <input type="password" name="password" class="form-control" <?= isset($user) ? '' : 'required' ?>>
                                <?php if(isset($user)): ?>
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password <?= isset($user) ? '' : '<span class="text-danger">*</span>' ?></label>
                                <input type="password" name="confirm_password" class="form-control" <?= isset($user) ? '' : 'required' ?>>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Profile</div>

                        <div class="card-body">
                            <!-- <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label><br>
                                <input type="text" data-toggle="datepicker" id="birthday" value="" class="form-control" data-caption="Tanggal Lahir" autocomplete="off">

                                <input type="hidden" id="real_birthday" name="birthday" value="">
                                <script>
                                    $(function() {
                                        $('#birthday').on('change', function() {
                                            let mydate = moment($(this).val(), "DD-MM-YYYY").format("YYYY-MM-DD");
                                            console.log(mydate);
                                            $('#real_birthday').val(mydate);
                                        })
                                    })
                                </script>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Marital</label><br>


                                <select name="status_marital" id="status_marital" class="form-select select2-hidden-accessible" data-caption="Status Marital" tabindex="-1" aria-hidden="true">
                                    <option value="single">single</option>
                                    <option value="nikah">Menikah</option>
                                    <option value="duda">Duda/Janda</option>
                                </select>

                                <script>
                                    $(function() {
                                        $('#loading_status_marital').addClass('sr-only');
                                        $('#dropdown_status_marital').removeClass('sr-only');
                                        $('.form-select').select2();

                                    });
                                </script>


                                <script>
                                    $(function() {
                                        $('.form-select').select2();
                                    });
                                </script>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label><br>
                                <textarea id="address" class="form-control" rows="5" name="address" placeholder=""><?= $user->address ?? '' ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kota/Kabupaten</label><br>
                                <input type="text" id="city" name="city" value="<?= $user->city ?? '' ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan</label><br>
                                <input type="text" id="jobs" name="jobs" value="" placeholder="" class="form-control" data-caption="Pekerjaan" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Record Log</label><br>
                                <label class="align-middle pe-2">No</label>
                                <label class="align-middle switch" id="record_log">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="record_log" value="" data-caption="Record Log">
                                </label>
                                <label class="align-middle ps-2">Yes</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#record_log');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Akun Instagram</label><br>
                                <input type="text" id="akun_ig" name="akun_ig" value="" placeholder="" class="form-control" data-caption="Akun Instagram" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Akun TikTok</label><br>
                                <input type="text" id="akun_tiktok" name="akun_tiktok" value="" placeholder="" class="form-control" data-caption="Akun TikTok" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hobi</label><br>
                                <input type="text" id="hobi" name="hobi" value="" placeholder="" class="form-control" data-caption="Hobi" autocomplete="off">
                            </div> -->
                            <div class="mb-3">
                                <label class="form-label">Nomor Rekening</label><br>
                                <input type="text" id="account_number" name="account_number" value="<?= $user->account_number ?? '' ?>" placeholder="" class="form-control" data-caption="Nomor Rekening" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Bank</label><br>
                                <input type="text" id="bank_name" name="bank_name" value="<?= $user->bank_name ?? '' ?>" placeholder="" class="form-control" data-caption="Nama Bank" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pemilik Rekening</label><br>
                                <input type="text" id="account_name" name="account_name" value="<?= $user->account_name ?? '' ?>" placeholder="Masukan Nama Pemilik Rekening" autocomplete="off" class="form-control">
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