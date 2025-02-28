<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Quizzes</h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <!-- <a href="/admin/course/form" class="btn btn-primary"><i class="bi bi-plus"></i> Create Courses</a> -->
            </div>
        </div>
    </div>

    <section class="section">
        <form action="https://madrasahdigital.id/admin/setting/update/site" method="post">

            <div class="dropright me-3 d-block d-md-none">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><span class="fa fa-list"></span></button>
                <div class="dropdown-menu shadow-lg" aria-labelledby="dropdownMenuButton">
                    <strong class="font-weight-bold dropdown-item">Core Settings</strong>
                    <a class="dropdown-item py-1 active" href="https://madrasahdigital.id/admin/setting/index/site">Site</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/theme">Theme</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/emailer">Emailer</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/app">App Setting</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/plugin">Plugins</a>
                    <div class="dropdown-divider"></div>


                    <strong class="font-weight-bold dropdown-item">Module Settings</strong>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/activity" role="tab" aria-controls="v-pills-activity" aria-selected="false">Activity</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/entry" role="tab" aria-controls="v-pills-entry" aria-selected="false">Entries</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/media" role="tab" aria-controls="v-pills-media" aria-selected="false">File Manager</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/post" role="tab" aria-controls="v-pills-post" aria-selected="false">Posts</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/microblog" role="tab" aria-controls="v-pills-microblog" aria-selected="false">Microblog</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/user" role="tab" aria-controls="v-pills-user" aria-selected="false">Users</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/notifier" role="tab" aria-controls="v-pills-notifier" aria-selected="false">Notifier</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/donation" role="tab" aria-controls="v-pills-donation" aria-selected="false">Campaign</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/membership" role="tab" aria-controls="v-pills-membership" aria-selected="false">Membership</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/payment" role="tab" aria-controls="v-pills-payment" aria-selected="false">Payment</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/product" role="tab" aria-controls="v-pills-product" aria-selected="false">Products</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/referral" role="tab" aria-controls="v-pills-referral" aria-selected="false">Referral</a>
                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/course" role="tab" aria-controls="v-pills-course" aria-selected="false">Courses</a>

                    <a class="dropdown-item py-1 " href="https://madrasahdigital.id/admin/setting/index/downloadable" role="tab" aria-controls="v-pills-downloadable" aria-selected="false">Downloadable</a>

                </div>
            </div>

            <div class="row">
                <div class="nav col-lg-3 col-md-3 col-5 flex-column nav-pills mb-5 ps-2 d-none d-md-flex" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <div class="card rounded-xl shadow">
                        <div class="card-body">

                            <h6 class="font-weight-bold text-info p-2 mb-0 mt-2 border-top border-bottom">Core Settings</h6>
                            <a class="nav-link active" href="https://madrasahdigital.id/admin/setting/index/site">Site</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/theme">Theme</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/emailer">Emailer</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/app">App Setting</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/plugin">Plugins</a>


                            <h6 class="font-weight-bold text-info p-2 mb-0 mt-2 border-top border-bottom">Module Settings</h6>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/activity" role="tab" aria-controls="v-pills-activity" aria-selected="false">Activity</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/entry" role="tab" aria-controls="v-pills-entry" aria-selected="false">Entries</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/media" role="tab" aria-controls="v-pills-media" aria-selected="false">File Manager</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/post" role="tab" aria-controls="v-pills-post" aria-selected="false">Posts</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/microblog" role="tab" aria-controls="v-pills-microblog" aria-selected="false">Microblog</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/user" role="tab" aria-controls="v-pills-user" aria-selected="false">Users</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/notifier" role="tab" aria-controls="v-pills-notifier" aria-selected="false">Notifier</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/donation" role="tab" aria-controls="v-pills-donation" aria-selected="false">Campaign</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/membership" role="tab" aria-controls="v-pills-membership" aria-selected="false">Membership</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/payment" role="tab" aria-controls="v-pills-payment" aria-selected="false">Payment</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/product" role="tab" aria-controls="v-pills-product" aria-selected="false">Products</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/referral" role="tab" aria-controls="v-pills-referral" aria-selected="false">Referral</a>
                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/course" role="tab" aria-controls="v-pills-course" aria-selected="false">Courses</a>

                            <a class="nav-link " href="https://madrasahdigital.id/admin/setting/index/downloadable" role="tab" aria-controls="v-pills-downloadable" aria-selected="false">Downloadable</a>

                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 col-12 tab-content px-3 pt-0" id="v-pills-tabContent">
                    <div class="card rounded-xl shadow mb-5 p-2">
                        <div class="card-body">

                            <div class="row justify-content-between mb-4">
                                <div class="col-md-8 d-flex justify-content-begin mb-4">
                                    <h2 class="text-dark">Settings · Site</h2>
                                </div>
                                <div class="col-md-4 text-end mb-4">
                                    <button type="submit" class="btn btn-lg btn-success rounded shadow-sm"><span class="fa fa-save"></span> Save Settings</button>
                                </div>
                            </div>

                            <div class="tab-pane active" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Website Title </label>
                                    <code>site.site_title</code>

                                    <div>
                                        <input type="text" id="site__site_title" name="site[site_title]" value="Madrasah Digital" placeholder="" class="form-control" data-caption="Website Title" autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Website Description </label>
                                    <code>site.site_desc</code>

                                    <div>
                                        <textarea id="site__site_desc" class="form-control" rows="5" name="site[site_desc]" placeholder="" data-caption="Website Description">Menjadi Generasi Muslim yang Digital-Savvy</textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Site Logo </label>
                                    <code>site.site_logo</code>

                                    <div>
                                        <div class="form-group mb-3">
                                            <div class="input-group mb-3">
                                                <input type="text" id="image_site__site_logo" name="site[site_logo]" class="form-control" placeholder="Choose file .." value="https://madrasahdigital.id//uploads/madrasahdigital/sources/logo-md-landscape-min.png" data-caption="Site Logo">
                                                <div class="input-group-append">
                                                    <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://madrasahdigital.id/filemanager/dialog.php?type=1&amp;field_id=image_site__site_logo&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Site Logo Monochrome </label>
                                    <code>site.site_logo_monochrome</code>

                                    <div>
                                        <div class="form-group mb-3">
                                            <div class="input-group mb-3">
                                                <input type="text" id="image_site__site_logo_monochrome" name="site[site_logo_monochrome]" class="form-control" placeholder="Choose file .." value="https://madrasahdigital.id//uploads/madrasahdigital/sources/logo-md-landscape-min.png" data-caption="Site Logo Monochrome">
                                                <div class="input-group-append">
                                                    <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://madrasahdigital.id/filemanager/dialog.php?type=1&amp;field_id=image_site__site_logo_monochrome&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Site Logo Small </label>
                                    <code>site.site_logo_small</code>

                                    <div>
                                        <div class="form-group mb-3">
                                            <div class="input-group mb-3">
                                                <input type="text" id="image_site__site_logo_small" name="site[site_logo_small]" class="form-control" placeholder="Choose file .." value="https://madrasahdigital.id//uploads/madrasahdigital/sources/favicon-md.png" data-caption="Site Logo Small">
                                                <div class="input-group-append">
                                                    <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://madrasahdigital.id/filemanager/dialog.php?type=1&amp;field_id=image_site__site_logo_small&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Login Cover </label>
                                    <code>site.login_cover</code>

                                    <div>
                                        <div class="form-group mb-3">
                                            <div class="input-group mb-3">
                                                <input type="text" id="image_site__login_cover" name="site[login_cover]" class="form-control" placeholder="Choose file .." value="" data-caption="Login Cover">
                                                <div class="input-group-append">
                                                    <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://madrasahdigital.id/filemanager/dialog.php?type=1&amp;field_id=image_site__login_cover&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2&amp;p=WyJtZWRpYSIsImRlbGV0ZV9maWxlcyIsImNyZWF0ZV9mb2xkZXJzIiwiZGVsZXRlX2ZvbGRlcnMiLCJ1cGxvYWRfZmlsZXMiLCJyZW5hbWVfZmlsZXMiLCJyZW5hbWVfZm9sZGVycyIsImR1cGxpY2F0ZV9maWxlcyIsImV4dHJhY3RfZmlsZXMiLCJjb3B5X2N1dF9maWxlcyIsImNvcHlfY3V0X2RpcnMiLCJjaG1vZF9maWxlcyIsImNobW9kX2RpcnMiLCJwcmV2aWV3X3RleHRfZmlsZXMiLCJlZGl0X3RleHRfZmlsZXMiLCJjcmVhdGVfdGV4dF9maWxlcyIsImRvd25sb2FkX2ZpbGVzIl0=" class="input-group-text btn-file-manager">Choose</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Site Phone </label>
                                    <code>site.phone</code>

                                    <div>
                                        <input type="text" id="site__phone" name="site[phone]" value="087813277822" placeholder="" class="form-control" data-caption="Site Phone" autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Site Address </label>
                                    <code>site.address</code>

                                    <div>
                                        <textarea id="site__address" class="form-control" rows="5" name="site[address]" placeholder="" data-caption="Site Address"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Kontak </label>
                                    <code>site.contact</code>

                                    <div>
                                        <textarea id="site__contact" class="form-control" rows="5" name="site[contact]" placeholder="" data-caption="Kontak"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Koordinat </label>
                                    <code>site.latlong</code>
                                    <p class="small">latitude,longitude (pisahkan dengan koma)</p>

                                    <div>
                                        <input type="text" id="site__latlong" name="site[latlong]" value="" placeholder="" class="form-control" data-caption="Koordinat" autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Currency </label>
                                    <code>site.currency</code>

                                    <div>
                                        <input type="text" id="site__currency" name="site[currency]" value="Rp" placeholder="" class="form-control" data-caption="Currency" autocomplete="off">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Enable Public Registration </label>
                                    <code>site.enable_registration</code>

                                    <div>

                                        <!-- Start load_after -->

                                        <select name="site[enable_registration]" id="site__enable_registration" class="form-select select2-hidden-accessible" data-caption="Enable Public Registration" tabindex="-1" aria-hidden="true">
                                            <option value="on" selected="selected">On</option>
                                            <option value="off">Off</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 892.578px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-site__enable_registration-container"><span class="select2-selection__rendered" id="select2-site__enable_registration-container" title="On">On</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>


                                        <script>
                                            $(function() {
                                                $('#loading_site__enable_registration').addClass('sr-only');
                                                $('#dropdown_site__enable_registration').removeClass('sr-only');
                                                $('.form-select').select2();

                                            });
                                        </script>

                                        <!-- End !load_after -->

                                        <script>
                                            $(function() {
                                                $('.form-select').select2();
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label me-2 fs-5">
                                        Enable Maintenance Mode </label>
                                    <code>site.maintenance_mode</code>
                                    <p class="small">Show under maintenance or coming soon page for public</p>

                                    <div>

                                        <!-- Start load_after -->

                                        <select name="site[maintenance_mode]" id="site__maintenance_mode" class="form-select select2-hidden-accessible" data-caption="Enable Maintenance Mode" tabindex="-1" aria-hidden="true">
                                            <option value="off" selected="selected">Off</option>
                                            <option value="comingsoon">Coming Soon Page</option>
                                            <option value="maintenance">Under Maintenance Page</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 892.578px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-site__maintenance_mode-container"><span class="select2-selection__rendered" id="select2-site__maintenance_mode-container" title="Off">Off</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>


                                        <script>
                                            $(function() {
                                                $('#loading_site__maintenance_mode').addClass('sr-only');
                                                $('#dropdown_site__maintenance_mode').removeClass('sr-only');
                                                $('.form-select').select2();

                                            });
                                        </script>

                                        <!-- End !load_after -->

                                        <script>
                                            $(function() {
                                                $('.form-select').select2();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-5 mb-2">
                                <button type="submit" class="btn btn-lg btn-success rounded shadow-sm"><span class="fa fa-save"></span> Save Settings</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </form>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->