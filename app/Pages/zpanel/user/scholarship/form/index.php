<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">
        <form method="post" action="<?= isset($user) ? '/zpanel/user/scholarship/form?id=' . $user->id : '/zpanel/user/scholarship/form' ?>">
            <div class="mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><a href="/zpanel/user"><?= $page_title ?></a> • <?= isset($user) ? 'Edit' : 'New' ?></h2>
                        <nav aria-label="breadcrumb" class="breadcrumb-header">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="/zpanel/user">User</a></li>
                                <li class="breadcrumb-item"><a href="/zpanel/user/scholarship">Scholarship</a></li>
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
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Data Pribadi</div>

                        <div class="card-body">
                            <?php if(isset($user)): ?>
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Program <span class="text-danger">*</span></label>
                                <input type="text" name="program" value="<?= $user->program ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" value="<?= $user->fullname ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="<?= $user->email ?? '' ?>" class="form-control" required readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">WhatsApp <span class="text-danger">*</span></label>
                                <small>• Begin with country code, i.e. 62<span style="color:#aaa">8XXXXXXXXX</span></small>
                                <input type="text" name="whatsapp" value="<?= $user->whatsapp ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="birthday" value="<?= $user->birthday ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input type="radio" name="gender" value="male" class="form-check-input" <?= (isset($user) && $user->gender === 'male') ? 'checked' : '' ?> required>
                                    <label class="form-check-label">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="gender" value="female" class="form-check-input" <?= (isset($user) && $user->gender === 'female') ? 'checked' : '' ?> required>
                                    <label class="form-check-label">Perempuan</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="province" value="<?= $user->province ?? '' ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" name="city" value="<?= $user->city ?? '' ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-secondary-subtle border-bottom mb-3 px-3 py-2 h5">Data Pendidikan & Pekerjaan</div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="occupation" value="<?= $user->occupation ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pengalaman Kerja</label>
                                <textarea name="work_experience" class="form-control" rows="3"><?= $user->work_experience ?? '' ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Keahlian</label>
                                <textarea name="skill" class="form-control" rows="3"><?= $user->skill ?? '' ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Institusi Pendidikan</label>
                                <input type="text" name="institution" value="<?= $user->institution ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="major" value="<?= $user->major ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Semester</label>
                                <input type="number" name="semester" value="<?= $user->semester ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">IPK</label>
                                <input type="number" step="0.01" name="grade" value="<?= $user->grade ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Usaha</label>
                                <input type="text" name="type_of_business" value="<?= $user->type_of_business ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenjang Pendidikan</label>
                                <select name="education_level" class="form-control">
                                    <option value="">Pilih...</option>
                                    <option value="SMA" <?= (isset($user) && $user->education_level === 'SMA') ? 'selected' : '' ?>>SMA/SMK</option>
                                    <option value="D3" <?= (isset($user) && $user->education_level === 'D3') ? 'selected' : '' ?>>D3</option>
                                    <option value="S1" <?= (isset($user) && $user->education_level === 'S1') ? 'selected' : '' ?>>S1</option>
                                    <option value="S2" <?= (isset($user) && $user->education_level === 'S2') ? 'selected' : '' ?>>S2</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="number" name="graduation_year" value="<?= $user->graduation_year ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Link Usaha</label>
                                <input type="url" name="link_business" value="<?= $user->link_business ?? '' ?>" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Proyek Terakhir</label>
                                <textarea name="last_project" class="form-control" rows="3"><?= $user->last_project ?? '' ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Referensi</label>
                                <input type="text" name="reference" value="<?= $user->reference ?? '' ?>" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kode Referral</label>
                                <input type="text" name="referral_code" value="<?= $user->referral_code ?? '' ?>" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">Pilih...</option>
                                    <option value="terdaftar" <?= (isset($user) && $user->status === 'terdaftar') ? 'selected' : '' ?>>Terdaftar</option>
                                    <option value="lulus" <?= (isset($user) && $user->status === 'lulus') ? 'selected' : '' ?>>Lulus</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="accept_terms" class="form-check-input" value="<?= $user->accept_terms ?? 1 ?>" <?= (isset($user) && $user->accept_terms) ? 'checked' : '' ?> required>
                                    <label class="form-check-label">Saya menyetujui syarat dan ketentuan</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="accept_agreement" class="form-check-input" value="<?= $user->accept_agreement ?? 1 ?>" <?= (isset($user) && $user->accept_agreement) ? 'checked' : '' ?> required>
                                    <label class="form-check-label">Saya menyetujui perjanjian beasiswa</label>
                                </div>
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