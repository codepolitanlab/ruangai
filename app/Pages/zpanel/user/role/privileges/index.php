<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <section class="section">


        <div class="mb-4">
            <h2><?= $page_title ?></h2>
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/zpanel/user">User</a></li>
                    <li class="breadcrumb-item"><a href="/zpanel/user/role">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privileges</li>
                </ol>
            </nav>
        </div>

        <div class="card p-3 card-block">

            <form id="post-form" method="post" action="/zpanel/user/role/update_role_privileges" enctype="multipart/form-data">

                <div class="pb-2 text-end">
                    <button type="submit" class="btn btn-outline-success btn-lg"><span class="bi bi-save"></span> Update</button>
                </div>

                <input type="hidden" name="role_id" value="2">

                <div class="form-group mb-4">
                    <h4>Peran</h4>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="2" selected="selected">Writer</option>
                        <option value="3">Member</option>
                        <option value="4">Admin</option>
                    </select>
                </div>

                <div class="form-group">

                    <h4 class="mb-4 bg-info text-white p-2">Hak Akses Modul</h4>
                    <div class="modules">


                        <div class="mb-4 module">
                            <h4>Riwayat Aktivitas</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="activity-settings" value="activity.settings">
                                <label class="form-check-label" for="activity-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Banner</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="banner-show" value="banner.show">
                                <label class="form-check-label" for="banner-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="banner-add" value="banner.add">
                                <label class="form-check-label" for="banner-add">add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="banner-edit" value="banner.edit">
                                <label class="form-check-label" for="banner-edit">edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="banner-delete" value="banner.delete">
                                <label class="form-check-label" for="banner-delete">delete</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Beranda</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="dashboard-dashboard" value="dashboard.dashboard">
                                <label class="form-check-label" for="dashboard-dashboard">dashboard</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Development</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="development-show" value="development.show">
                                <label class="form-check-label" for="development-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="development-generate" value="development.generate">
                                <label class="form-check-label" for="development-generate">generate</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="development-migrate" value="development.migrate">
                                <label class="form-check-label" for="development-migrate">migrate</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="development-migrateAll" value="development.migrateAll">
                                <label class="form-check-label" for="development-migrateAll">migrateAll</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="development-enable" value="development.enable">
                                <label class="form-check-label" for="development-enable">enable</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="development-disable" value="development.disable">
                                <label class="form-check-label" for="development-disable">disable</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Entry</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="entry-show" value="entry.show">
                                <label class="form-check-label" for="entry-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="entry-enable" value="entry.enable">
                                <label class="form-check-label" for="entry-enable">enable</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="entry-build_table" value="entry.build_table">
                                <label class="form-check-label" for="entry-build_table">build_table</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="entry-build_view" value="entry.build_view">
                                <label class="form-check-label" for="entry-build_view">build_view</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="entry-settings" value="entry.settings">
                                <label class="form-check-label" for="entry-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Media</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-media" value="media.media">
                                <label class="form-check-label" for="media-media">media</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-delete_files" value="media.delete_files">
                                <label class="form-check-label" for="media-delete_files">delete_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-create_folders" value="media.create_folders">
                                <label class="form-check-label" for="media-create_folders">create_folders</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-delete_folders" value="media.delete_folders">
                                <label class="form-check-label" for="media-delete_folders">delete_folders</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-upload_files" value="media.upload_files">
                                <label class="form-check-label" for="media-upload_files">upload_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-rename_files" value="media.rename_files">
                                <label class="form-check-label" for="media-rename_files">rename_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-rename_folders" value="media.rename_folders">
                                <label class="form-check-label" for="media-rename_folders">rename_folders</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-duplicate_files" value="media.duplicate_files">
                                <label class="form-check-label" for="media-duplicate_files">duplicate_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-extract_files" value="media.extract_files">
                                <label class="form-check-label" for="media-extract_files">extract_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-copy_cut_files" value="media.copy_cut_files">
                                <label class="form-check-label" for="media-copy_cut_files">copy_cut_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-copy_cut_dirs" value="media.copy_cut_dirs">
                                <label class="form-check-label" for="media-copy_cut_dirs">copy_cut_dirs</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-chmod_files" value="media.chmod_files">
                                <label class="form-check-label" for="media-chmod_files">chmod_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-chmod_dirs" value="media.chmod_dirs">
                                <label class="form-check-label" for="media-chmod_dirs">chmod_dirs</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-preview_text_files" value="media.preview_text_files">
                                <label class="form-check-label" for="media-preview_text_files">preview_text_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-edit_text_files" value="media.edit_text_files">
                                <label class="form-check-label" for="media-edit_text_files">edit_text_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-create_text_files" value="media.create_text_files">
                                <label class="form-check-label" for="media-create_text_files">create_text_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-download_files" value="media.download_files">
                                <label class="form-check-label" for="media-download_files">download_files</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="media-settings" value="media.settings">
                                <label class="form-check-label" for="media-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Navigasi</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation" value="navigation.navigation">
                                <label class="form-check-label" for="navigation-navigation">navigation</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/add_area" value="navigation.navigation/add_area">
                                <label class="form-check-label" for="navigation-navigation/add_area">navigation/add_area</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/edit_area" value="navigation.navigation/edit_area">
                                <label class="form-check-label" for="navigation-navigation/edit_area">navigation/edit_area</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/insert_area" value="navigation.navigation/insert_area">
                                <label class="form-check-label" for="navigation-navigation/insert_area">navigation/insert_area</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/update_area" value="navigation.navigation/update_area">
                                <label class="form-check-label" for="navigation-navigation/update_area">navigation/update_area</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/delete_area" value="navigation.navigation/delete_area">
                                <label class="form-check-label" for="navigation-navigation/delete_area">navigation/delete_area</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/insert_link" value="navigation.navigation/insert_link">
                                <label class="form-check-label" for="navigation-navigation/insert_link">navigation/insert_link</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/update_link" value="navigation.navigation/update_link">
                                <label class="form-check-label" for="navigation-navigation/update_link">navigation/update_link</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/delete_link" value="navigation.navigation/delete_link">
                                <label class="form-check-label" for="navigation-navigation/delete_link">navigation/delete_link</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="navigation-navigation/swap_link" value="navigation.navigation/swap_link">
                                <label class="form-check-label" for="navigation-navigation/swap_link">navigation/swap_link</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Post</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-show" value="post.show">
                                <label class="form-check-label" for="post-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-add" value="post.add">
                                <label class="form-check-label" for="post-add">add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-edit" value="post.edit">
                                <label class="form-check-label" for="post-edit">edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-trash" value="post.trash">
                                <label class="form-check-label" for="post-trash">trash</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-restore" value="post.restore">
                                <label class="form-check-label" for="post-restore">restore</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-set_publish" value="post.set_publish">
                                <label class="form-check-label" for="post-set_publish">set_publish</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-set_draft" value="post.set_draft">
                                <label class="form-check-label" for="post-set_draft">set_draft</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-delete" value="post.delete">
                                <label class="form-check-label" for="post-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-show_pages" value="post.show_pages">
                                <label class="form-check-label" for="post-show_pages">show_pages</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-add_page" value="post.add_page">
                                <label class="form-check-label" for="post-add_page">add_page</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-edit_page" value="post.edit_page">
                                <label class="form-check-label" for="post-edit_page">edit_page</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-delete_page" value="post.delete_page">
                                <label class="form-check-label" for="post-delete_page">delete_page</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-show_categories" value="post.show_categories">
                                <label class="form-check-label" for="post-show_categories">show_categories</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-add_category" value="post.add_category">
                                <label class="form-check-label" for="post-add_category">add_category</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-edit_category" value="post.edit_category">
                                <label class="form-check-label" for="post-edit_category">edit_category</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-delete_category" value="post.delete_category">
                                <label class="form-check-label" for="post-delete_category">delete_category</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-show_tags" value="post.show_tags">
                                <label class="form-check-label" for="post-show_tags">show_tags</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-add_tag" value="post.add_tag">
                                <label class="form-check-label" for="post-add_tag">add_tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-edit_tag" value="post.edit_tag">
                                <label class="form-check-label" for="post-edit_tag">edit_tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-delete_tag" value="post.delete_tag">
                                <label class="form-check-label" for="post-delete_tag">delete_tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="post-settings" value="post.settings">
                                <label class="form-check-label" for="post-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Microblog</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="microblog-settings" value="microblog.settings">
                                <label class="form-check-label" for="microblog-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Pengaturan</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="setting-show" value="setting.show">
                                <label class="form-check-label" for="setting-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="setting-update" value="setting.update">
                                <label class="form-check-label" for="setting-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="setting-show_dev_fields" value="setting.show_dev_fields">
                                <label class="form-check-label" for="setting-show_dev_fields">show_dev_fields</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Pagesetting</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pagesetting-show" value="pagesetting.show">
                                <label class="form-check-label" for="pagesetting-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pagesetting-update" value="pagesetting.update">
                                <label class="form-check-label" for="pagesetting-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pagesetting-show_all_pages" value="pagesetting.show_all_pages">
                                <label class="form-check-label" for="pagesetting-show_all_pages">show_all_pages</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Pengguna</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-show" value="user.show">
                                <label class="form-check-label" for="user-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-add" value="user.add">
                                <label class="form-check-label" for="user-add">add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-edit" value="user.edit">
                                <label class="form-check-label" for="user-edit">edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-delete" value="user.delete">
                                <label class="form-check-label" for="user-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-activate" value="user.activate">
                                <label class="form-check-label" for="user-activate">activate</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-block" value="user.block">
                                <label class="form-check-label" for="user-block">block</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-purge" value="user.purge">
                                <label class="form-check-label" for="user-purge">purge</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-export" value="user.export">
                                <label class="form-check-label" for="user-export">export</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-show_role" value="user.show_role">
                                <label class="form-check-label" for="user-show_role">show_role</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-add_role" value="user.add_role">
                                <label class="form-check-label" for="user-add_role">add_role</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-edit_role" value="user.edit_role">
                                <label class="form-check-label" for="user-edit_role">edit_role</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-delete_role" value="user.delete_role">
                                <label class="form-check-label" for="user-delete_role">delete_role</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-set_role" value="user.set_role">
                                <label class="form-check-label" for="user-set_role">set_role</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-manage_privileges" value="user.manage_privileges">
                                <label class="form-check-label" for="user-manage_privileges">manage_privileges</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user-settings" value="user.settings">
                                <label class="form-check-label" for="user-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Cari</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="search-settings" value="search.settings">
                                <label class="form-check-label" for="search-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Notifier</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="notifier-settings" value="notifier.settings">
                                <label class="form-check-label" for="notifier-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Porter</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="porter-read" value="porter.read">
                                <label class="form-check-label" for="porter-read">read</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Variable</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="variable-variable" value="variable.variable">
                                <label class="form-check-label" for="variable-variable">variable</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="variable-variable/add" value="variable.variable/add">
                                <label class="form-check-label" for="variable-variable/add">variable/add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="variable-variable/edit" value="variable.variable/edit">
                                <label class="form-check-label" for="variable-variable/edit">variable/edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="variable-variable/insert" value="variable.variable/insert">
                                <label class="form-check-label" for="variable-variable/insert">variable/insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="variable-variable/update" value="variable.variable/update">
                                <label class="form-check-label" for="variable-variable/update">variable/update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="variable-variable/delete" value="variable.variable/delete">
                                <label class="form-check-label" for="variable-variable/delete">variable/delete</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Notification</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="notification-notification" value="notification.notification">
                                <label class="form-check-label" for="notification-notification">notification</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="notification-notification/send" value="notification.notification/send">
                                <label class="form-check-label" for="notification-notification/send">notification/send</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Donation</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation-settings" value="donation.settings">
                                <label class="form-check-label" for="donation-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Membership</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership-membership" value="membership.membership">
                                <label class="form-check-label" for="membership-membership">membership</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership-membership/sync_daily_credit" value="membership.membership/sync_daily_credit">
                                <label class="form-check-label" for="membership-membership/sync_daily_credit">membership/sync_daily_credit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership-settings" value="membership.settings">
                                <label class="form-check-label" for="membership-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Transaksi</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order" value="payment.payment/order">
                                <label class="form-check-label" for="payment-payment/order">payment/order</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/anonymous" value="payment.payment/order/anonymous">
                                <label class="form-check-label" for="payment-payment/order/anonymous">payment/order/anonymous</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/detail" value="payment.payment/order/detail">
                                <label class="form-check-label" for="payment-payment/order/detail">payment/order/detail</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/add" value="payment.payment/order/add">
                                <label class="form-check-label" for="payment-payment/order/add">payment/order/add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/insert" value="payment.payment/order/insert">
                                <label class="form-check-label" for="payment-payment/order/insert">payment/order/insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/delete" value="payment.payment/order/delete">
                                <label class="form-check-label" for="payment-payment/order/delete">payment/order/delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/print" value="payment.payment/order/print">
                                <label class="form-check-label" for="payment-payment/order/print">payment/order/print</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/order/updateStatus" value="payment.payment/order/updateStatus">
                                <label class="form-check-label" for="payment-payment/order/updateStatus">payment/order/updateStatus</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/coupon" value="payment.payment/coupon">
                                <label class="form-check-label" for="payment-payment/coupon">payment/coupon</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/voucher" value="payment.payment/voucher">
                                <label class="form-check-label" for="payment-payment/voucher">payment/voucher</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/confirmation" value="payment.payment/confirmation">
                                <label class="form-check-label" for="payment-payment/confirmation">payment/confirmation</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-payment/follow_up" value="payment.payment/follow_up">
                                <label class="form-check-label" for="payment-payment/follow_up">payment/follow_up</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-pay_with_cash" value="payment.pay_with_cash">
                                <label class="form-check-label" for="payment-pay_with_cash">pay_with_cash</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="payment-settings" value="payment.settings">
                                <label class="form-check-label" for="payment-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Product</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product" value="product.product">
                                <label class="form-check-label" for="product-product">product</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/add" value="product.product/add">
                                <label class="form-check-label" for="product-product/add">product/add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/insert" value="product.product/insert">
                                <label class="form-check-label" for="product-product/insert">product/insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/edit" value="product.product/edit">
                                <label class="form-check-label" for="product-product/edit">product/edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/update" value="product.product/update">
                                <label class="form-check-label" for="product-product/update">product/update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/delete" value="product.product/delete">
                                <label class="form-check-label" for="product-product/delete">product/delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/subscribers" value="product.product/subscribers">
                                <label class="form-check-label" for="product-product/subscribers">product/subscribers</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/subscribers/expiry" value="product.product/subscribers/expiry">
                                <label class="form-check-label" for="product-product/subscribers/expiry">product/subscribers/expiry</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/subscribers/detail" value="product.product/subscribers/detail">
                                <label class="form-check-label" for="product-product/subscribers/detail">product/subscribers/detail</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/subscribers/remove" value="product.product/subscribers/remove">
                                <label class="form-check-label" for="product-product/subscribers/remove">product/subscribers/remove</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-product/subscribers/publish" value="product.product/subscribers/publish">
                                <label class="form-check-label" for="product-product/subscribers/publish">product/subscribers/publish</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product-settings" value="product.settings">
                                <label class="form-check-label" for="product-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Referral</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral-settings" value="referral.settings">
                                <label class="form-check-label" for="referral-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Author</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="author-author" value="author.author">
                                <label class="form-check-label" for="author-author">author</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="author-author/revenue" value="author.author/revenue">
                                <label class="form-check-label" for="author-author/revenue">author/revenue</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Course</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-show" value="course.show">
                                <label class="form-check-label" for="course-show">show</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-add" value="course.add">
                                <label class="form-check-label" for="course-add">add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-edit" value="course.edit">
                                <label class="form-check-label" for="course-edit">edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-delete" value="course.delete">
                                <label class="form-check-label" for="course-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-preview" value="course.preview">
                                <label class="form-check-label" for="course-preview">preview</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-show_lessons" value="course.show_lessons">
                                <label class="form-check-label" for="course-show_lessons">show_lessons</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-save_topic" value="course.save_topic">
                                <label class="form-check-label" for="course-save_topic">save_topic</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-move_topic" value="course.move_topic">
                                <label class="form-check-label" for="course-move_topic">move_topic</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-add_lesson" value="course.add_lesson">
                                <label class="form-check-label" for="course-add_lesson">add_lesson</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-edit_lesson" value="course.edit_lesson">
                                <label class="form-check-label" for="course-edit_lesson">edit_lesson</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-delete_lesson" value="course.delete_lesson">
                                <label class="form-check-label" for="course-delete_lesson">delete_lesson</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-move_lesson" value="course.move_lesson">
                                <label class="form-check-label" for="course-move_lesson">move_lesson</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-show_paths" value="course.show_paths">
                                <label class="form-check-label" for="course-show_paths">show_paths</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-add_path" value="course.add_path">
                                <label class="form-check-label" for="course-add_path">add_path</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-edit_path" value="course.edit_path">
                                <label class="form-check-label" for="course-edit_path">edit_path</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-delete_path" value="course.delete_path">
                                <label class="form-check-label" for="course-delete_path">delete_path</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-manage_path_courses" value="course.manage_path_courses">
                                <label class="form-check-label" for="course-manage_path_courses">manage_path_courses</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-show_students" value="course.show_students">
                                <label class="form-check-label" for="course-show_students">show_students</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-show_labels" value="course.show_labels">
                                <label class="form-check-label" for="course-show_labels">show_labels</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course-settings" value="course.settings">
                                <label class="form-check-label" for="course-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Forum</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread" value="forum.forum/thread">
                                <label class="form-check-label" for="forum-forum/thread">forum/thread</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/add" value="forum.forum/thread/add">
                                <label class="form-check-label" for="forum-forum/thread/add">forum/thread/add</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/edit" value="forum.forum/thread/edit">
                                <label class="form-check-label" for="forum-forum/thread/edit">forum/thread/edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/insert" value="forum.forum/thread/insert">
                                <label class="form-check-label" for="forum-forum/thread/insert">forum/thread/insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/update" value="forum.forum/thread/update">
                                <label class="form-check-label" for="forum-forum/thread/update">forum/thread/update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/delete" value="forum.forum/thread/delete">
                                <label class="form-check-label" for="forum-forum/thread/delete">forum/thread/delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/mark" value="forum.forum/thread/mark">
                                <label class="form-check-label" for="forum-forum/thread/mark">forum/thread/mark</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/thread/remove" value="forum.forum/thread/remove">
                                <label class="form-check-label" for="forum-forum/thread/remove">forum/thread/remove</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply" value="forum.forum/reply">
                                <label class="form-check-label" for="forum-forum/reply">forum/reply</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply/edit" value="forum.forum/reply/edit">
                                <label class="form-check-label" for="forum-forum/reply/edit">forum/reply/edit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply/update" value="forum.forum/reply/update">
                                <label class="form-check-label" for="forum-forum/reply/update">forum/reply/update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply/approve" value="forum.forum/reply/approve">
                                <label class="form-check-label" for="forum-forum/reply/approve">forum/reply/approve</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply/unapprove" value="forum.forum/reply/unapprove">
                                <label class="form-check-label" for="forum-forum/reply/unapprove">forum/reply/unapprove</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply/convert" value="forum.forum/reply/convert">
                                <label class="form-check-label" for="forum-forum/reply/convert">forum/reply/convert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/reply/remove" value="forum.forum/reply/remove">
                                <label class="form-check-label" for="forum-forum/reply/remove">forum/reply/remove</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/comment" value="forum.forum/comment">
                                <label class="form-check-label" for="forum-forum/comment">forum/comment</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/comment/remove" value="forum.forum/comment/remove">
                                <label class="form-check-label" for="forum-forum/comment/remove">forum/comment/remove</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/comment/update" value="forum.forum/comment/update">
                                <label class="form-check-label" for="forum-forum/comment/update">forum/comment/update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/flag" value="forum.forum/flag">
                                <label class="form-check-label" for="forum-forum/flag">forum/flag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="forum-forum/flag/insert" value="forum.forum/flag/insert">
                                <label class="form-check-label" for="forum-forum/flag/insert">forum/flag/insert</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Quiz</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-read" value="quiz.read">
                                <label class="form-check-label" for="quiz-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-insert" value="quiz.insert">
                                <label class="form-check-label" for="quiz-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-update" value="quiz.update">
                                <label class="form-check-label" for="quiz-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-delete" value="quiz.delete">
                                <label class="form-check-label" for="quiz-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-preview" value="quiz.preview">
                                <label class="form-check-label" for="quiz-preview">preview</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-manage_questions" value="quiz.manage_questions">
                                <label class="form-check-label" for="quiz-manage_questions">manage_questions</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-see_students" value="quiz.see_students">
                                <label class="form-check-label" for="quiz-see_students">see_students</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-delete_student" value="quiz.delete_student">
                                <label class="form-check-label" for="quiz-delete_student">delete_student</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-see_result" value="quiz.see_result">
                                <label class="form-check-label" for="quiz-see_result">see_result</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz-see_result_answer" value="quiz.see_result_answer">
                                <label class="form-check-label" for="quiz-see_result_answer">see_result_answer</label>
                            </div>
                        </div>


                    </div>

                </div>

                <div class="form-group">

                    <h4 class="mb-4 bg-info text-white p-2">Hak Akses Entri</h4>
                    <div class="modules">


                        <div class="mb-4 module">
                            <h4>Riwayat Aktivitas</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="activity_log-read" value="activity_log.read">
                                <label class="form-check-label" for="activity_log-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="activity_log-insert" value="activity_log.insert">
                                <label class="form-check-label" for="activity_log-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="activity_log-update" value="activity_log.update">
                                <label class="form-check-label" for="activity_log-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="activity_log-delete" value="activity_log.delete">
                                <label class="form-check-label" for="activity_log-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="activity_log-export_csv" value="activity_log.export_csv">
                                <label class="form-check-label" for="activity_log-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Featured</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="featured-read" value="featured.read">
                                <label class="form-check-label" for="featured-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="featured-insert" value="featured.insert">
                                <label class="form-check-label" for="featured-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="featured-update" value="featured.update">
                                <label class="form-check-label" for="featured-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="featured-delete" value="featured.delete">
                                <label class="form-check-label" for="featured-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="featured-export_csv" value="featured.export_csv">
                                <label class="form-check-label" for="featured-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Micropost</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="micropost-read" value="micropost.read">
                                <label class="form-check-label" for="micropost-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="micropost-insert" value="micropost.insert">
                                <label class="form-check-label" for="micropost-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="micropost-update" value="micropost.update">
                                <label class="form-check-label" for="micropost-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="micropost-delete" value="micropost.delete">
                                <label class="form-check-label" for="micropost-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="micropost-export_csv" value="micropost.export_csv">
                                <label class="form-check-label" for="micropost-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>User Profile</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user_profile-read" value="user_profile.read">
                                <label class="form-check-label" for="user_profile-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user_profile-insert" value="user_profile.insert">
                                <label class="form-check-label" for="user_profile-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user_profile-update" value="user_profile.update">
                                <label class="form-check-label" for="user_profile-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user_profile-delete" value="user_profile.delete">
                                <label class="form-check-label" for="user_profile-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="user_profile-export_csv" value="user_profile.export_csv">
                                <label class="form-check-label" for="user_profile-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Importer</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="importer-read" value="importer.read">
                                <label class="form-check-label" for="importer-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="importer-insert" value="importer.insert">
                                <label class="form-check-label" for="importer-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="importer-update" value="importer.update">
                                <label class="form-check-label" for="importer-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="importer-delete" value="importer.delete">
                                <label class="form-check-label" for="importer-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="importer-export_csv" value="importer.export_csv">
                                <label class="form-check-label" for="importer-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Exporter</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exporter-read" value="exporter.read">
                                <label class="form-check-label" for="exporter-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exporter-insert" value="exporter.insert">
                                <label class="form-check-label" for="exporter-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exporter-update" value="exporter.update">
                                <label class="form-check-label" for="exporter-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exporter-delete" value="exporter.delete">
                                <label class="form-check-label" for="exporter-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exporter-export_csv" value="exporter.export_csv">
                                <label class="form-check-label" for="exporter-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Donation Category</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_category-read" value="donation_category.read">
                                <label class="form-check-label" for="donation_category-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_category-insert" value="donation_category.insert">
                                <label class="form-check-label" for="donation_category-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_category-update" value="donation_category.update">
                                <label class="form-check-label" for="donation_category-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_category-delete" value="donation_category.delete">
                                <label class="form-check-label" for="donation_category-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_category-export_csv" value="donation_category.export_csv">
                                <label class="form-check-label" for="donation_category-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Donation Partner</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_partner-read" value="donation_partner.read">
                                <label class="form-check-label" for="donation_partner-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_partner-insert" value="donation_partner.insert">
                                <label class="form-check-label" for="donation_partner-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_partner-update" value="donation_partner.update">
                                <label class="form-check-label" for="donation_partner-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_partner-delete" value="donation_partner.delete">
                                <label class="form-check-label" for="donation_partner-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_partner-export_csv" value="donation_partner.export_csv">
                                <label class="form-check-label" for="donation_partner-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Donation Progress</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_progress-read" value="donation_progress.read">
                                <label class="form-check-label" for="donation_progress-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_progress-insert" value="donation_progress.insert">
                                <label class="form-check-label" for="donation_progress-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_progress-update" value="donation_progress.update">
                                <label class="form-check-label" for="donation_progress-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_progress-delete" value="donation_progress.delete">
                                <label class="form-check-label" for="donation_progress-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_progress-export_csv" value="donation_progress.export_csv">
                                <label class="form-check-label" for="donation_progress-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Campaign</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="campaign-read" value="campaign.read">
                                <label class="form-check-label" for="campaign-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="campaign-insert" value="campaign.insert">
                                <label class="form-check-label" for="campaign-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="campaign-update" value="campaign.update">
                                <label class="form-check-label" for="campaign-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="campaign-delete" value="campaign.delete">
                                <label class="form-check-label" for="campaign-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="campaign-export_csv" value="campaign.export_csv">
                                <label class="form-check-label" for="campaign-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Donation Donor</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_donor-read" value="donation_donor.read">
                                <label class="form-check-label" for="donation_donor-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_donor-insert" value="donation_donor.insert">
                                <label class="form-check-label" for="donation_donor-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_donor-update" value="donation_donor.update">
                                <label class="form-check-label" for="donation_donor-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_donor-delete" value="donation_donor.delete">
                                <label class="form-check-label" for="donation_donor-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="donation_donor-export_csv" value="donation_donor.export_csv">
                                <label class="form-check-label" for="donation_donor-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Membership Product</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership_product-read" value="membership_product.read">
                                <label class="form-check-label" for="membership_product-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership_product-insert" value="membership_product.insert">
                                <label class="form-check-label" for="membership_product-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership_product-update" value="membership_product.update">
                                <label class="form-check-label" for="membership_product-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership_product-delete" value="membership_product.delete">
                                <label class="form-check-label" for="membership_product-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="membership_product-export_csv" value="membership_product.export_csv">
                                <label class="form-check-label" for="membership_product-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Voucher</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="voucher-read" value="voucher.read">
                                <label class="form-check-label" for="voucher-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="voucher-insert" value="voucher.insert">
                                <label class="form-check-label" for="voucher-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="voucher-update" value="voucher.update">
                                <label class="form-check-label" for="voucher-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="voucher-delete" value="voucher.delete">
                                <label class="form-check-label" for="voucher-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="voucher-export_csv" value="voucher.export_csv">
                                <label class="form-check-label" for="voucher-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Product Category</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_category-read" value="product_category.read">
                                <label class="form-check-label" for="product_category-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_category-insert" value="product_category.insert">
                                <label class="form-check-label" for="product_category-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_category-update" value="product_category.update">
                                <label class="form-check-label" for="product_category-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_category-delete" value="product_category.delete">
                                <label class="form-check-label" for="product_category-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_category-export_csv" value="product_category.export_csv">
                                <label class="form-check-label" for="product_category-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Product Meta Default</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_meta_default-read" value="product_meta_default.read">
                                <label class="form-check-label" for="product_meta_default-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_meta_default-insert" value="product_meta_default.insert">
                                <label class="form-check-label" for="product_meta_default-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_meta_default-update" value="product_meta_default.update">
                                <label class="form-check-label" for="product_meta_default-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_meta_default-delete" value="product_meta_default.delete">
                                <label class="form-check-label" for="product_meta_default-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_meta_default-export_csv" value="product_meta_default.export_csv">
                                <label class="form-check-label" for="product_meta_default-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Stock Log</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="stock_log-read" value="stock_log.read">
                                <label class="form-check-label" for="stock_log-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="stock_log-insert" value="stock_log.insert">
                                <label class="form-check-label" for="stock_log-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="stock_log-update" value="stock_log.update">
                                <label class="form-check-label" for="stock_log-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="stock_log-delete" value="stock_log.delete">
                                <label class="form-check-label" for="stock_log-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="stock_log-export_csv" value="stock_log.export_csv">
                                <label class="form-check-label" for="stock_log-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Product Content</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_content-read" value="product_content.read">
                                <label class="form-check-label" for="product_content-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_content-insert" value="product_content.insert">
                                <label class="form-check-label" for="product_content-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_content-update" value="product_content.update">
                                <label class="form-check-label" for="product_content-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_content-delete" value="product_content.delete">
                                <label class="form-check-label" for="product_content-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_content-export_csv" value="product_content.export_csv">
                                <label class="form-check-label" for="product_content-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Product Photo</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_photo-read" value="product_photo.read">
                                <label class="form-check-label" for="product_photo-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_photo-insert" value="product_photo.insert">
                                <label class="form-check-label" for="product_photo-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_photo-update" value="product_photo.update">
                                <label class="form-check-label" for="product_photo-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_photo-delete" value="product_photo.delete">
                                <label class="form-check-label" for="product_photo-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_photo-export_csv" value="product_photo.export_csv">
                                <label class="form-check-label" for="product_photo-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Product Item</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_item-read" value="product_item.read">
                                <label class="form-check-label" for="product_item-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_item-insert" value="product_item.insert">
                                <label class="form-check-label" for="product_item-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_item-update" value="product_item.update">
                                <label class="form-check-label" for="product_item-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_item-delete" value="product_item.delete">
                                <label class="form-check-label" for="product_item-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="product_item-export_csv" value="product_item.export_csv">
                                <label class="form-check-label" for="product_item-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Referral Partner</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_partner-read" value="referral_partner.read">
                                <label class="form-check-label" for="referral_partner-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_partner-insert" value="referral_partner.insert">
                                <label class="form-check-label" for="referral_partner-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_partner-update" value="referral_partner.update">
                                <label class="form-check-label" for="referral_partner-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_partner-delete" value="referral_partner.delete">
                                <label class="form-check-label" for="referral_partner-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_partner-export_csv" value="referral_partner.export_csv">
                                <label class="form-check-label" for="referral_partner-export_csv">export_csv</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_partner-entry/referral_partner/action/row/detail/:num" value="referral_partner.entry/referral_partner/action/row/detail/:num">
                                <label class="form-check-label" for="referral_partner-entry/referral_partner/action/row/detail/:num">entry/referral_partner/action/row/detail/:num</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Referral Level</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_level-read" value="referral_level.read">
                                <label class="form-check-label" for="referral_level-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_level-insert" value="referral_level.insert">
                                <label class="form-check-label" for="referral_level-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_level-update" value="referral_level.update">
                                <label class="form-check-label" for="referral_level-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_level-delete" value="referral_level.delete">
                                <label class="form-check-label" for="referral_level-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_level-export_csv" value="referral_level.export_csv">
                                <label class="form-check-label" for="referral_level-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Referral Transaction</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_transaction-read" value="referral_transaction.read">
                                <label class="form-check-label" for="referral_transaction-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_transaction-insert" value="referral_transaction.insert">
                                <label class="form-check-label" for="referral_transaction-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_transaction-update" value="referral_transaction.update">
                                <label class="form-check-label" for="referral_transaction-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_transaction-delete" value="referral_transaction.delete">
                                <label class="form-check-label" for="referral_transaction-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_transaction-export_csv" value="referral_transaction.export_csv">
                                <label class="form-check-label" for="referral_transaction-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Referral User</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-read" value="referral_user.read">
                                <label class="form-check-label" for="referral_user-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-insert" value="referral_user.insert">
                                <label class="form-check-label" for="referral_user-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-update" value="referral_user.update">
                                <label class="form-check-label" for="referral_user-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-delete" value="referral_user.delete">
                                <label class="form-check-label" for="referral_user-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-export_csv" value="referral_user.export_csv">
                                <label class="form-check-label" for="referral_user-export_csv">export_csv</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-entry/referral_user/action/top/sync_order_commision/" value="referral_user.entry/referral_user/action/top/sync_order_commision/">
                                <label class="form-check-label" for="referral_user-entry/referral_user/action/top/sync_order_commision/">entry/referral_user/action/top/sync_order_commision/</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-entry/referral_user/action/row/add_reseller/:num" value="referral_user.entry/referral_user/action/row/add_reseller/:num">
                                <label class="form-check-label" for="referral_user-entry/referral_user/action/row/add_reseller/:num">entry/referral_user/action/row/add_reseller/:num</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="referral_user-entry/referral_user/action/row/transactions/:num" value="referral_user.entry/referral_user/action/row/transactions/:num">
                                <label class="form-check-label" for="referral_user-entry/referral_user/action/row/transactions/:num">entry/referral_user/action/row/transactions/:num</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Label</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="label-read" value="label.read">
                                <label class="form-check-label" for="label-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="label-insert" value="label.insert">
                                <label class="form-check-label" for="label-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="label-update" value="label.update">
                                <label class="form-check-label" for="label-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="label-delete" value="label.delete">
                                <label class="form-check-label" for="label-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="label-export_csv" value="label.export_csv">
                                <label class="form-check-label" for="label-export_csv">export_csv</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="label-entry/label" value="label.entry/label">
                                <label class="form-check-label" for="label-entry/label">entry/label</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Course Product</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course_product-read" value="course_product.read">
                                <label class="form-check-label" for="course_product-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course_product-insert" value="course_product.insert">
                                <label class="form-check-label" for="course_product-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course_product-update" value="course_product.update">
                                <label class="form-check-label" for="course_product-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course_product-delete" value="course_product.delete">
                                <label class="form-check-label" for="course_product-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="course_product-export_csv" value="course_product.export_csv">
                                <label class="form-check-label" for="course_product-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Quiz Student</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz_student-read" value="quiz_student.read">
                                <label class="form-check-label" for="quiz_student-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz_student-insert" value="quiz_student.insert">
                                <label class="form-check-label" for="quiz_student-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz_student-update" value="quiz_student.update">
                                <label class="form-check-label" for="quiz_student-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz_student-delete" value="quiz_student.delete">
                                <label class="form-check-label" for="quiz_student-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="quiz_student-export_csv" value="quiz_student.export_csv">
                                <label class="form-check-label" for="quiz_student-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Exam</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exam-read" value="exam.read">
                                <label class="form-check-label" for="exam-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exam-insert" value="exam.insert">
                                <label class="form-check-label" for="exam-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exam-update" value="exam.update">
                                <label class="form-check-label" for="exam-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exam-delete" value="exam.delete">
                                <label class="form-check-label" for="exam-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="exam-export_csv" value="exam.export_csv">
                                <label class="form-check-label" for="exam-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Redirect</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="redirect-read" value="redirect.read">
                                <label class="form-check-label" for="redirect-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="redirect-insert" value="redirect.insert">
                                <label class="form-check-label" for="redirect-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="redirect-update" value="redirect.update">
                                <label class="form-check-label" for="redirect-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="redirect-delete" value="redirect.delete">
                                <label class="form-check-label" for="redirect-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="redirect-export_csv" value="redirect.export_csv">
                                <label class="form-check-label" for="redirect-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Downloadable</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="downloadable-read" value="downloadable.read">
                                <label class="form-check-label" for="downloadable-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="downloadable-insert" value="downloadable.insert">
                                <label class="form-check-label" for="downloadable-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="downloadable-update" value="downloadable.update">
                                <label class="form-check-label" for="downloadable-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="downloadable-delete" value="downloadable.delete">
                                <label class="form-check-label" for="downloadable-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="downloadable-export_csv" value="downloadable.export_csv">
                                <label class="form-check-label" for="downloadable-export_csv">export_csv</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="downloadable-settings" value="downloadable.settings">
                                <label class="form-check-label" for="downloadable-settings">settings</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Slider</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="slider-read" value="slider.read">
                                <label class="form-check-label" for="slider-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="slider-insert" value="slider.insert">
                                <label class="form-check-label" for="slider-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="slider-update" value="slider.update">
                                <label class="form-check-label" for="slider-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="slider-delete" value="slider.delete">
                                <label class="form-check-label" for="slider-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="slider-export_csv" value="slider.export_csv">
                                <label class="form-check-label" for="slider-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Video</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="video-read" value="video.read">
                                <label class="form-check-label" for="video-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="video-insert" value="video.insert">
                                <label class="form-check-label" for="video-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="video-update" value="video.update">
                                <label class="form-check-label" for="video-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="video-delete" value="video.delete">
                                <label class="form-check-label" for="video-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="video-export_csv" value="video.export_csv">
                                <label class="form-check-label" for="video-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Province</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="province-read" value="province.read">
                                <label class="form-check-label" for="province-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="province-insert" value="province.insert">
                                <label class="form-check-label" for="province-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="province-update" value="province.update">
                                <label class="form-check-label" for="province-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="province-delete" value="province.delete">
                                <label class="form-check-label" for="province-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="province-export_csv" value="province.export_csv">
                                <label class="form-check-label" for="province-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Regency</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="regency-read" value="regency.read">
                                <label class="form-check-label" for="regency-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="regency-insert" value="regency.insert">
                                <label class="form-check-label" for="regency-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="regency-update" value="regency.update">
                                <label class="form-check-label" for="regency-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="regency-delete" value="regency.delete">
                                <label class="form-check-label" for="regency-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="regency-export_csv" value="regency.export_csv">
                                <label class="form-check-label" for="regency-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>District</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="district-read" value="district.read">
                                <label class="form-check-label" for="district-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="district-insert" value="district.insert">
                                <label class="form-check-label" for="district-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="district-update" value="district.update">
                                <label class="form-check-label" for="district-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="district-delete" value="district.delete">
                                <label class="form-check-label" for="district-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="district-export_csv" value="district.export_csv">
                                <label class="form-check-label" for="district-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Village</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="village-read" value="village.read">
                                <label class="form-check-label" for="village-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="village-insert" value="village.insert">
                                <label class="form-check-label" for="village-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="village-update" value="village.update">
                                <label class="form-check-label" for="village-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="village-delete" value="village.delete">
                                <label class="form-check-label" for="village-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="village-export_csv" value="village.export_csv">
                                <label class="form-check-label" for="village-export_csv">export_csv</label>
                            </div>
                        </div>


                        <div class="mb-4 module">
                            <h4>Pengumuman</h4>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pengumuman-read" value="pengumuman.read">
                                <label class="form-check-label" for="pengumuman-read">read</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pengumuman-insert" value="pengumuman.insert">
                                <label class="form-check-label" for="pengumuman-insert">insert</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pengumuman-update" value="pengumuman.update">
                                <label class="form-check-label" for="pengumuman-update">update</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pengumuman-delete" value="pengumuman.delete">
                                <label class="form-check-label" for="pengumuman-delete">delete</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privileges[]" id="pengumuman-export_csv" value="pengumuman.export_csv">
                                <label class="form-check-label" for="pengumuman-export_csv">export_csv</label>
                            </div>
                        </div>


                    </div>

                </div>

                <div class="border-top pt-3 text-end">
                    <button type="submit" class="btn btn-outline-success btn-lg"><span class="bi bi-save"></span> Update</button>
                </div>
            </form>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->